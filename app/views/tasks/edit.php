<?php
$t = $this->params["task"];
if ($t) {
	$this->exportParam("title", "Muokataan askaretta '{$t->task}'");
} else {
	$this->exportParam("title", "Ei löytynyt! - Askareet");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/tasks">← Takaisin</a></p>
<p><a href="<?= BASE_DIR ?>/tasks/<?= $t->id ?>">Peru ×</a></p>
<form action="<?= BASE_DIR . REQ_URL ?>" method="post">
	<p><label><p>Askare</p><input name="task" type="text" value="<?= htmlspecialchars($this->pA("task", $t)) ?>" /></label></p>
	<p>
		<label>
			<p>Tärkeysaste</p>
			<select name="priority_id">
				<option value="-1">ei erityistä</option>
<?php
			foreach ($this->params["priorities"] as $p) {
?>
				<option value="<?= $p->id ?>"<?= "" !== $this->pA("priority_id", $t) ? " selected=\"selected\"" : "" ?>><?= htmlspecialchars($p->name) . " [{$p->priority}]" ?></option>
<?php
			}
?>
			</select>
		</label>
	</p>
	<p>
		<label>
			<p>Luokitukset</p>
			<select name="categories[]" multiple="multiple">
<?php
			$lkup = array_flip((array) $this->pA("categories", $t));
			foreach ($this->params["categories"] as $c) {
?>
				<option value="<?= $c->id ?>"<?= isset($lkup[$c->id]) ? " selected=\"selected\"" : "" ?>><?= htmlspecialchars($c->name) ?></option>
<?php
			}
?>
			</select>
		</label>
	</p>
	<p><input type="submit" value="Päivitä askare" /></p>
</form>
