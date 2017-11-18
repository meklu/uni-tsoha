<?php
$this->exportParam("title", "Luo käyttäjä");
?>
<h1>Luo käyttäjä</h1>
<p><a href="<?= BASE_DIR ?>/accounts">← Takaisin</a></p>
<form action="<?= BASE_DIR ?>/accounts/add" method="post">
	<p><label>Nimimerkki <br /><input name="nick" type="text" /></label></p>
	<p><label>Salasana <br /><input name="password" type="password" /></label></p>
	<p><label>Ylläpitäjä <input name="admin" type="checkbox" /></label></p>
	<p><input type="submit" value="Luo käyttäjä" /></p>
</form>
