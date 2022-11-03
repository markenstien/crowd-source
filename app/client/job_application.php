<?php 	
	require_once '../dependencies.php';

	if(postRequest('sendApplication'))
		sendJobApplication($_POST);

	$job = getJob($_GET['id']);
?>

<?php build('content') ?>
	
	<?php $user = auth()?>
	<div id="wrapper" class="container-fluid">
		<div style="margin-top: 50px;"></div>
		<div class="row">
			<div class="col-md-5">
				<div class="card card-theme-dark">
					<div class="card-header">
						<h4 class="card-title">Job Details</h4>
					</div>

					<div class="card-body">
						<?php if(!$user) : ?>
							<div class="alert alert-danger">
								<h5>You must have an account to apply</h5>
							</div>
						<?php endif;?>

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
					</div>
				</div>
			</div>

			<div class="col-md-7">
				<div class="card card-theme-dark">
					<div class="card-header">
						<h4 class="card-title">Application Form</h4>
					</div>
					<?php Flash::show()?>
					<div class="card-body">
						<?php 
							$hasApplied = false;
							if(isEqual($user['type'] , 'applicant'))
								$hasApplied = hasApplied($user['id'] , $job['id']);
						?>

						<?php if($hasApplied): ?>
							<div class="alert alert-danger ">
								<p>You already applied for this job.</p>
							</div>
						<?php endif?>

						<?php $userinfo = getUser($user['id']);?>
						<div id="personalinfo">
							<p><strong><?php echo $userinfo['fullname']?></strong> <br>
							Email : <?php echo $userinfo['email']?> | Phone : <?php echo $userinfo['phone']?></p>
						</div>
						<form method="post" enctype="multipart/form-data">
							<?php 
								FormSave();
								FormHidden('jobid' , $job['id']);
							?>
							<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
							<div class="form-group">
								<?php
									FormLabel('Make your pitch *');
										FormTextarea('applicant_pitch' , '' , [
										'class' => 'form-control',
										'rows'  => 5,
										'required' => '',
										'placeholder' => 'Tell us why you are the best candidate for the position..'
									]);
								?>
								<small></small>
							</div>

							<div class="form-group">
								<?php
									FormLabel('Image type Resume');
									FormFile('resume_image' , ['class' => 'form-control']);
								?>
								<small>Jpeg , PNG only</small>
							</div>

							<div class="form-group">
								<?php
									FormLabel('Text Type Resume * ');
									FormFile('resume_text' , ['class' => 'form-control' , 'required' => '']);
								?>
								<small>Word / PDF</small>
							</div>

							<input type="submit" name="sendApplication" class="btn btn-primary" value="Send Application">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php loadTo('orbit/index.php')?>