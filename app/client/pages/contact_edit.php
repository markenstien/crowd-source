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
	if(postRequest('updatePhone'))
	{
		updateUserPhone($_POST['phone']);
	}
	if(postRequest('updateEmail'))
	{
		updateUserEmail($_POST['email']);
	}

	if(postRequest('updateAddress'))
	{
		updateUserAddress($_POST['address']);
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
					<h3>Contact Update</h3>
				</div>
				<div class="panel-body">

					<form class="form" method="post">
						<div class="row">
							<div class="col-md-1">
								Phone
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<input type="number" name="phone" class="form-control" 
									value="<?php echo $personal['phone']?>" required>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<input type="submit" name="updatePhone" class="btn btn-primary">
								</div>
							</div>
						</div>
					</form>

					<form class="form" method="post">
						<div class="row">
							<div class="col-md-1">
								E-mail
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<input type="text" name="email" class="form-control" 
									value="<?php echo $personal['email']?>" required>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<input type="submit" name="updateEmail" class="btn btn-primary">
								</div>
							</div>
						</div>
					</form>

					<form class="form" method="post">
						<div class="row">
							<div class="col-md-1">
								Address
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<input type="text" name="address" class="form-control" 
									value="<?php echo $personal['address']?>" required>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<input type="submit" name="updateAddress" class="btn btn-primary">
								</div>
							</div>
						</div>
					</form>
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