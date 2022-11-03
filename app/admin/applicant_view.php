<?php require_once '../dependencies.php';?>
<?php
	$user = new Profile($_GET['id']);

	$personal = $user->getPersonal();

	$education = $user->getEducation();

	$workExperiences = $user->getWorkExperience();

	$skills   = $user->getSkills();

	$jobApplications = getUserApplications($user->getId());
	
	$workHistory     = new WorkHistory($user->getId());
	
	$applicant = new Applicant($_GET['id']);

	$applicant = [
		'personal'  => $applicant->getPersonal(),
		'education' => $applicant->getEducation(),
		'workExperience' => $applicant->getWorkExperience(),
		'skills'  => $applicant->getSkills()
	];
?>
<?php build('content') ?>

<?php spaceUp()?>
<div class="card card-theme-dark">
	<?php Flash::show();?>
	<div class="card-header">
		<h4 class="card-title">Applicant Information</h4>
	</div>

	<div class="card-body">
		<!-- TOP CONTENT -->
		<div class="row">
			<div class="col-md-2">
				<div class="profile">
					<?php if($personal['profile'] != 'na'):?>
						<div id="image">
							<img src="<?php echo URL.DS.'public/assets/'.$personal['profile']?>">
						</div>
					<?php else:?>
						<p>No Profile picture uploaded.</p>
					<?php endif;?>
				</div>
			</div>
			<div class="col-md-2">
				<ul class="list-unstyled">
					<li>Firstname : <strong><?php echo $personal['firstname']?></strong> </li>
					<li>Lastname : <strong><?php echo $personal['lastname']?></strong></li>
					<li>Gender : <strong><?php echo $personal['gender']?></strong></li>
					<li>Birthday : <strong><?php echo $personal['birthday']?></strong></li>
				</ul>
			</div>
			<div class="col-md-3">
				<ul class="list-unstyled">
					<li>Email : <strong><?php echo $personal['email']?></strong></li>
					<li>Phone : <strong><?php echo $personal['phone']?></strong> </li>
					<li>Address :<strong><?php echo $personal['address']?></strong> </li>
				</ul>
			</div>
			<div class="col-md-5">
				<div class="row">
					<ul class="list-unstyled col-md-4">
						<?php foreach(getUserFiles($user->getId()) as $file) :?>
							<li>
								<a href="file_viewer.php?filename=<?php echo $file['filename'];?>&id=<?php echo $file['id']?>" 
									target="_blank"><?php echo $file['title'];?>
								</a>
							</li>
						<?php endforeach;?>
					</ul>

					<ul class="list-unstyled col-md-4">
						<?php foreach(getUserFiles($user->getId() , 'text') as $file) :?>
							<li><a href="file_viewer.php?filename=<?php echo $file['filename'];?>&id=<?php echo $file['id']?>" target="_blank"><?php echo $file['title'];?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>

		<div class="divider"></div>
		<!--// TOP CONTENT -->

		<div class="col-md-12">
			<div class="row">
				<section class="col-md-5">
					<h3>Education</h3>
					<div>Highest Attainment : <strong><?php echo $education['highest_attainment']?></strong></div>
					<div>School :<strong><?php echo $education['school']?></strong></div>
					<div>Year : <strong><?php echo $education['year']?></strong></div>
				</section>

				<section class="col-md-5">
					<h3>Skills</h3>
					<?php foreach($skills as $skill):?>
						<div >
							<h3><?php echo $skill['category']?></h3>
							<p><?php echo $skill['description']?></p>
						</div>
					<?php endforeach;?>
				</section>
			</div>
		</div>

		<div class="col-md-12">
			<section class="content-container">
				<h3>Work Experiences</h3>
				<small>External work experiences</small>
				<table class="table">
					<thead>
						<th>Field</th>
						<th>Position</th>
						<th>Role</th>
						<th>Date</th>
						<th>Year</th>
					</thead>
					<tbody>
						<td><?php echo $workExperiences['field']?></td>
						<td><?php echo $workExperiences['position']?></td>
						<td>
							<p style="width: 300px;"><?php echo $workExperiences['role_description']?></p>
						</td>
						<td><?php echo $workExperiences['date']?></td>
						<td><?php echo $workExperiences['year']?></td>
					</tbody>
				</table>
			</section>
		</div>

		<div class="col-md-12">
			<section class="content-container">
				<h3>Job Applications</h3>
				<small class="text-danger">Under construction Database is not yet finalized</small>
				<table class="table">
					<thead>
						<th>Date Applied</th>
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
								<td><?php echo $application['status']?></td>
								<td><?php echo $application['company_name']?></td>
								<td><?php echo !empty($application['resume_image']) ? 'Yes' : 'No'?></td>
								<td><?php echo !empty($application['resume_text']) ? 'Yes' : 'No'?></td>
								<td><a href="application_view.php?id=<?php echo $application['id']?>"><i class="fa fa-eye"></i></a></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</section>
		</div>

		<div class="col-md-12">
			<section class="content-container">
				<?php $workList = $workHistory->getWorkList()?>
				<h3>Work History</h3>
				<small class="text-info">List of all your works on the system</small>
				<table class="table">
					<thead>
						<th>Start</th>
						<th>Until</th>
						<th>Company</th>
						<th>Job</th>
						<th>Position</th>
						<th>Preview</th>
					</thead>
					<tbody>
						<?php foreach($workList as $work) :?>
							<tr>
								<td><?php echo $work['date_started']?></td>
								<td><?php echo $work['date_started']?></td>
								<td><?php echo $work['company_name']?></td>
								<td><?php echo $work['job_title']?></td>
								<td><?php echo $work['position']?></td>
								<td><a href="work_view.php?workid=<?php echo $work['employeeid']?>">Preview</a></td>
							</tr>
						<?php endforeach;?>
					</tbody>

				</table>
			</section>
		</div>
	</div>
</div>
<?php endbuild()?>

<?php build('headers') ?>
<style type="text/css">
	.clean-box{
		background: #fff;
		padding: 10px;
		width: 300px;
		margin-bottom: 10px;
	}
	#image
	{
		width: 150px;
		height: 150px;
		background: red;
	}
	#image img {
		width: 100%;
	}
</style>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>