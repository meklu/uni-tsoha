<?php
$this->exportParam("title", "Luo tärkeysaste");
?>
<h1>Luo tärkeysaste</h1>
<p><a href="<?php echo BASE_DIR; ?>/mock/priorities">← Takaisin</a></p>
<form action="<?php echo BASE_DIR; ?>/mock/priorities/add" method="post">
	<p><label><p>Nimi</p><input name="name" type="text" /></label></p>
	<p><label><p>Tärkeysaste</p><input name="priority" type="text" /></label></p>
	<p><input type="submit" value="Luo tärkeysaste" /></p>
</form>
