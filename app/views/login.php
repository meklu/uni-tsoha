<?php
$this->exportParam("title", "Kirjaudu sisään");
?>
<div id="login-container">
	<h1>Muistilista</h1>
	<form action="<?php echo BASE_DIR; ?>/login" method="post">
		<p><label><p>Käyttäjätunnus</p><input name="user" type="text" value="<?= htmlspecialchars($this->pA("nick")) ?>" /></label></p>
		<p><label><p>Salasana</p><input name="pass" type="password" /></label></p>
		<p><input type="submit" value="Kirjaudu sisään" /></p>
	</form>
</div>
