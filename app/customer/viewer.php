<?php require_once '../dependencies.php' ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		embed{
			width: 100%;
			min-height: 100vh;
		}
	</style>
</head>
<body>

	<embed src="<?php echo URL.DS.'public/assets/'.$_GET['src']?>"></embed>
</body>
</html>