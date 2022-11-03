<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.clean-box{
		background: #fff;
		padding: 10px;
		width: 300px;
		margin-bottom: 10px;
	}
</style>
</head>
<body>
	<?php
		if(postRequest('changepwd'))
		{
			changePassword($_POST['password']);
		}

		if(postRequest('update_profile'))
		{
			uploadProfile($_POST['userid']);
		}
	?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Profile Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				User Profile
			</div>

			<div class="panel-body">
				<?php $user = new Profile();?>
				<?php
					$personal = $user->getPersonal();
					$education = $user->getEducation();
				?>
				<h3>Profile</h3>

				<div>
					<?php  echo convertImage($personal['profile'])?>
				</div>
				<section>
					<?php
						FormOpenMeta([
							'method' => 'post'
						]);
						FormHidden('userid' , $user->getId());
						FormFile('profile');

						FormSubmit('update_profile' , 'Update Profile' , [
							'btn btn-primary btn-sm'
						]);

						FormClose();
					?>
				</section>
				<section>
					<h3>Personal</h3>
					<ul>
						<li>Firstname : <strong><?php echo $personal['firstname']?></strong> </li>
						<li>Lastname : <strong><?php echo $personal['lastname']?></strong></li>
						<li>Gender : <strong><?php echo $personal['gender']?></strong></li>
						<li>Birthday : <strong><?php echo $personal['birthday']?></strong></li>
					</ul>
				</section>

				<section>
					<h3>Contact</h3>
					<ul>
						<li>Email : <strong><?php echo $personal['email']?></strong></li>
						<li>Phone : <strong><?php echo $personal['phone']?></strong> </li>
						<li>Address :<strong><?php echo $personal['address']?></strong> </li>
					</ul>

					<div class="col-md-5">
						<form method="post">
							<legend>Change Password</legend>
							<div class="form-group">
								<input type="password" name="password" class="form-control">
							</div>
							<input type="submit" name="changepwd" class="btn btn-primary" value="Change Password">
						</form>
					</div>
					
				</section>
			</div>
		</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>