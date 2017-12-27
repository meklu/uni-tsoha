<?php
$t = $this->params["task"];
if ($t) {
	$this->exportParam("title", $t->task . " - Askareet");
	$p = $this->params["priority"];
} else {
	$this->exportParam("title", "Ei löytynyt! - Askareet");
}
?>
<h1><?= htmlspecialchars($this->exportParams["title"]) ?></h1>
<p><a href="<?= BASE_DIR ?>/tasks">← Takaisin</a></p>
<p><a href="<?= BASE_DIR . REQ_URL ?>/edit">Muokkaa ✎</a></p>
<p><a href="<?= BASE_DIR . REQ_URL ?>/delete">Poista 🗑</a></p>
<?php if ($t) { ?>
	<p><label><p>Askare</p><p><?= htmlspecialchars($this->pA("task", $t)) ?></p></label></p>
	<p>
		<label>
			<p>Tärkeysaste</p>
			<p><?= $p ? htmlspecialchars($p->name) . " [{$p->priority}]" : "ei erityistä" ?></p>
		</label>
	</p>
	<p>
		<label>
			<p>Luokitukset</p>
	<?php
			foreach ($t->categoriesObj as $c) {
	?>
				<p><?= htmlspecialchars($c->name) ?></p>
	<?php
			}
	?>
		</label>
	</p>
<?php } ?>
