<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

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
</head>
<body>
<?php
	if(postRequest('uploadProfile'))
	{
		$userid = Session::get('user')['id'];

		uploadProfile($userid);
	}

	if(postRequest('addFile'))
	{
		userFilesCreate($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php $user = new Profile();?>

		<?php
			$personal = $user->getPersonal();
			$education = $user->getEducation();
			$workExperiences = $user->getWorkExperience();
			$skills   = $user->getSkills();

			$jobApplications = getUserApplications($user->getId());

			$workHistory     = new WorkHistory($user->getId());
		?>
		<h3>Profile</h3>
		<?php Flash::show();?>
		<?php Flash::show('jobapplication');?>
		<div id="wrapper">
			<section class="content-container col-md-3">
				<h3>Personal</h3>
				<?php if($personal['profile'] != 'na'):?>
					<div id="image">
						<img src="<?php echo URL.DS.'public/assets/'.$personal['profile']?>">
					</div>
				<?php else:?>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="profile">
						</div>
						<input type="submit" name="uploadProfile" value="upload" class="btn btn-primary btn-sm">
						<div>
							<small>Upload your profile picture</small>
						</div>
					</form>
				<?php endif;?>
				<hr>

				<div id="changeProfile" style="display: none">
					<h3>Change Profile</h3>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="profile">
						</div>
						<input type="submit" name="uploadProfile" value="upload" class="btn btn-primary btn-sm">
					</form>
					<a href="#" class="el-toggle" data-target="#changeProfile" >Hide</a>
					<hr>
				</div>
				<ul class="list-unstyled">
					<?php if($personal['profile'] != 'na'):?>
						<li><a href="#" class="el-toggle" data-target="#changeProfile">Change Profile picture</a></li>
					<?php endif;?>
					<li>Firstname : <strong><?php echo $personal['firstname']?></strong> </li>
					<li>Lastname : <strong><?php echo $personal['lastname']?></strong></li>
					<li>Gender : <strong><?php echo $personal['gender']?></strong></li>
					<li>Birthday : <strong><?php echo $personal['birthday']?></strong></li>
				</ul>
			</section>

			<section class="content-container col-md-3 col-md-offset-2">
				<h3>Contact</h3>
				<ul>
					<li>Email : <strong><?php echo $personal['email']?></strong></li>
					<li>Phone : <strong><?php echo $personal['phone']?></strong> </li>
					<li>Address :<strong><?php echo $personal['address']?></strong> </li>
				</ul>
			</section>

			<section class="content-container">
				<h3>Education</h3>
				<ul>
					<li>Highest Attainment : <strong><?php echo $education['highest_attainment']?></strong></li>
					<li>School :<strong><?php echo $education['school']?></strong> </li>
					<li>Year : <strong><?php echo $education['year']?></strong></li>
				</ul>
			</section>
			<div class="divider"></div>
			<section class="content-container">
				<h3>User Files</h3>
				<div class="row">
					<div class="col-md-4">
						<h3>Id Pictures</h3>
						<ul>
							<?php foreach(getUserFiles($user->getId()) as $file) :?>
								<li><a href="file_viewer.php?filename=<?php echo $file['filename'];?>&id=<?php echo $file['id']?>" target="_blank"><?php echo $file['title'];?></a></li>
							<?php endforeach;?>
						</ul>
					</div>
					<div class="col-md-4">
						<h3>Certificates</h3>
						<ul>
							<?php foreach(getUserFiles($user->getId() , 'text') as $file) :?>
								<li><a href="file_viewer.php?filename=<?php echo $file['filename'];?>&id=<?php echo $file['id']?>" target="_blank"><?php echo $file['title'];?></a></li>
							<?php endforeach;?>
						</ul>
					</div>
					<div class="col-md-4">
						<h3>Add File</h3>
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>File Title</label>
								<input type="text" name="title" class="form-control">
							</div>
							<div class="form-group">
								<select class="form-control" name="type">
									<option value="picture">Id Picture</option>
									<option value="text">Certificate</option>
								</select>
							</div>

							<div class="form-group">
								<input type="file" name="file">
							</div>

							<input type="submit" name="addFile" class="btn btn-success">
						</form>
					</div>
				</div>
			</section>
			<div class="divider"></div>
			<section class="content-container">
				<?php
					$applicant_other_educations = getApplicantEducations(Session::get('user')['id']);
				?>
				<h3>Other Educations <a href="education_create.php">Add Edu</a> </h3>
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
								<td><?php echo $edu['month']?></td>
								<td><?php echo $edu['year']?></td>
								<td>
									<p style="width:300px;">
										<?php echo $edu['description']?>
									</p>
								</td>
								<td>
									<a href="education_create.php?eduid=<?php echo $edu['id']?>">Edit</a>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<?php else:?>
					<p>No Other education <a href="education_create.php">Add Education</a> </p>
				<?php endif;?>
			</section>
			<section class="content-container">
				<?php
					$workExperiences = getWorkExperiences(Session::get('user')['id']);
				?>
				<h3>Work Experiences (External) <a href="work_create.php">Add Work</a></h3>
				<table class="table">
					<thead>
						<th>Field</th>
						<th>Position</th>
						<th>Role Description</th>
						<th>Date</th>
						<th>Year</th>
					</thead>
					<tbody>
						<?php foreach($workExperiences as $work) :?>
							<tr>
								<td><?php echo $work['field']?></td>
								<td><?php echo $work['position']?></td>
								<td><?php echo $work['role_description']?></td>
								<td><?php echo $work['date']?></td>
								<td><?php echo $work['year']?></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</section>

			<section class="content-container">
				<h3>Skills</h3>
				<?php foreach($skills as $skill):?>
					<div class="clean-box">
						<h3><?php echo $skill['category']?></h3>
						<p><?php echo $skill['description']?></p>
					</div>
				<?php endforeach;?>
			</section>

			<section class="content-container">
				<h3>Job Applications</h3>
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
			</section>

			<section class="content-container">
				<?php $workList = $workHistory->getWorkList()?>
				<h3>Work History</h3>
				<small class="text-info">List of all your works on the system</small>
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
						<?php $firstInstance = 1;?>
						<?php foreach($workList as $work) :?>
							<?php if($firstInstance == 1) :?>
								<tr style="background: #08d19f; color: #000;">
									<td><?php echo $work['date_started']?></td>
									<td><?php echo $work['employment_status'] . ' '. $work['empnotes']?></td>
									<td><?php echo $work['company_name']?></td>
									<td><?php echo $work['job_title']?></td>
									<td><?php echo $work['position']?></td>
									<td><a href="work_view.php?workid=<?php echo $work['employeeid']?>">Preview</a></td>
								</tr>
								<?php else:?>
								<tr>
									<td><?php echo $work['date_started']?></td>
									<td><?php echo $work['employment_status'] . ' '. $work['empnotes']?></td>
									<td><?php echo $work['company_name']?></td>
									<td><?php echo $work['job_title']?></td>
									<td><?php echo $work['position']?></td>
									<td><a href="work_view.php?workid=<?php echo $work['employeeid']?>">Preview</a></td>
								</tr>
							<?php endif;?>
							<?php $firstInstance ++;?>
						<?php endforeach;?>
					</tbody>

				</table>
			</section>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>

<script type="text/javascript">

	$( document ).ready(function()
	{
		$(".el-toggle").each(function(index)
		{
			$(this).on('click' , function(){

				var toggle = $(this).data('target');

				$(toggle).slideToggle();
			});
		});
	});
</script>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>
