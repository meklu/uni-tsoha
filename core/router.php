<?php

/** Kohtuullisen yksinkertainen reititin. Riippuvainen boot.php:n vakioista.
 *
 * Tukee myös "/foo/:bar" -notaatiota reittipoluille. */
class Router {
	/* array(
	 *    "get" => array(
	 *       # /
	 *       "f" => <func>,
	 *       "children" => array(
	 *          # /<pathpart
	 *          "<pathpart>" => array(
	 *             "f" => <func>,
	 *             "children" => array(...)
	 *          ),
	 *       ),
	 *       ...
	 *    ),
	 *    "post" => array(...),
	 *    ...
	 * ) */
	protected $r;
	/* array(
	 *    403 => <func>,
	 *    404 => <func>,
	 *    500 => <func>,
	 *    ...
	 * ) */
	protected $err;

	function __construct() {
		$this->r = array();
		$this->err = array();
	}

	function routes() {
		return $this->r;
	}

	function errors() {
		return $this->err;
	}

	function pathparts($path) {
		return explode("/", ltrim($path, "/"));
	}

	/** Reitin lisäys */
	protected function add($reqtype, $path, $func) {
		$ok = array("get", "post", "delete", "put");
		$lkup = array_flip($ok);
		if (!isset($lkup[$reqtype])) {
			throw new Exception("Request method '$reqtype' not allowed for route");
		}

		if (!isset($this->r[$reqtype])) {
			$this->r[$reqtype] = array(
				"f" => null,
				"children" => array()
			);
		}
		$parts = $this->pathparts($path);
		$pos = &$this->r[$reqtype];
		foreach ($parts as $p) {
			unset($key);
			if (strlen($p) > 0 && $p[0] === ':') {
				$key = substr($p, 1);
				$p = $p[0];
			}
			if (!isset($pos["children"][$p])) {
				$pos["children"][$p] = array(
					"f" => null,
					"children" => array()
				);
				if (isset($key)) {
					$pos["children"][$p]["key"] = $key;
				}
			}
			$pos = &$pos["children"][$p];
		}
		$pos["f"] = $func;
	}

	function get($path, $func) {
		$this->add("get", $path, $func);
	}

	function post($path, $func) {
		$this->add("post", $path, $func);
	}

	function delete($path, $func) {
		$this->add("delete", $path, $func);
	}

	function put($path, $func) {
		$this->add("put", $path, $func);
	}

	/** Virhereitin lisäys
	 * Koskee vain heitettyjä ongelmia */
	function error($code, $func) {
		$this->err[$code] = $func;
	}

	protected function _run() {
		$checkm = strtolower(REQ_METHOD);
		$pos = $this->r[$checkm];
		$attr = array();
		foreach (APP_ROUTE as $p) {
			if (!isset($pos["children"][$p])) {
				if (!isset($pos["children"][':'])) {
					http_response_code(404);
					throw new Exception("Path not found in route");
				}
				$attr[$pos["children"][':']["key"]] = $p;
				$p = ':';
			}
			$pos = $pos["children"][$p];
		}
		if (is_callable($pos["f"])) {
			$pos["f"]($attr);
		} else {
			http_response_code(404);
			throw new Exception("Resolved route has no callable!");
		}
	}

	/** Reitin seuranta */
	function run() {
		try {
			$this->_run();
		} catch (Exception $e) {
			$errno = http_response_code();
			if ($errno === 200) {
				$errno = 500;
				http_response_code($errno);
			}
			if (isset($this->err[$errno]) && is_callable($this->err[$errno])) {
				$this->err[$errno]($e);
			}
		}
	}
}
