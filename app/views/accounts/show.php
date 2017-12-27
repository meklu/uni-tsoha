<?php
$a = $this->params["account"];
if ($a) {
	$this->exportParam("title", "Käyttäjä '{$a->nick}'");
} else {
	$this->exportParam("title", "Käyttäjää ei löytynyt!");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/accounts">← Takaisin</a></p>
<?php if ($a) { ?>
<p><a href="<?= BASE_DIR . REQ_URL ?>/edit">Muokkaa ✎</a></p>
<p><a href="<?= BASE_DIR . REQ_URL ?>/delete">Poista 🗑</a></p>
<p><p>Nimimerkki</p><p><?= htmlspecialchars($a->nick) ?></p></p>
<p><p>Ylläpitäjä</p><p><?= ($a->admin) ? "On" : "Ei" ?></p></p>
<?php }
