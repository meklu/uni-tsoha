<?php
$this->exportParam("title", "Käyttäjät");
?>
<h1>Käyttäjät</h1>
<table>
	<tr>
		<th>Nimimerkki</th>
		<th>Ylläpitäjä?</th>
		<th><a href="<?php echo BASE_DIR; ?>/users/add">+</a></th>
	</tr>
	<tr>
		<td>testi</td>
		<td>On</td>
		<td><a href="#">muokkaa</a></td>
	</tr>
	<tr>
		<td>torsti</td>
		<td>Ei</td>
		<td><a href="#">muokkaa</a></td>
	</tr>
</table>
