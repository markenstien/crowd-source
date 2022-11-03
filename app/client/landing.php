<?php require_once('../dependencies.php')?>

<?php 	

	if(postRequest('login'))
	{
		login($_POST);
	}
?>

<?php build('content')?>
<section class="banner">
	<div class="container">
		<div class="row">
			<div class="col-md-6 mr-5">
				<section class="section-content">
					<h3>All in one job recruitment and HR management system</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat.
					</p>
					<a href="register.php" class="btn btn-primary btn-sm"> Join now</a>
				</section>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h4>Portal Login</h4>	
					</div>
					<div class="card-body">
						<?php if(!dontAllowUser()) :?>
							<?php
								FormOpen([
									'method' => 'post',
								]);
							?>
								<?php Flash::show();?>
								<?php Flash::show('registration');?>

								<div class="form-group">
									<label>Username</label>
									<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
								</div>

								<div class="form-group">
									<label>Password</label>
									<input class="form-control" placeholder="Password" name="password" type="password" value="">
								</div>

								<div class="form-group">
									<label>Type</label>
									<?php 
										FormSelect('type' , [
											'client' => 'Applicant',
											'company' => 'Employer',
											'vendor'  => 'Vendor'
										] , '' , [
											'class' => 'form-control',
											'required' => ''
										]);
									?>
								</div>

								<input type="submit" name="login" value="Login" class="btn btn-primary">
							<?php FormClose()?>
						</div>
						<?php else:?>
							<?php redirectTo();?>
						<?php endif;?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="introduction section-content">
	<div class="container text-center">
		<h3>Introduction</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>

		<img src="<?php echo URL.DS.'public/banner.jpg'?>">
	</div>
</section>

<section class="companies section-content">
	<div class="container">
		<h3>Companies</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>

		<div class="row">
			<?php $companies = getCompanyList();?>
			<?php foreach($companies as $key => $row) :?>
				<?php if(!file_exists(BASEROOT.DS.'public/assets/'.$row['logo'])) continue; ?>
				<div class="col-md-3">
					<a href="#">
						<img src="<?php echo URL.DS.'public/assets/'.$row['logo']?>" style="width: 150px;">
					</a>
				</div>
			<?php endforeach?>
		</div>
	</div>
</section>
<?php endbuild()?>

<?php build('headers') ?>
<style type="text/css">
	.banner {
		padding: 40px;
		background: url(<?php echo URL.'/public/landing_1.jpg'?>);
		background-size: cover;
		background-position: center;
		height: 70vh;
	}
	.section-content{
		margin: 5px 0px;
		background-color: #fff;
		padding: 50px 30px;
	}
</style>
<?php endbuild()?>
<?php loadTo('orbit/index.php')?>