<?php
$this->exportParam("title", "Luo käyttäjä");
?>
<h1>Luo käyttäjä</h1>
<p><a href="<?php echo BASE_DIR; ?>/users">← Takaisin</a></p>
<form action="<?php echo BASE_DIR; ?>/users/add" method="post">
	<p><label><p>Käyttäjätunnus</p><input name="user" type="text" /></label></p>
	<p><label><p>Salasana</p><input name="pass" type="password" /></label></p>
	<p><label><p>Ylläpitäjä</p><input name="admin" type="checkbox" /></label></p>
	<p><input type="submit" value="Luo käyttäjä" /></p>
</form>
