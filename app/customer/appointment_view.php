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

	if(postRequest('updateAppointmentStatus'))
	{
		$res = db_update('job_applications' , [
			'status' => $_POST['status']
		] , " id = '{$_POST['id']}' ");

		if($res) {
			Flash::set("Job Application has been udpated to '{$_POST['status']}' ");
		}
	}
?>

<?php
	$appointment = getAppointment($_GET['id']);

	$applicationid = $appointment['applicationid'];

	$jobApplication = new JobApplication($applicationid);
	$applicant      = $jobApplication->getApplicantInfo();
	$personal = $applicant->getPersonal();
	$workExperience = $applicant->getWorkExperience();
	$jaInfo = $jobApplication->getJobApplicationInfo();


	$jobInfo = $jobApplication->getJobInfo();

	$isEmployed = isEmployed($personal['id']);

?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				<h4>Appointment for <?php echo $personal['fullname']?></h4>

			</div>

			<div class="panel-body">
				<section class="alert alert-info">
					<h3>Appointment Details</h3>
					<table class="table">
						<thead>
							<tr>
								<td>Subject</td>
								<td><strong><?php echo $appointment['subject']?></strong></td>
							</tr>
							<tr>
								<td>Date</td>
								<td><?php echo $appointment['dateset']?></td>
							</tr>
							<tr>
								<td>Time</td>
								<td><?php echo $appointment['timeset']?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td><?php echo $appointment['status']?></td>
							</tr>
							<tr>
								<td>Message</td>
								<td><?php echo $appointment['message']?></td>
							</tr>
						</thead>
					</table>
				</section>

				<section class="alert alert-info">
					<h3>Applicant Info</h3>
					<a href="application_view.php?id=<?php echo $applicationid?>" class="btn btn-warning btn-sm">Preview</a>
					<hr>
					<div class="row">
						<div class="col-md-4">
							<h4>Personal</h4>
							<table class="table">
								<thead>
									<tr>
										<td>Name</td>
										<td> <strong><?php echo $personal['fullname']?></strong> 
											<?php if(!$isEmployed) :?>
												<span class="badge badge-success">Not Employed</span>
											<?php else:?>
												<span class="badge badge-danger">Employed</span>
											<?php endif;?>
										</td>
									</tr>
									<tr>
										<td>Gender</td>
										<td><?php echo $personal['gender']?></td>
									</tr>
									<tr>
										<td>Birthday</td>
										<td><?php echo $personal['birthday']?></td>
									</tr>
								</thead>
							</table>
						</div>

						<div class="col-md-4">
							<h4>Contact</h4>
							<table class="table">
								<thead>
									<tr>
										<td>Phone</td>
										<td> <strong><?php echo $personal['phone']?></strong> </td>
									</tr>
									<tr>
										<td>Email</td>
										<td><?php echo $personal['email']?></td>
									</tr>
									<tr>
										<td>Address</td>
										<td><?php echo $personal['address']?></td>
									</tr>
								</thead>
							</table>
						</div>

						<div class="col-md-4">
							<h4>Work Experience</h4>
							<table class="table">
								<thead>
									<tr>
										<td>Field</td>
										<td> <strong><?php echo $workExperience['field']?></strong> </td>
									</tr>
									<tr>
										<td>Position</td>
										<td><?php echo $workExperience['position']?></td>
									</tr>
									<tr>
										<td>Role</td>
										<td><?php echo $workExperience['role_description']?></td>
									</tr>
									<tr>
										<td>Date</td>
										<td><?php echo $workExperience['date']?></td>
									</tr>
									<tr>
										<td>Year</td>
										<td><?php echo $workExperience['year']?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</section>

				<section class="alert alert-info">
					<h3>Job Application</h3>
					<div class="row">
						<div class="col-md-4">
							<h4>Application</h4>
							<table class="table">
								<thead>
									<tr>
										<td>Date Applied</td>
										<td><?php echo $jaInfo['date_applied']?></td>
									</tr>
									<tr>
										<td>Status</td>
										<td><?php echo $jaInfo['status']?></td>
									</tr>
									<tr>
										<td>Resume</td>
										<td>
											<a href="file_viewer.php?filename=<?php echo $jaInfo['resume_text']?>" 
												target="_blank">Document</a> | 
											<a href="file_viewer.php?filename=<?php echo $jaInfo['resume_image']?>" 
												target="_blank">Image</a>
										</td>
									</tr>
								</thead>
							</table>
							<div style="background-color: #fff; padding: 12px;">
								<h4>Pitch</h4>
								<p><?php echo $jaInfo['applicant_pitch']?></p>
							</div>
						</div>

						<div class="col-md-8">
							<h4>Job Info</h4>
							<table class="table">
								<thead>
									<tr>
										<td>Company</td>
										<td>
											<a href="company_view.php?id=<?php echo $jobInfo['companyid']?>" target="_blank">
												<?php echo $jobInfo['comp_name'];?>
											</a>
										</td>
									</tr>

									<tr>
										<td>Title</td>
										<td><?php echo $jobInfo['title'];?></td>
									</tr>

									<tr>
										<td>Sub</td>
										<td><?php echo $jobInfo['sub_title'];?></td>
									</tr>

									<tr>
										<td>Position</td>
										<td><?php echo $jobInfo['position'];?></td>
									</tr>

									<tr>
										<td>Salary</td>
										<td><?php echo $jobInfo['salary'];?></td>
									</tr>

									<tr>
										<td>Salary Type</td>
										<td><?php echo $jobInfo['salary_type'];?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</section>

				<section class="alert alert-info">
					<h3>Actions</h3>
					<div class="row">
						<div class="col-md-4">
							<h4>Set Application to Finish</h4>
							<?php
								FormOpen([
									'method' => 'post'
								]);

								FormHidden('id' , $appointment['id']);

								FormSelect('status' , jobApplicationStatus() , $jaInfo['status'] , [
									'class' => 'form-control'
								]);
							?>
							<div class="form-group">
								<input type="submit" name="updateAppointmentStatus" class="btn btn-primary" 
									value="set to finish">
							</div>
							<?php FormClose()?>
						</div>

						<div class="col-md-4">
							<h4>Reschedule appointment</h4>
							<a href="appointment_edit.php?id=<?php echo $appointment['id']?>" class="btn btn-primary">
								Set new schedule
							</a>
						</div>
					</div>
				</section>

				<div>
					<h3>Add your new Employee</h3>
					<a href="employee_create.php?applicationid=<?php echo $applicationid?>&contentshow=addemployee#addemployee">Set Applicant as employed</a>
				</div>

				<?php if(isset($_GET['contentshow']) && $_GET['contentshow'] == 'addemployee') :?>
				<section class="col-md-5" id="addemployee">
					<form method="post" action="">
						<input type="hidden" name="applicationid" value="<?php echo $jaInfo['id']?>">
						<input type="hidden" name="companyid" value="<?php echo $jobInfo['companyid']?>">
						<input type="hidden" name="userid" value="<?php echo $personal['id']?>">
						<input type="hidden" name="appointmentid" value="<?php echo $appointment['id']?>">
						<fieldset>
							<legend>Applicant Company Information</legend>
						</fieldset>
						<div class="form-group">
							<label>Date Started</label>
							<input type="date" name="date_started" class="form-control" required>
						</div>

						<div class="form-group">
							<label>Job title</label>
							<input type="text" name="job_title" class="form-control" 
							value="<?php echo $jobInfo['title']?>">
						</div>

						<div class="form-group">
							<label>Position</label>
							<input type="text" name="position" class="form-control" 
							value="<?php echo $jobInfo['position']?>">
						</div>

						<div class="form-group">
							<label>Salary</label>
							<input type="text" name="salary" class="form-control" 
							value="<?php echo $jobInfo['salary']?>">
						</div>

						<div class="form-group">
							<label>Salary Type</label>
							<?php
								FormSelect('salary_type' , salary_type_list(), $jobInfo['salary_type'] , [
									'class' => 'form-control'
								])
							?>
						</div>

						<input type="submit" name="addemployee" class="btn btn-primary" value="Add Employee">
						<a href="appointment_view.php?id=1" class="btn btn-primary btn-warning">Cancel</a>
					</form>
				</section>
				<?php endif;?>

				<?php if($appointment['status'] != 'finished') :?>
				<section>

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
					
				</section>
				<?php else:?>
					<p>Application is finished, remarks : <strong><?php echo $appointment['remarks']?></strong></p>
			<?php endif;?>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>