<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php'?>

<style type="text/css">
	.content-divider
	{
		border-bottom: 1px solid #000;
		padding: 10px 0px;
	}

	section h3 
	{
		border-bottom: 1px solid #000;
		width: 300px;
	}
</style>
</head>
<body>
<?php 

	if(postRequest('cancelJobApplication'))
	{
		//cancel application
		updateApplicationStatus($_POST['applicationid'] , 'cancelled');
	}
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php  $ja = new JobApplication($_GET['id']) ;?>

		<?php
			$jaInfo   = $ja->getJobApplicationInfo();
			$job      = $ja->getJobInfo();
			$exam     = $ja->getJobExam($job['id']);
			$company  = $ja->getCompany();
			$applicant = $ja->getApplicantInfo();

			$applicant = [
				'personal'        => $applicant->getPersonal(),
				'workExperiences' => $applicant->getWorkExperience(),
				'skills'          => $applicant->getSkills(),
				'education'       => $applicant->getEducation()
			];

			$applicationExam = getApplicationExam($_GET['id']);
		?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job View
			</div>

			<div class="panel-body">
				<div class="alert alert-info">
					Application Status : <strong><?php echo $jaInfo['status']?></strong>
				</div>
				<div class="row">
					<section class="col-md-6">
						<div class="content-divider">
							<h3>Job</h3>
							<div>- Title : <?php echo $job['title']?></div>
							<div>- Sub : <?php echo $job['sub_title']?></div>
							<div>- Position : <?php echo $job['position']?></div>
							<div>- Salary : <?php echo $job['salary']?></div>
							<div>- Salary Type : <?php echo $job['salary_type']?></div>

							<div>
								<?php if(!empty($exam)) :?>

									<?php if(!empty($applicationExam)) :?>
										<?php if($applicationExam['status'] == 'finished') :?>
											<a href="examination_result.php?applicationExamId=<?php echo $applicationExam['id']?>">View Result</a>
										<?php endif;?>

										<?php if($applicationExam['status'] == 'unfinish'):?>
											<p>You have an unfinished examination, inquire the employer if you want to re-take the examination</p>
										<?php endif;?>

									<?php else:?>
										<a href="take_exam.php?applicationid=<?php echo $jaInfo['id']?>">Take Exam</a>
									<?php endif;?>
								<?php else:?>
									<a href="#">No Exam</a>
								<?php endif;?>
							</div>
						</div>

						<div class="content-divider">
							<h3>Application</h3>
							<div>
								<div>
									- Date applied : <?php echo $jaInfo['date_applied']?>
								</div>
								<div>
									- Resume Image: <a href="viewer.php?src=<?php echo $jaInfo['resume_image']?>" target="_blank">Resume</a>
								</div>
								<div>
									- Resume Text: <a href="viewer.php?src=<?php echo $jaInfo['resume_text']?>" target="_blank">Resume</a>
								</div>

								<div>
									- <strong>Pitch</strong>
									<p>
										<?php echo $jaInfo['applicant_pitch']?>
									</p>
								</div>
							</div>
						</div>
					</section>
				</div>
				
				<div class="row">
					<section class="container-fluid">
						<div class="content-divider">
							<h3>Company</h3>
							<a href="#">Preview</a>
							<div>
								- <h4>Company : <?php echo $company['name']?></h4>
							</div>
							<div>- Type : <?php echo $company['type']?></div>
							<div>- Phone : <?php echo $company['phone']?></div>
							<div>- Email : <?php echo $company['email']?></div>
							<div>- Address : <?php echo $company['address']?></div>
						</div>
					</section>
				</div>

				<?php if($jaInfo['status'] != 'cancelled') :?>
				<section>
					<h3 class="text-danger">Danger Zone</h3>
					<form method="post" action="">
						<input type="hidden" name="applicationid" value="<?php echo $jaInfo['id']?>">
						<input type="submit" name="cancelJobApplication" class="btn btn-danger" value="Cancel Application">
						<div>
							<small>You cannot re-apply once you cancel your application.</small>
						</div>
					</form>
				</section>
				<?php else:?>
					<h3 class="text-danger">Job Application has been cancelled</h3>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>