<?php
$this->exportParam("title", "Käyttäjät");
?>
<h1>Käyttäjät</h1>
<table>
	<thead>
		<tr>
			<th>Nimimerkki</th>
			<th>Ylläpitäjä?</th>
			<th><a href="<?= BASE_DIR ?>/accounts/add">+</a></th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($this->params["accounts"] as $a) {
?>
		<tr>
			<td><?= htmlspecialchars($a->nick) ?></td>
			<td><?= ($a->admin) ? "On" : "Ei" ?></td>
			<td><a href="<?= BASE_DIR . "/accounts/{$a->id}" ?>">näytä</a></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
