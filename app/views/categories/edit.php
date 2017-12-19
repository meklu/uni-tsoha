<?php
$p = $this->params["category"];
if ($p) {
	$this->exportParam("title", "Muokataan luokitusta '{$p->name}'");
} else {
	$this->exportParam("title", "Luokitusta ei löytynyt!");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/categories">← Takaisin</a></p>
<p><a href="<?= BASE_DIR ?>/categories/<?= $p->id ?>">Peru</a></p>
<?php if ($p) { ?>
<form action="<?= BASE_DIR . REQ_URL ?>" method="post">
	<p><label>Nimi <br /><input name="name" type="text" value="<?= htmlspecialchars($this->pA("name", $p)) ?>" /></label></p>
	<p><input type="submit" value="Päivitä luokitus" /></p>
</form>
<?php }
