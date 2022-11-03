<?php require_once '../dependencies.php';?>
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

	$appointment = getAppointment($_GET['id']);
	if( !$appointment )
		return redirect('profile.php');
	
	$applicationid = $appointment['applicationid'];

	$jobApplication = new JobApplication($applicationid);
	$applicant      = $jobApplication->getApplicantInfo();
	$personal = $applicant->getPersonal();
	$workExperience = $applicant->getWorkExperience();
	$jaInfo = $jobApplication->getJobApplicationInfo();


	$jobInfo = $jobApplication->getJobInfo();
	$isEmployed = isEmployed($personal['id']);
?>

<?php build('content')?>

<?php spaceUp()?>

<div class="card">
	<?php Flash::show();?>
	<div class="card-header">
		<h4 class="card-title">Appointment for <?php echo $personal['fullname']?></h4>
	</div>

	<div class="card-body">
		<section class="alert alert-primary">
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

		<section class="alert alert-primary">
			<h3>Applicant Info</h3>
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

		<section class="alert alert-primary">
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
	</div>
</div>

<?php endbuild()?>

<?php loadTo('orbit/app')?>