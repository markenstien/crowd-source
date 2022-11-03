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
	if(postRequest('update'))
	{
		updateCategory($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Category Management') ;?>
		<?php $category = getCategory($_GET['id']);?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Category Information
			</div>
			<div class="panel-body">
				<form method="post" action="" class="col-md-5">
					<input type="hidden" name="catid" value="<?php echo $category['id']?>">
					<div class="form-group">
						<label>Category</label>
						<input type="" name="category" class="form-control" 
						value="<?php echo $category['category']?>">
					</div>
					<div class="form-group">
						<label>Description</label>
						<input type="" name="description" class="form-control" 
						value="<?php echo $category['description']?>">
					</div>
					<input type="submit" name="update" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>