<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
	if(postRequest('uploadProfile'))
	{
		$userid = Session::get('user')['id'];

		

		$result = uploadProfile($userid);
	}
?>
<?php $user = new Profile();?>


<?php

	// if(!isDoneSetup()) {
	// 	Flash::set("finish setting up your account first" , 'warning');

	// 	return redirect('account_setup.php');
	// }

	$personal = $user->getPersonal();

	$education = $user->getEducation();
	$workExperiences = $user->getWorkExperience();
	$skills   = $user->getSkills();

	$jobApplications = getUserApplications($user->getId());

	$workHistory     = new WorkHistory($user->getId());
?>
<?php build('content') ?>

<div id="wrapper">
	<div style="margin-top: 50px;"></div>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-3">

			<div class="card card-theme-dark">
				<div class="card-header">
					<h4 class="card-title">Personal</h4>
				</div>

				<div class="card-body">
					<section>
						<div class="text-center">
							<?php wCircularImage(['name' => $personal['profile'] ,'path' => URL.DS.'public/assets'])?>
						</div>
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
								<input type="file" name="profile">
							</div>
							<input type="submit" name="uploadProfile" value="upload" class="btn btn-primary btn-sm">
							<div>
								<small>Upload your profile picture</small>
							</div>
						</form>
					</section>
					<ul class="list-unstyled">
						<li>Firstname : <strong><?php echo $personal['firstname']?></strong> </li>
						<li>Lastname : <strong><?php echo $personal['lastname']?></strong></li>
						<li>Gender : <strong><?php echo $personal['gender']?></strong></li>
						<li>Birthday : <strong><?php echo $personal['birthday']?></strong></li>
					</ul>

					<section>
						<h4>Education</h4>
						<ul class="list-unstyled">
							<li>Highest Attainment : <strong><?php echo $education['highest_attainment']?></strong></li>
							<li>School :<strong><?php echo $education['school']?></strong> </li>
							<li>Year : <strong><?php echo $education['year']?></strong></li>
							<li><a href="education_primary_edit.php">Edit</a></li>
						</ul>
					</section>

					<section>
						<h4>Contact</h4>
						<ul class="list-unstyled">
							<li>Email : <strong><?php echo $personal['email']?></strong></li>
							<li>Phone : <strong><?php echo $personal['phone']?></strong> </li>
							<li>Address :<strong><?php echo $personal['address']?></strong> </li>
						</ul>
					</section>

					<section>
						<h4>User Files</h4>
					</section>
				</div>
			</div>		
		</div>

		<div class="col-md-9" id="right-content">
			<div class="card card-theme-dark">
				<div class="card-header">
					<h4 class="card-title">Skills</h4>
				</div>
				<section class="card-body">
					<div class="row">
						<?php foreach($skills as $skill):?>
		                    <div class="col-md-6 col-lg-6 col-xl-3">
		                        <div class="card border-dark m-b-30">
		                            <div class="card-body text-dark">
		                                <h5 class="card-title"><?php echo $skill['category']?></h5>
		                                <p class="card-text"><?php echo crop_string( $skill['description'] , 20)?></p>
		                            </div>
		                        </div>
		                    </div>
						<?php endforeach;?>
					</div>
				</section>
			</div>

			<div class="card card-theme-dark">
				<div class="card-header">
					<h4 class="card-title">Work Experience</h4>
				</div>
				<section class="card-body">
					<section>
						
						<!-- <div> <small>External</small> <a href="work_create.php">Add More</a></div> -->
						<?php
							$workExperiences = getWorkExperiences(Session::get('user')['id']);
						?>

						<?php if(!empty($workExperiences)) :?>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<th>Field</th>
										<th>Position</th>
										<th>Role Description</th>
										<th>Date</th>
										<th>Year</th>
									</thead>
									<tbody>
										<?php foreach($workExperiences as $work) :?>
											<?php if(empty($work['field'])) continue;?>
											<tr>
												<td>
													<a href="work_edit.php?workid=<?php echo $work['id']?>"><?php echo $work['field']?></a>
												</td>
												<td><?php echo $work['position']?></td>
												<td><?php echo $work['role_description']?></td>
												<td><?php echo $work['date']?></td>
												<td><?php echo $work['year']?></td>
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div>
						<?php else:?>
							<!-- <p>No Job Experience, <a href="work_create.php">Add here</a></p> -->
						<?php endif;?>
					</section>

					<section>
						<small class="text-info">Internal</small>
						<?php $workList = $workHistory->getWorkList()?>

						<?php if(!empty($workList)) :?>
						<table class="table">
							<thead>
								<th>Start</th>
								<th>Status</th>
								<th>Company</th>
								<th>Job</th>
								<th>Position</th>
								<th>Preview</th>
							</thead>
							<tbody>
								<?php foreach($workList as $work) :?>
									<tr>
										<td><?php echo $work['date_started']?></td>
										<td><?php echo $work['employment_status'] . ' '. $work['empnotes']?></td>
										<td><?php echo $work['company_name']?></td>
										<td><?php echo $work['job_title']?></td>
										<td><?php echo $work['position']?></td>
										<td><a href="work_view.php?workid=<?php echo $work['employeeid']?>">Preview</a></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<?php else:?>
							<p>No Internal Job Experience found
								<a href="#">What is internal job experience?</a></p>
						<?php endif?>
					</section>
				</section>
			</div>

			<div class="card">
				<section class="card-body">
					<?php
						$applicant_other_educations = getApplicantEducations(Session::get('user')['id']);
					?>
					<h4>Other Educations</h4>
					<?php if(!empty($applicant_other_educations)) :?>
					<table class="table">
						<thead>
							<th>School</th>
							<th>Category</th>
							<th>Course / Field</th>
							<th>Month</th>
							<th>Year</th>
							<th>Description</th>
							<th>Edit</th>
						</thead>
						<tbody>
							<?php foreach($applicant_other_educations as $edu) :?>
								<tr>
									<td><?php echo $edu['school']?></td>
									<td><?php echo $edu['category']?></td>
									<td><?php echo $edu['course']?></td>
									<td><?php echo getMonthByNumber($edu['month'])?></td>
									<td><?php echo $edu['year']?></td>
									<td>
										<p style="width:300px;">
											<?php echo $edu['description']?>
										</p>
									</td>
									<td>
										<a href="education_edit.php?eduid=<?php echo $edu['id']?>">Edit</a>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<?php else:?>
						<!-- <p>No Other education <a href="education_create.php">Add Education</a> </p> -->
					<?php endif;?>
				</section>
			</div>
			<div class="card">
				<section class="card-body">
					<h4>Job Applications</h4>
					<?php if(!empty($jobApplications)) :?>
						<table class="table">
							<thead>
								<th>Date Applied</th>
								<th>Job</th>
								<th>Status</th>
								<th>Company</th>
								<th>ResumeImage</th>
								<th>ResumeText</th>
								<th>Preview</th>
							</thead>

							<tbody>
								<?php foreach($jobApplications as $application) :?>
									<tr>
										<td><?php echo $application['date_applied']?></td>
										<td><?php echo $application['title']?></td>
										<td><?php echo $application['status_label']?></td>
										<td><?php echo $application['company_name']?></td>
										<td><?php echo !empty($application['resume_image']) ? 'Yes' : 'No'?></td>
										<td><?php echo !empty($application['resume_text']) ? 'Yes' : 'No'?></td>
										<td><a href="application_view.php?id=<?php echo $application['id']?>"><i class="fa fa-eye"></i></a></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>

					<?php else:?>
						<!-- <p>No Pending Job application found. <a href="catalog.php">Search now on the job catalogs.</a></p> -->
					<?php endif?>
				</section>
			</div>
		</div>
</div>
<?php endbuild()?>
<?php loadTo('orbit/app')?>

