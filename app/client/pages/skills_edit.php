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
	if(postRequest('updateSkill'))
	{
		updateUserSkills($_POST['skills']);
	}

	if(postRequest('createNewSkill'))
	{
		createNewSkill($_POST['category'] , $_POST['description']);
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

			$skillCategoryList = getCategoryList();
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
					<div class="row">
						<div class="col-md-5">
							<form method="post">
								<fieldset>
									<legend>Skills</legend>
									<small>Hold *crtl* to select multiple</small>
									<select class="form-control" name="skills[]" multiple>
										<?php foreach($skillCategoryList as $cat) :?>
											<option value="<?php echo $cat['id']?>">
												<?php echo $cat['category']?>
											</option>
										<?php endforeach;?>
									</select>
								</fieldset>
								<hr>
								<input type="submit" name="updateSkill" value="Update skill" class="btn btn-primary">
							</form>
						</div>

						<div class="col-md-5">
							<form method="post" action="" class="col-md-5">
								<div class="form-group">
									<label>Category</label>
									<input type="" name="category" class="form-control">
								</div>
								<div class="form-group">
									<label>Description</label>
									<input type="" name="description" class="form-control">
								</div>
								<input type="submit" name="createNewSkill" class="btn btn-success">
							</form>
						</div>
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