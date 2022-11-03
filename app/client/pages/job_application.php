<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.content{
		padding: 10px;
		background: #fff;
		margin: 20px;
	}
</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<?php
		if(postRequest('sendApplication'))
		{
			sendJobApplication($_POST);
		}
	?>

	<?php if(!Session::check('user')) : ?>
		<?php echo die('You cannot apply if you dont have an account , This page is under construction');?>
	<?php endif;?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php $job = getJob($_GET['id']);?>
		<div class="panel panel-default">

			<?php 	
				$hasApplied = false;
				if(isset($_SESSION['auth'] , $_SESSION['user']))
					$hasApplied = hasApplied($_SESSION['user']['id'], $job['id']);
			?>

			<?php if($hasApplied): ?>
			<div class="alert alert-danger">
				<p>You already applied for this job.</p>
			</div>
			<?php endif?>
			<?php Flash::show();?>
			<div class="panel-body">
				<div class="row">
					<section id="job_information" class="col-md-5">
						<h3><?php echo $job['position']?> - <?php echo $job['title']?></h3>
						<div class="job-desc">
							<div>
								<p><?php echo $job['address']?></p>
							</div>
							<div>
								<p><?php echo $job['notes']?></p>
							</div>
							<div class="row">
								<dl class="col-md-5">
									<dd><?php echo $job['email']?></dd>
									<dt>Email</dt>
									<dd><?php echo $job['phone']?></dd>
									<dt>Phone</dt>
								</dl>

								<dl class="col-md-5">
									<dd><?php echo to_money($job['salary'])?></dd>
									<dt>Salary</dt>
									<dd><?php echo $job['salary_type']?></dd>
									<dt>Salary Type</dt>
								</dl>
							</div>
						</div>
					</section>
					<section id="job_application" class="col-md-5">
						<?php $userinfo = getUser(Session::get('user')['id']);?>
						<div id="personalinfo">
							<p><strong><?php echo $userinfo['fullname']?></strong> <br>
							Email : <?php echo $userinfo['email']?> | Phone : <?php echo $userinfo['phone']?></p>
						</div>
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
							<div class="form-group">
								<label>Make your pitch <sup>*</sup> </label>
								<small>Minimum of 50 characters</small>
								<textarea class="form-control" rows="10" name="applicant_pitch"><?php echo $_POST['applicant_pitch'] ?? '' ?></textarea>
							</div>

							<div class="form-group">
								<label>Image Type Resume</label>
								<input type="file" name="resume_image">
								<small>Jpeg , PNG only</small>
							</div>

							<div class="form-group">
								<label>Text type Resume</label>
								<input type="file" name="resume_text">
								<small>Word / PDF</small>
							</div>
							<input type="submit" name="sendApplication" class="btn btn-primary" value="Send Application">
						</form>
					</section>
				</div>
			</div>
		</div>
		

		<div class="row">
		
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>