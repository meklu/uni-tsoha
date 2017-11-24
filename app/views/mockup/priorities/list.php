<?php
$this->exportParam("title", "Tärkeysasteet");
?>
<h1>Tärkeysasteet</h1>
<table>
	<tr>
		<th>Nimi</th>
		<th>Tärkeysaste</th>
		<th><a href="<?php echo BASE_DIR; ?>/mock/priorities/add">+</a></th>
	</tr>
	<tr>
		<td>megatärkeä</td>
		<td>100</td>
		<td><a href="#">muokkaa</a></td>
	</tr>
	<tr>
		<td>roskakoriin</td>
		<td>-100</td>
		<td><a href="#">muokkaa</a></td>
	</tr>
</table>
