<?php
$this->exportParam("title", "Luo askare");
?>
<h1>Luo askare</h1>
<p><a href="<?php echo BASE_DIR; ?>/mock/tasks">← Takaisin</a></p>
<form action="<?php echo BASE_DIR; ?>/mock/tasks/add" method="post">
	<p><label><p>Askare</p><input name="name" type="text" /></label></p>
	<p>
		<label>
			<p>Tärkeysaste</p>
			<select name="priority">
				<option value="-1">ei erityistä</option>
				<option value="1">megatärkeä [100]</option>
				<option value="2">roskakoriin [-100]</option>
			</select>
		</label>
	</p>
	<p>
		<label>
			<p>Luokitukset</p>
			<select name="categories" multiple="multiple">
				<option value="1">Ostoslista</option>
				<option value="2">Katsottavat leffat</option>
			</select>
		</label>
	</p>
	<p><input type="submit" value="Luo askare" /></p>
</form>
