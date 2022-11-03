<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.sm-content{

		border: 1px solid #fff;
		background: #eee;
		border-radius: 2px;
		padding: 20px 15px;
		margin-bottom: 10px;
	}
	.appointment 
	{
		border: 1px solid #eee;
		padding: 5px 5px;
	}
	.appointment div
	{
		margin-bottom: 7px;
	}
</style>
</head>
<body>
	<?php

		if(postRequest('updateApplicationLabel'))
		{
			// die(var_dump($_POST));
			updateApplicationLabel($_POST['applicationid'] , $_POST['label']);
		}
		if(postRequest('sendAppointment'))
		{
			createAppointment($_POST);
		}
		if(postRequest('passApplicant'))
		{
			updateApplicationStatus($_POST['applicationid'] , 'passed' , $_POST['notes']);
		}
		if(postRequest('failApplicant'))
		{
			updateApplicationStatus($_POST['applicationid'] , 'failed' , $_POST['notes']);
		}
	?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>

		<?php  $auth = getUser(Session::get('user')['id'])?>
		<?php  $ja = new JobApplication($_GET['id']) ;?>

		<?php
			$jaInfo    = $ja->getJobApplicationInfo();
			$job       = $ja->getJobInfo();
			$company   = $ja->getCompany();
			$applicant = $ja->getApplicantInfo();

			$applicant = [
				'personal'        => $applicant->getPersonal(),
				'workExperiences' => $applicant->getWorkExperience(),
				'skills'          => $applicant->getSkills(),
				'education'       => $applicant->getEducation()
			];

			$hasAppointment   = getJobApplicantAppointment($_GET['id']);

			$exam = getJobExam($job['id'],1);
			$applicantExam    = getExamByParam(" WHERE applicationid = '{$jaInfo['id']}'");
		?>
		<div class="panel panel-default">
			<?php Flash::show('application');?>
			<?php Flash::show();?>
			<div class="panel-heading">
				Application View
			</div>

			<div class="panel-body">
				<div>Application Status : <strong><?php echo $jaInfo['status']?></strong></div>
				<div class="row">
					<div class="col-md-6">
						<section class="application">
							<h3>Job Info</h3>
							<div class="sm-content">
								<div>- Title : <?php echo $job['title']?></div>
								<div>- Sub : <?php echo $job['sub_title']?></div>
								<div>- Position : <?php echo $job['position']?></div>
								<div>- Salary : <?php echo $job['salary']?></div>
								<div>- Salary Type : <?php echo $job['salary_type']?></div>
							</div>

							<div class="sm-content">
								<div><strong>Application</strong> </div>
								<div> - Status :<?php echo $jaInfo['status']?></div>
								<div> - Label :<?php echo $jaInfo['label']?></div>
								<div>
									- Date applied : <?php echo $jaInfo['date_applied']?>
								</div>
								<div>
									
									- Resume Image : 
									<a href="file_viewer.php?filename=<?php echo $jaInfo['resume_image']?>" 
										target="_blank">Preview</a>
								</div>
								<div>
									- <strong>Resume Text</strong> : 
									<a href="file_viewer.php?filename=<?php echo $jaInfo['resume_text']?>" 
										target="_blank">Preview</a>
								</div>
								<div>
									- <strong>Pitch</strong>
									<p style="word-wrap: break-word;">
										<?php echo $jaInfo['applicant_pitch']?>
									</p>
								</div>
								<div>
									-<strong>Has Took Exam</strong>

									<div>
										<div> <strong> Exam 1</strong></div>
										<?php $exam = getJobExam($job['id'], 1);?>
										<?php if(empty($exam)) :?>
											<a href="#">No exam</a>
										<?php else:?>
											<?php $examTooked = hasTookExam($_GET['id'] , $exam['examid']);?>

											<!-- IF EXAMINATION IS TAKEN -->
											<?php if($examTooked):?>
												<?php $result = getExamResult(" WHERE examinationid = '{$examTooked['id']}'");?>
												<div>
													<div><?php echo $result['score'] . '%'?><?php echo $result['remarks']?></div>
													<a href="examination_result.php?resultid=<?php echo $result['id']?>">Review</a>
												</div>
											<?php else:?>
												<p>No Exam Taken.</p>
											<?php endif;?>
										<?php endif;?>
									</div>

									<div>
										<div> <strong> Exam 2</strong></div>
										<?php $exam = getJobExam($job['id'], 2);?>

										<?php if(empty($exam)) :?>
											<a href="#">No exam</a>
										<?php else:?>
											<?php $examTooked = hasTookExam($_GET['id'] , $exam['examid']);?>

											<!-- IF EXAMINATION IS TAKEN -->
											<?php if($examTooked):?>
												<?php $result = getExamResult(" WHERE examinationid = '{$examTooked['id']}'");?>
												<div>
													<div><?php echo $result['score'] . '%'?><?php echo $result['remarks']?></div>
													<a href="examination_result.php?resultid=<?php echo $result['id']?>">Review</a>
												</div>
											<?php else:?>
												<p>No Exam Taken.</p>
											<?php endif;?>
										<?php endif;?>
									</div>

									<div>
										<div> <strong> Exam 3</strong></div>
										<?php $exam = getJobExam($job['id'], 3);?>

										<?php if(empty($exam)) :?>
											<a href="#">No exam</a>
										<?php else:?>
											<?php $examTooked = hasTookExam($_GET['id'] , $exam['examid']);?>
											<?php if($examTooked):?>
												<?php $result = getExamResult(" WHERE examinationid = '{$examTooked['id']}'");?>
												<div>
													<div><?php echo $result['score'] . '%'?><?php echo $result['remarks']?></div>
													<a href="examination_result.php?resultid=<?php echo $result['id']?>">Review</a>
												</div>
											<?php else:?>
												<p>No Exam Taken.</p>
											<?php endif;?>
										<?php endif;?>
									</div>
								</div>
								
								<div>
									-<strong>Has Appointment</strong>
									<p>
										<?php if($hasAppointment) :?>
											<a href="appointment_view.php?id=<?php echo $hasAppointment['id']?>">View Appointment</a>
											<?php else:?>
											<strong>No Appointment</strong>
										<?php endif;?>
									</p>
								</div>
							</div>
						</section>
						<section class="general">
							<h3>Applicant</h3>
							<div class="sm-content">
								<?php extract($applicant);?>
								<h4>Personal</h4>
								<ul>
									<li>Firstname : <?php echo $personal['firstname']?></li>
									<li>Lastname : <?php echo $personal['lastname']?></li>
									<li>Gender : <?php echo $personal['gender']?></li>
									<li>Birthday : <?php echo $personal['birthday']?></li>
									<li><a href="applicant_view.php?id=<?php echo $jaInfo['userid']?>">Review Applicant</a></li>
								</ul>
							</div>

							<div class="sm-content">
								<h4>Education</h4>
								<ul>
									<li>Highest Attainment : <?php echo $education['highest_attainment']?></li>
									<li>Year : <?php echo $education['year']?></li>
									<li>School : <?php echo $education['school']?></li>
									<li>Status : <?php echo $education['status']?></li>
								</ul>
							</div>

							<div class="sm-content">
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
						</section>
					</div>
					<?php if( !isEmployed($auth['id']) == true ) :?>
						<?php if($applicantExam) :?>
						<div class="col-md-6">
							<?php if($jaInfo['status'] == 'pending') :?>
								<section class="controls">
									<h3>Application Process</h3>

									<?php if(!$hasAppointment) :?>
									<div class="row">
										<div class="col-md-12">
											<hr>
											<h4>Evaluate Employee</h4>
											<form method="post">
												<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
												<div class="form-group">
													<label>Add Notes</label>
													<textarea name="notes" class="form-control" rows="5"></textarea>
												</div>
												<div class="form-group">
													<input type="submit" id="failApplicant" name="failApplicant" class="btn btn-danger" value="Fail Applicant">
													<a href="application_view.php?id=<?php echo $_GET['id']?>&appointmentForm=show" class="btn btn-primary">Set an appointment</a>
												</div>
											</form>
										</div>
									</div>
									<?php endif;?>
									<div class="divider"></div>

									<?php if(isset($_GET['appointmentForm']) && $_GET['appointmentForm']=='show') :?>
										<section>
											<hr>
											<h4>Set Appointment</h4>
											<form method="post">
												<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
												<div class="form-group">
													<label>Date</label>
													<input type="date" name="date" class="form-control" required>
												</div>

												<div class="form-group">
													<label>Time</label>
													<input type="time" name="time" class="form-control" required>
												</div>
												<div class="form-group">
													<label>Address</label>
													<input type="text" name="address" class="form-control" 
													value="<?php echo $auth['address']?>" required>
												</div>

												<div class="form-group">
													<label>Notes</label>
													<textarea name="notes" class="form-control" rows="5"></textarea>
												</div>

												<input type="submit" name="sendAppointment" value="Send Apointment" class="btn btn-primary">
												<a href="application_view.php?id=<?php echo $_GET['id']?>">Cancel Appointment</a>
											</form>
										</section>
									<?php endif;?>

									<?php if($hasAppointment) :?>
										<hr>
										<section class="appointment">
											<h4>Appointment</h4>
											<div><h5>Subject : <?php echo $hasAppointment['subject']?></h5></div>
											<div>- 
												<strong>Appointment For : </strong>
												<?php if($hasAppointment['appointment_for'] == 'agency') :?>
														Initial Interview
													<?php else:?>
														Final Interview
												<?php endif;?>
											</div>

											<div>-
												<strong>Status:</strong>
												<?php echo $hasAppointment['status'] ;?>
											</div>

											<div>-
												<strong>Date : </strong>
												<?php echo $hasAppointment['dateset']?>
											</div>
											<div>-
												<strong>Timeset : </strong>
												<?php echo $hasAppointment['timeset']?>
											</div>
											<div>-
												<strong>Message : </strong>
												<p style="line-height: 25px;">
													<?php echo $hasAppointment['message']?>
												</p>
											</div>
										</section>

										<div class="divider"> </div>
										<h4>Label Application</h4>
										<form method="post">
											<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
											<div class="row">
												<div class="col-md-4">
													<?php
														FormSelect('label' , [
														'priority' , 'recommended'] , $jaInfo['label'] , [
															'class' => 'form-control'
														]);
													?>
												</div>
												<div class="col-md-4">
													<input type="submit" name="updateApplicationLabel" class="btn btn-primary">
												</div>
											</div>
										</form>

										<h4>Evaluate Employee</h4>
										<form method="post">
											<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
											<div class="form-group">
												<label>Add Notes</label>
												<textarea name="notes" class="form-control" rows="5"></textarea>
											</div>
											<div class="form-group">
												<input type="submit" id="failApplicant" name="failApplicant" class="btn btn-danger" value="Fail">
												<input type="submit" id="passApplicant" name="passApplicant" class="btn btn-primary" value="Pass">
											</div>
										</form>
									<?php endif;?>
								</section>
							<?php else:?>
								<section class="">
									<div>
										<h3>Application Remarks</h3>

										<div>
											<strong>Status</strong>
											<p><?php echo $jaInfo['status']?></p>

											<strong>Notes</strong>
											<p><?php echo $jaInfo['notes']?></p>
										</div>
									</div>
									<div>
										<h3>Re-Update Remarks</h3>
										<form method="post">
											<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
											<div class="form-group">
												<label>Add Notes</label>
												<textarea name="notes" class="form-control" rows="5"></textarea>
											</div>
											<div class="form-group">
												<input type="submit" id="failApplicant" name="failApplicant" class="btn btn-danger" value="Fail">
												<input type="submit" id="passApplicant" name="passApplicant" class="btn btn-primary" value="Pass">
											</div>
										</form>
									</div>
								</section>
							<?php endif;?>
						</div>
						<?php else:?>
							<p>No exam found.</p>
						<?php endif;?>
					<?php else:?>
						<p>Applicant is currently employeed</p>
						<form method="post">
							<input type="submit" name="deleteApplication" value="Remove Application" class="btn btn-primary">
						</form>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<script type="text/javascript">
	$( document ).ready(function()
	{
		$("#failApplicant").click(function(evt)
		{
			if(confirm("Are you sure you want to fail the appplicant?")){

			}else{
				evt.preventDefault();
			}
			
		});

		$("#passApplicant").click(function(evt)
		{
			if(confirm("Are you sure you want to pass the appplicant?")){

			}else{
				evt.preventDefault();
			}
			
		});
		
	});
</script>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>