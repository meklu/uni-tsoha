<?php
$this->exportParam("title", "Tärkeysasteet");
?>
<h1>Tärkeysasteet</h1>
<table>
	<thead>
		<tr>
			<th>Nimi</th>
			<th>Tärkeysaste</th>
			<th><a href="<?= BASE_DIR ?>/priorities/add">+</a></th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($this->params["priorities"] as $p) {
?>
		<tr>
			<td><?= htmlspecialchars($p->name) ?></td>
			<td><?= htmlspecialchars($p->priority) ?></td>
			<td><a href="<?= htmlspecialchars(BASE_DIR . REQ_URL . '/' . $p->id) ?>">näytä</a></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
