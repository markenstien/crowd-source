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
	if(postRequest('createExam'))
	{
		examCreate($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Exam Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading"> Exam EDIT </div>
			<div class="panel-body">
				<h1> PAGE IS UNDER DEVELOPMENT </h1>
				<!-- <div class="col-md-5">
					<form method="post">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control">	
						</div>

						<div class="form-group">
							<label>Description</label>
							<input type="text" name="desc" class="form-control">	
						</div>

						<div class="form-group">
							<label>Duration</label>
							<input type="text" name="duration" class="form-control" placeholder="eg. 3:30">	
							<small>Always use the hour:min syntax</small>
						</div>

						<input type="submit" name="createExam" class="btn btn-primary" value="Create Exam">
					</form>
				</div> -->
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>