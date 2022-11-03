<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>

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
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $ja = new JobApplication($_GET['id']) ;?>

		<?php
			$jaInfo   = $ja->getJobApplicationInfo();
			$job      = $ja->getJobInfo();
			$company  = $ja->getCompany();
			$applicant = $ja->getApplicantInfo();

			$applicant = [
				'personal'        => $applicant->getPersonal(),
				'workExperiences' => $applicant->getWorkExperience(),
				'skills'          => $applicant->getSkills(),
				'education'       => $applicant->getEducation()
			];

		?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job View
			</div>

			<div class="panel-body">

				<div class="row">
					<section class="col-md-6">
						<h3>Applicant</h3>
						<a href="#">Preview</a>
						<div class="content-divider">
							<?php extract($applicant);?>
							<h4>Personal</h4>
							<ul>
								<li>Firstname : <?php echo $personal['firstname']?></li>
								<li>Lastname : <?php echo $personal['lastname']?></li>
								<li>Gender : <?php echo $personal['gender']?></li>
								<li>Birthday : <?php echo $personal['birthday']?></li>
							</ul>
						</div>

						<div class="content-divider">
							<h4>Education</h4>
							<ul>
								<li>Highest Attainment : <?php echo $education['highest_attainment']?></li>
								<li>Year : <?php echo $education['year']?></li>
								<li>School : <?php echo $education['school']?></li>
								<li>Status : <?php echo $education['status']?></li>
							</ul>
						</div>

						<div class="content-divider">
							<h4>Skills</h4>
							<?php foreach($skills as $skill) :?>
								<div>
									<div>Category : <?php echo $skill['category']?></div>
									<div>
										<p><?php echo $skill['description']?></p>
									</div>
								</div>
							<?php endforeach;?>
						</div>

						<div class="content-divider">
							<h4>Work Experience</h4>
							<div>
								<div> - Field : <?php echo $workExperiences['field']?></div>
								<div> - Position : <?php echo $workExperiences['position']?></div>
								<div> - Role Description : <?php echo $workExperiences['role_description']?></div>
								<div> - Date : <?php echo $workExperiences['year'] . ' - ' .$workExperiences['date']?></div>
							</div>
						</div>

						<div class="content-divider">
							<h4>Work History</h4>
							<small class="text-info">(Applicant work history tracker)</small>
							<p>
								This will track all applicants work history in the system as well as evaluation / remarks
							</p>
						</div>
					</section>

					<section class="col-md-6">
						<div class="content-divider">
							<h3>Job Application</h3>
							<div>- Title : <?php echo $job['title']?></div>
							<div>- Sub : <?php echo $job['sub_title']?></div>
							<div>- Position : <?php echo $job['position']?></div>
							<div>- Salary : <?php echo $job['salary']?></div>
							<div>- Salary Type : <?php echo $job['salary_type']?></div>
						</div>

						<div class="content-divider">
							<h3>Job Pitch</h3>
							<div>
								<div>
									- Date applied : <?php echo $jaInfo['date_applied']?>
								</div>
								<div>
									- Resume : <a href="#">Resume</a>
								</div>
								<div>
									- <strong>Attachment</strong> : 
									<a href="#">Preview</a>
									<p>
										<?php echo $jaInfo['attachment_notes']?>
									</p>
								</div>
								<div>
									- <strong>Pitch</strong>
									<p>
										<?php echo $jaInfo['applicant_pitch']?>
									</p>
								</div>
							</div>

							<form>
								<fieldset>
									<legend>Mark Application</legend>
									<div class="inline-block">
										<input type="submit" name="" class="btn btn-primary" value="Priority">
									</div>
									<div class="inline-block">
										<input type="submit" name="" class="btn btn-danger" value="Denie">
									</div>
								</fieldset>
							</form>
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
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>