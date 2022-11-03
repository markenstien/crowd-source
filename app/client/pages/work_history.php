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

	if(postRequest('updateWorkHistory'))
	{
		updateWorkHistory($_POST);
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

			$jobFields = getJobFields();
		?>
		<h3>Profile</h3>
		<small class="text-danger">This Page is under Construction</small>
		<?php Flash::show();?>
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

			<section class="panel">
				<div class="panel-heading">
					<h3>Work History Update</h3>
				</div>

				<div class="panel-body">
					<div class="col-md-5">
						<form method="post">
							<legend>Latest Work Experience</legend>
							<input type="hidden" name="workid" value="<?php echo $workExperiences['id']?>">
							<div class="form-group">
								<label>Field</label>
								<select class="form-control" name="field">
									<?php foreach($jobFields as $jobs) :?>
										<?php $selected = $jobs['field'] == $workExperiences['field'] ? 'selected' : '';?>
										<option value="<?php echo $jobs['fiel']?>"
											<?php echo $selected;?>><?php echo $jobs['field']?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group">
								<label>Position</label>
								<input type="text" name="position" class="form-control"
								value="<?php echo $workExperiences['position']?>">
							</div>
							<div class="form-group">
								<label>Role Description</label>
								<textarea class="form-control" rows="10" name="role_description"><?php echo $workExperiences['role_description']?></textarea>
							</div>
							<div class="form-group">
								<label>When</label>
								<div class="row">
									<div class="col-md-5">
										<label>Date</label>
										<select class="form-control" name="date">
											<?php foreach(getDates('short') as $date):?>
												<?php $selected = $workExperiences['date'] == $date ? 'selected' : '';?>
												<option value="<?php echo $date;?>"
													<?php echo $selected;?>><?php echo $date;?></option>
											<?php endforeach;?>
										</select>
									</div>
									<div class="col-md-5">
										<label>Year</label>
										<select class="form-control" name="year">
											<?php foreach(generateYear() as $year):?>
												<?php $selected = $workExperiences['year'] == $year ? 'selected':
												'';?>
												<option value="<?php echo $year;?>"
													<?php echo $selected?>><?php echo $year;?></option>
											<?php endforeach;?>
										</select>
									</div>
								</div>
							</div>
							<input type="submit" name="updateWorkHistory">
						</form>
					</div>
				</div>

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
