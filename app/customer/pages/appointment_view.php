<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>

<?php 
	if(postRequest('addemployee'))
	{
		addEmployee($_POST);
	}
	if(postRequest('setToFinish'))
	{
		applicationToFinish($_POST);
	}

	if(postRequest('updateAppointment'))
	{
		updateAppointment($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant Appointment') ;?>
		<?php $appointment = getAppointment($_GET['id']) ;?>

		<?php $jobApplication = new JobApplication($appointment['applicationid']);?>
		<?php $applicant      = $jobApplication->getApplicantInfo();?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant Appointment
			</div>

			<div class="panel-body">
				<section>
					<h3>Application Info</h3>
					<ul>
						<li>Date : <?php echo $appointment['dateset']?></li>
						<li>Time : <?php echo $appointment['timeset']?></li>
						<li>Status : <?php echo $appointment['status']?></li>
					</ul>
				</section>
				<section>
					<h3>Applicant Info</h3>

					<?php extract($applicant->getPersonal());?>
					<ul class="list-unstyled">
						<li>Name : <?php echo $fullname?></li>
						<li>Gender : <?php echo $gender?></li>
						<li>Birthday : <?php echo $birthday?></li>
					</ul>
					<ul class="list-unstyled">
						<li><strong>Contacts</strong></li>
						<li>Phone : <?php echo $phone?></li>
						<li>Email : <?php echo $email?></li>
						<li>Address : <?php echo $address?></li>
					</ul>

					<section>
						<?php extract($applicant->getWorkExperience());?>
						<div>- <strong>Work Experience</strong></div>
						<ul>
							<li>Field <?php echo $field?></li>
							<li>Position <?php echo $position?></li>
							<li>Role Description <?php echo $role_description?></li>
							<li>Date <?php echo $date?></li>
							<li>Year <?php echo $year?></li>
						</ul>
					</section>

				</section>

				<section>
					<?php extract($jobApplication->getJobApplicationInfo());?>
					<h3>Job Application</h3>
					<ul>
						<li>Application Label : <strong><?php echo $label?></strong></li>
						<li>Date Applied : <?php echo $date_applied?></li>
						<li><strong>Resume</strong></li>
						<ul>
							<li> 
								<a href="viewer.php?src=<?php echo $resume_image?>" target="_blank">
								Image</a> 
							</li>
							<li>
								<a href="viewer.php?src=<?php echo $resume_text?>" target="_blank">Text</a>
							</li>
						</ul>
					</ul>
					<div>
						<strong>- Pitch</strong>
						<p><?php echo $applicant_pitch?></p>
					</div>
				</section>

				<section>
					<?php extract($jobApplication->getJobInfo());?>
					<h3>Job Info</h3>
					<ul>
						<li>Company : <?php echo $comp_name;?></li>
						<li>Title : <?php echo $title?></li>
						<li>Sub : <?php echo $sub_title?></li>
						<li>Position : <?php echo $position?></li>
						<li>Salary : <?php echo $salary?></li>
						<li>Salary Type : <?php echo $salary_type?></li>
						<li>Notes : <?php echo $notes?></li>
					</ul>
				</section>
				<?php if($appointment['status'] != 'finished') :?>
				<section>
					<h3>Actions</h3>
					<form method="post">
						<input type="hidden" name="remarks" value="failed">
						<input type="hidden" name="appointmentid" value="<?php echo $_GET['id']?>">
						<div class="form-group">
							<label>Set Application to Finish</label><br>
							<input type="submit" name="setToFinish" class="btn btn-primary" 
							value="set to finish">
							<small>Clicking this will mark the application as failed</small>
						</div>
					</form>
					<div>
						<label>Reschedule appointment</label><br>
						<a href="appointment_view.php?id=<?php echo $_GET['id']?>&contentshow=scheduleForm#scheduleForm" class="btn btn-primary">
							Set new schedule
						</a>
					</div>

					<?php if(isset($_GET['contentshow']) && $_GET['contentshow'] == 'scheduleForm') :?>
						<hr>
						<div class="col-md-5" id="scheduleForm">
							<form method="post">
								<input type="hidden" name="appointmentid" value="<?php echo $appointment['id']?>">
								<fieldset>
									<legend>Update Appoint</legend>
									<div class="form-group">
										<label>Date</label>
										<input type="date" name="date" class="form-control" 
										value="<?php echo $appointment['dateset']?>">
									</div>
									<div class="form-group">
										<label>Time</label>
										<input type="time" name="time" class="form-control" 
										value="<?php echo $appointment['timeset']?>">
									</div>

									<div class="form-group">
										<label>Subject</label>
										<input type="text" name="subject" class="form-control" 
										value="Your Applicant for <?php echo $comp_name?> will be re-scheduled">
									</div>
									<div class="form-group">
										<label>Message</label>
										<textarea class="form-control" cols="5" name="message">Dear <?php echo $fullname?> , we would like to advice you that your sheduled appointment to us '<?php echo $comp_name?>',is will be reschedule to some reason..
										</textarea>
									</div>
									<div class="form-group">
										<label>Will be sent to</label>
										<input type="text" name="reciever" 
										value="<?php echo $applicant->getPersonal()['email']?>" class="form-control"
										readonly>
									</div>

									<input type="submit" name="updateAppointment" class="btn btn-primary" 
									value="Send Appointment">
								</fieldset>
							</form>
						</div>
					<?php endif;?>
					<div class="divider"></div>
					<div>
						<?php if(isEmployed($appointment['userid']) == false) :?>
							<h3>Add your new Employee</h3>
							<a href="appointment_view.php?id=<?php echo $_GET['id']?>&contentshow=addemployee#addemployee">
							Set Applicant as employed</a>
							<?php else:?>
								<a href="#">Applicant is currenly Employed</a>
						<?php endif;?>
					</div>
				</section>

				<?php if(isset($_GET['contentshow']) && $_GET['contentshow'] == 'addemployee') :?>
				<section class="col-md-5" id="addemployee">
					<?php $jaInfo = $jobApplication->getJobApplicationInfo();?>
					<form method="post" action="">
						<input type="hidden" name="applicationid" value="<?php echo $jaInfo['id']?>">
						<input type="hidden" name="companyid" value="<?php echo $companyid?>">
						<input type="hidden" name="userid" value="<?php echo $userid?>">
						<input type="hidden" name="appointmentid" value="<?php echo $_GET['id']?>">
						<fieldset>
							<legend>Applicant Company Information</legend>
						</fieldset>
						<div class="form-group">
							<label>Date Started</label>
							<input type="date" name="date_started" class="form-control">
						</div>

						<div class="form-group">
							<label>Job title</label>
							<input type="text" name="job_title" class="form-control" 
							value="<?php echo $title?>">
						</div>

						<div class="form-group">
							<label>Position</label>
							<input type="text" name="position" class="form-control" 
							value="<?php echo $position?>">
						</div>

						<div class="form-group">
							<label>Salary</label>
							<input type="text" name="salary" class="form-control" 
							value="<?php echo $salary?>">
						</div>

						<div class="form-group">
							<label>Salary Type</label>
							<input type="text" name="salary_type" class="form-control" 
							value="<?php echo $salary_type?>">
						</div>

						<input type="submit" name="addemployee" class="btn btn-primary" value="Add Employee">
						<a href="appointment_view.php?id=1" class="btn btn-primary btn-warning">Cancel</a>
					</form>
				</section>
				<?php endif;?>

				<?php else:?>
					<p>Application is finished, remarks : <strong><?php echo $appointment['remarks']?></strong></p>
			<?php endif;?>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>