<?php
# Parametreina
#	title : string
#	content : html
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
			<?php $this->pH("content"); ?>
		</div>
	</body>
</html>
