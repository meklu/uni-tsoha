<?php
$this->exportParam("title", "Luo luokitus");
?>
<h1>Luo luokitus</h1>
<p><a href="<?php echo BASE_DIR; ?>/categories">← Takaisin</a></p>
<form action="<?php echo BASE_DIR; ?>/categories/add" method="post">
	<p><label><p>Nimi</p><input name="name" type="text" /></label></p>
	<p><input type="submit" value="Luo luokitus" /></p>
</form>
