<?php

class Asset {
	/** Laskee jonkin staattisen tiedostoresurssin polun sekä lisää perään
	 * muokkausaikaparametrin selainvälimuistin hassuuksien välttämiseksi */
	public static function calc($path) {
		$s = stat("assets/{$path}");
		return BASE_DIR . "/assets/{$path}?ts={$s["mtime"]}";
	}
}
