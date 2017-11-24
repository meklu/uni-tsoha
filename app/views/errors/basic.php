<?php
$this->exportParam("title", "Virhe!");
?>
<h1>Virhe <?= $this->pS("code") ?>!</h1>
<p><?= $this->pS("message") ?></p>
