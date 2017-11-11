<?php

/** Kohtuullisen yksinkertainen reititin. Riippuvainen boot.php:n vakioista.  */
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

	function __construct() {
		$this->r = array();
	}

	function routes() {
		return $this->r;
	}

	function pathparts($path) {
		return explode("/", ltrim($path, "/"));
	}

	/* Reitin lisäys */
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
			if (!isset($pos["children"][$p])) {
				$pos["children"][$p] = array(
					"f" => null,
					"children" => array()
				);
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

	/** Reitin seuranta */
	/* TODO: esim. /foo/:id */
	function run() {
		$checkm = strtolower(REQ_METHOD);
		$pos = $this->r[$checkm];
		foreach (APP_ROUTE as $p) {
			if (!isset($pos["children"][$p])) {
				throw new Exception("Path not found in route");
			}
			$pos = $pos["children"][$p];
		}
		if (is_callable($pos["f"])) {
			$pos["f"]();
		} else {
			throw new Exception("Resolved route has no callable!");
		}
	}
}
