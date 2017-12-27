<?php
/* TODO: Ryhmittely, järjestys, jne. */
$this->exportParam("title", "Askareet");
$pT = function ($t) {
?>
	<tr>
		<td><a href="<?= BASE_DIR . REQ_URL . "/{$t->id}" ?>"><?= htmlspecialchars($t->task) ?></a></td>
		<td><?= htmlspecialchars($this->params["priorities"][$t->priority_id]->name) ?></td>
	</tr>
<?php
};
$pC = function ($title) {
?>
<thead>
	<tr>
		<th><?= htmlspecialchars($title) ?></th>
		<th></th>
	</tr>
</thead>
<?php
};
?>
<h1>Muistilista</h1>
<p><a href="<?= BASE_DIR ?>/tasks/add">+ Luo askare</a></p>
<table>
<?php
	$pC("Askareet");

	echo "<tbody>\n";
	$usedCats = array();
	foreach ($this->params["tasks"] as $t) {
		foreach ($t->categories as $c) {
			if (!isset($usedCats[$c])) {
				$usedCats[$c] = array();
			}
			$usedCats[$c][] = $t;
		}
		if (count($t->categories) !== 0) { continue; }
		$pT($t);
	}
	echo "</tbody>\n";

	foreach ($this->params["categories"] as $c) {
		if (!isset($usedCats[$c->id])) { continue; }
		$pC($c->name);
		echo "<tbody>\n";
		foreach ($usedCats[$c->id] as $t) {
			$pT($t);
		}
		echo "</tbody>\n";
	}
?>
</table>
