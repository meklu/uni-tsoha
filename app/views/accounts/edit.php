<?php
$a = $this->params["account"];
if ($a) {
	$this->exportParam("title", "Muokataan käyttäjää '{$a->nick}'");
} else {
	$this->exportParam("title", "Käyttäjää ei löytynyt!");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/accounts">← Takaisin</a></p>
<p><a href="<?= BASE_DIR ?>/accounts/<?= $a->id ?>">Peru</a></p>
<?php if ($a) { ?>
<form action="<?= BASE_DIR . REQ_URL ?>" method="post">
	<p><label>Nimimerkki <br /><input name="nick" type="text" value="<?= htmlspecialchars($a->nick) ?>" /></label></p>
	<p><label>Salasana <br /><input name="password" type="password" /></label></p>
	<p><label>Ylläpitäjä <input name="admin" type="checkbox" <?= ($a->admin) ? "checked=\"checked\"" : "" ?> /></label></p>
	<p><input type="submit" value="Päivitä käyttäjä" /></p>
</form>
<?php }
