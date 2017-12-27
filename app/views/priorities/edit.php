<?php
$p = $this->params["priority"];
if ($p) {
	$this->exportParam("title", "Muokataan tärkeysastetta '{$p->name}'");
} else {
	$this->exportParam("title", "Tärkeysastetta ei löytynyt!");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/priorities">← Takaisin</a></p>
<p><a href="<?= BASE_DIR ?>/priorities/<?= $p->id ?>">Peru ×</a></p>
<?php if ($p) { ?>
<form action="<?= BASE_DIR . REQ_URL ?>" method="post">
	<p><label>Nimi <br /><input name="name" type="text" value="<?= htmlspecialchars($this->pA("name", $p)) ?>" /></label></p>
	<p><label>Tärkeysaste <br /><input name="priority" type="text" value="<?= htmlspecialchars($this->pA("priority", $p)) ?>" /></label></p>
	<p><input type="submit" value="Päivitä tärkeysaste" /></p>
</form>
<?php }
