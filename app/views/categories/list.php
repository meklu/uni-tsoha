<?php
$this->exportParam("title", "Luokitukset");
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<table>
	<thead>
		<tr>
			<th>Nimi</th>
			<th><a href="<?= BASE_DIR ?>/categories/add">+</a></th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($this->params["categories"] as $p) {
?>
		<tr>
			<td><?= htmlspecialchars($p->name) ?></td>
			<td><a href="<?= htmlspecialchars(BASE_DIR . REQ_URL . '/' . $p->id) ?>">näytä</a></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
