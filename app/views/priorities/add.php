<?php
$this->exportParam("title", "Luo tärkeysaste");
?>
<h1>Luo tärkeysaste</h1>
<p><a href="<?= BASE_DIR ?>/priorities">← Takaisin</a></p>
<form action="<?= BASE_DIR ?>/priorities/add" method="post">
	<p><label>Nimi <br /><input name="name" type="text" value="<?= htmlspecialchars($this->pA("name")) ?>" /></label></p>
	<p><label>Tärkeysaste <br /><input name="priority" type="text" value="<?= htmlspecialchars($this->pA("priority")) ?>" /></label></p>
	<p><input type="submit" value="Luo tärkeysaste" /></p>
</form>
