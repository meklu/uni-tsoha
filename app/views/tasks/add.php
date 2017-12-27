<?php
$this->exportParam("title", "Luo askare");
?>
<h1>Luo askare</h1>
<p><a href="<?= BASE_DIR ?>/tasks">← Takaisin</a></p>
<form action="<?= BASE_DIR ?>/tasks/add" method="post">
	<p><label><p>Askare</p><input name="task" type="text" value="<?= htmlspecialchars($this->pA("task")) ?>" /></label></p>
	<p>
		<label>
			<p>Tärkeysaste</p>
			<select name="priority_id">
				<option value="-1">ei erityistä</option>
<?php
			foreach ($this->params["priorities"] as $p) {
?>
				<option value="<?= $p->id ?>"<?= $p->id === intval($this->pA("priority_id")) ? " selected=\"selected\"" : "" ?>><?= htmlspecialchars($p->name) . " [{$p->priority}]" ?></option>
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
			$lkup = array_flip((array) $this->pA("categories"));
			foreach ($this->params["categories"] as $c) {
?>
				<option value="<?= $c->id ?>"<?= isset($lkup[$c->id]) ? " selected=\"selected\"" : "" ?>><?= htmlspecialchars($c->name) ?></option>
<?php
			}
?>
			</select>
		</label>
	</p>
	<p><input type="submit" value="Luo askare" /></p>
</form>
