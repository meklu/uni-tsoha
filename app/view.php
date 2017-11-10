<?php

class View {
	protected $path;
	protected $params;
	protected $exportParams;
	protected $renderCache;
	protected $alwaysRender;

	function __construct($path, $alwaysRender = false) {
		$this->path = __DIR__ . "/views/" . $path . ".php";
		$this->params = array();
		$this->exportParams = array();
		$this->renderCache = array();
		$this->alwaysRender = $alwaysRender;
	}

	/** Asettaa näkymälle parametrin */
	function setParam($key, $value) {
		$this->params[$key] = $value;
	}

	/** Asettaa vientiparametrin (kutsutaan näkymän piirtämisen yhteydessä) */
	function exportParam($key, $value) {
		$this->exportParams[$key] = $value;
	}

	/** Piirtää näkymän käyttäen $this:n välimuistia */
	function cachedRender($vkey) {
		if (!isset($this->renderCache[$vkey]) || $this->params[$vkey]->alwaysRender) {
			$this->renderCache[$vkey] = $this->params[$vkey]->render();
		}
		return $this->renderCache[$vkey];
	}

	/** Tuo jonkin näkymän vientiparametrit */
	function importParams($vkey) {
		/* Rendataan ensin parametrien generoimiseksi */
		$this->cachedRender($vkey);
		/* Tuodaan arvot */
		foreach ($this->params[$vkey]->exportParams as $k => $v) {
			$this->setParam($k, $v);
		}
	}

	/** Tulostaa merkkijonoparametrin $key turvallisesti */
	function pS($key) {
		echo htmlspecialchars($this->params[$key]);
	}

	/** Tulostaa HTML-parametrin $key, ts. raa'an merkkijonon, tai näkymäparametrin */
	function pH($key) {
		if (is_string($this->params[$key])) {
			echo $this->params[$key];
		} else if (is_a($this->params[$key], "View")) {
			echo $this->cachedRender($key);
		}
	}

	/** Palauttaa merkkijonon! */
	function render() {
		foreach ($this->params as $k => $v) {
			if (is_a($v, "View")) {
				$this->importParams($k);
			}
		}
		unset($p);
		ob_start();
		include $this->path;
		return ob_get_clean();
	}
}
