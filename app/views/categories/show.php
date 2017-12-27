<?php
$p = $this->params["category"];
if ($p) {
	$this->exportParam("title", $p->name . " - Luokitukset");
} else {
	$this->exportParam("title", "Ei löytynyt! - Luokitukset");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/categories">← Takaisin</a></p>
<?php if ($p) { ?>
<p><a href="<?= BASE_DIR . REQ_URL ?>/edit">Muokkaa ✎</a></p>
<p><a href="<?= BASE_DIR . REQ_URL ?>/delete">Poista 🗑</a></p>
<p>Nimi</p> <p><?= htmlspecialchars($p->name) ?></p>
<?php }
