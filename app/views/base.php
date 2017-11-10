<?php
# Parametreina
#	title : string
#	content : html
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR; ?>/assets/site.css" />
		<title><?php $this->pS("title"); ?></title>
	</head>
	<body>
		<?php $this->pH("content"); ?>
	</body>
</html>
