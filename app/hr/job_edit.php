<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php
	if(postRequest('update'))
	{
		updateJob($_POST);
	}

	if(postRequest('postJob')){

		postJob($_POST['jobid']);
	}

	if(postRequest('cancelJob'))
	{
		cancelJob($_POST['jobid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $job = getJob($_GET['id']) ;?>

		<?php  $job_cat_list = getJobPostCategory($_GET['id']);?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job information
			</div>
			<div class="panel-body">
				<form class="container-fluid" method="post">
					<h3>Actions</h3>
					<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
					<div class="form-group inline-block">
						<input type="submit" name="postJob" value="Post Job">
					</div>
					<div class="form-group inline-block">
						<input type="submit" name="cancelJob" value="Cancel">
					</div>
				</form>

				<hr>
				<form method="post" action="" class="col-md-12">
					<input type="hidden" name="jobid" class="form-control" 
							 value="<?php echo $job['id']?>">
					<fieldset class="col-md-6">
						<legend>General</legend>
						<div class="form-group">
							<label>Status</label>
							<input type="text" name="status" class="form-control" 
							 value="<?php echo $job['status']?>" readonly>
						</div>

						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" 
							 value="<?php echo $job['title']?>">
						</div>
						<div class="form-group">
							<label>Sub Title</label>
							<input type="text" name="sub_title" class="form-control" 
							value="<?php echo $job['sub_title']?>">
						</div>

						<div class="form-group">
							<label>Category</label>
							<div></div>
							<?php foreach($job_cat_list as $cat) :?>
								<label class="space-up">
									<input type="checkbox" name="categories[]" value="<?php echo $cat['id']?>" checked>
									<?php echo $cat['category'];?>
								</label>
							<?php endforeach;?>
						</div>

						<div class="form-group">
							<label>Position</label>
							<input type="text" name="position" class="form-control" 
							value="<?php echo $job['position']?>">
						</div>

						<div class="form-group">
							<label>Others</label>
							<textarea class="form-control" rows="10" name="notes"><?php echo $job['notes']?></textarea>
							<small>Important information that will help applicants</small>
						</div>
						<input type="submit" name="update" class="btn btn-success" value="Update Job">
					</fieldset>
					
					<fieldset class="col-md-6">
						<legend>Company</legend>
						<div class="form-group">
							<label>Company</label>
							<input type="text" name="company" class="form-control" value="<?php echo $job['comp_name']?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" class="form-control" value="<?php echo $job['email']?>">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" value="<?php echo $job['phone']?>">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" value="<?php echo $job['address']?>">
						</div>
					</fieldset>	
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>