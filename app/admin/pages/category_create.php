<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}
</style>
</head>
<body>
<?php
	if(postRequest('create'))
	{
		createCategory($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Category Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Category Information
			</div>
			<div class="panel-body">
				<form method="post" action="" class="col-md-5">
					<div class="form-group">
						<label>Category</label>
						<input type="" name="category" class="form-control">
					</div>
					<div class="form-group">
						<label>Description</label>
						<input type="" name="description" class="form-control">
					</div>
					<input type="submit" name="create" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>