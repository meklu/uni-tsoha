<?php
$this->exportParam("title", "Luo luokitus");
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/categories">← Takaisin</a></p>
<form action="<?= BASE_DIR ?>/categories/add" method="post">
	<p><label>Nimi <br /><input name="name" type="text" value="<?= htmlspecialchars($this->pA("name")) ?>" /></label></p>
	<p><input type="submit" value="Luo luokitus" /></p>
</form>
