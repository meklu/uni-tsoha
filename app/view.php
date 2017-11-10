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

	/** Tuo jonkin näkymän vientiparametrit */
	function importParams($view) {
		/* Rendataan ensin parametrien generoimiseksi */
		$view->render();
		/* Tuodaan arvot */
		foreach ($view->exportParams as $k => $v) {
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
			if (!isset($this->renderCache[$key]) || $this->params[$key]->alwaysRender) {
				$this->renderCache[$key] = $this->params[$key]->render();
			}
			echo $this->renderCache[$key];
		}
	}

	/** Palauttaa merkkijonon! */
	function render() {
		foreach ($this->params as $p) {
			if (is_a($p, "View")) {
				$this->importParams($p);
			}
		}
		unset($p);
		ob_start();
		include $this->path;
		return ob_get_clean();
	}
}
