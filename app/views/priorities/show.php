<?php
$p = $this->params["priority"];
if ($p) {
	$this->exportParam("title", $p->name . " - Tärkeysasteet");
} else {
	$this->exportParam("title", "Ei löytynyt! - Tärkeysasteet");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/priorities">← Takaisin</a></p>
<?php if ($p) { ?>
<p><a href="<?= BASE_DIR . REQ_URL ?>/edit">Muokkaa</a></p>
<p><a href="<?= BASE_DIR . REQ_URL ?>/delete">Poista</a></p>
<p>Nimi</p> <p><?= htmlspecialchars($p->name) ?></p>
<p>Tärkeysaste</p> <p><?= htmlspecialchars($p->priority) ?></p>
<?php }
