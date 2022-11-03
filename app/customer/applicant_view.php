<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>

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
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant View') ;?>
		<?php $user = new Profile($_GET['id']);?>

		<?php
			$personal = $user->getPersonal();
			$education = $user->getEducation();
			$workExperiences = $user->getWorkExperience();
			$skills   = $user->getSkills();
			$workHistory     = new WorkHistory($user->getId());
		?>
		<?php  $applicant = new Applicant($_GET['id']) ;?>

		<?php 
			$applicant = [
				'personal'  => $applicant->getPersonal(),
				'education' => $applicant->getEducation(),
				'workExperience' => $applicant->getWorkExperience(),
				'skills'  => $applicant->getSkills()
			];
		?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant Information
			</div>

			<div class="panel-content">
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
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>