<?php
# Parametreina
#	title : string
#	content : html

$user = Controller::get_current_user();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= Asset::calc("site.css") ?>" />
		<title><?php $this->pS("title"); ?> - Muistilista</title>
	</head>
	<body>
		<div id="main-container">
			<?php if (isset($_SESSION["userid"])) { ?>
				<nav>
					<a href="<?= BASE_DIR ?>/tasks">Askareet</a>
					<a href="<?= BASE_DIR ?>/priorities">Tärkeysasteet</a>
					<a href="<?= BASE_DIR ?>/categories">Luokitukset</a>
					<?php if ($user->admin) { ?>
						<a href="<?= BASE_DIR ?>/accounts">Käyttäjät</a>
					<?php } ?>
					<a href="<?= BASE_DIR ?>/accounts/<?= $user->id ?>">Oma käyttäjätili</a>
					<form class="float-right" action="<?= BASE_DIR ?>/logout" method="post">
						<input type="submit" value="Kirjaudu ulos" />
					</form>
				</nav>
			<?php } ?>
			<?php if (!isset($this->params["dirty"])) { ?>
				<?php if (isset($_SESSION[REQ_URL]["errors"])) { ?>
				<div class="status-msg error-block" id="errors">
					<?php foreach ($_SESSION[REQ_URL]["errors"] as $err) { ?>
					<p><?= htmlspecialchars($err) ?></p>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if (isset($_SESSION[REQ_URL]["warnings"])) { ?>
				<div class="status-msg warning-block" id="warnings">
					<?php foreach ($_SESSION[REQ_URL]["warnings"] as $warn) { ?>
					<p><?= htmlspecialchars($warn) ?></p>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if (isset($_SESSION[REQ_URL]["success"])) { ?>
				<div class="status-msg success-block" id="success">
					<?php foreach ($_SESSION[REQ_URL]["success"] as $succ) { ?>
					<p><?= htmlspecialchars($succ) ?></p>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if (isset($_SESSION[REQ_URL]["info"])) { ?>
				<div class="status-msg info-block" id="info">
					<?php foreach ($_SESSION[REQ_URL]["info"] as $inf) { ?>
					<p><?= htmlspecialchars($inf) ?></p>
					<?php } ?>
				</div>
				<?php } unset($_SESSION[REQ_URL]); ?>
			<?php } ?>
			<?php $this->pH("content"); ?>
		</div>
	</body>
</html>
