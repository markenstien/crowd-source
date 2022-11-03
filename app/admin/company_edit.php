<?php require_once '../dependencies.php';?>

<?php
	if(postRequest('updateGeneral'))
		updateGeneral($_POST);

	if(postRequest('updateBanner'))
		updateBanner($_POST['companyid'] , $_FILES['banner']);

	if(postRequest('updateLogo'))
		updateLogo($_POST['companyid'] , $_FILES['logo']);


	if(postRequest('updateUsername'))
		updateCompanyUsername($_POST['companyid'], $_POST['username']);

	if(postRequest('updatePassword'))
		updateCompanyPassword($_POST['companyid'], $_POST['new_password']);

	if(postRequest('updateContact'))
		updateCompanyContact($_POST);

	if(postRequest('updatePermit'))
		updatePermit($_POST['companyid'] , $_FILES['permit']);

	if(postRequest('updateContract'))
		updateContract($_POST['companyid'] , $_FILES['contract']);

	$company = getCompanyInfo($_GET['id']);
?>
<?php build('headers') ?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}
	.banner , .logo
	{
		width: 350px;
	}
	.banner img , .logo img
	{
		width: 100%;
	}
</style>
<?php endbuild()?>


<?php build('content') ?>
<?php spaceUp()?>
<div class="card card-theme-dark">
	<?php Flash::show();?>
	<div class="card-header">
		<h4 class="card-title">Company information</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<section class="col-md-6">
				<form method="post">
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<fieldset>
						<legend>General</legend>
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" placeholder="Company Name" class="form-control" 
							value="<?php echo $company['name']?>">
						</div>
						<div class="form-group">
							<label>Nature Of business</label>
							<input type="text" name="type" placeholder="Type Name" class="form-control" 
							value="<?php echo $company['type']?>">
						</div>
						<div class="form-group">
							<label>Description</label>
							<input type="text" name="description" placeholder="Description" class="form-control" 
							value="<?php echo $company['description']?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" placeholder="Email" class="form-control" 
							value="<?php echo $company['email']?>">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" placeholder="Phone" class="form-control" 
							value="<?php echo $company['phone']?>">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" placeholder="Address" class="form-control" 
							value="<?php echo $company['address']?>">
						</div>
					</fieldset>
					<fieldset>
						<legend>Contact</legend>
						<div class="form-group">
							<label>Person</label>
							<input type="text" name="contact_person" placeholder="Contact name" class="form-control" 
							value="<?php echo $company['contact_person']?>">
						</div>
						<div class="form-group">
							<label>Number</label>
							<input type="text" name="contact_number" placeholder="Contact number" class="form-control" 
							value="<?php echo $company['contact_number']?>">
						</div>
					</fieldset>
					<!-- <div class="form-group">
						<label>Password</label>
						<input type="password" name="password" placeholder="Password" class="form-control" required>
					</div> -->

					<div class="form-group">
						<input type="submit" name="updateGeneral" class="btn btn-primary" value="Update General">
					</div>
				</form>

				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<div class="banner">
						<img src="<?php echo URL.DS.'public/assets/'.$company['banner']?>">
					</div>
					<div class="inline-block">
						<label>Banner</label>
						<input type="file" name="banner">
					</div>
					<hr>
					<div class="form-group">
						<input type="submit" name="updateBanner" class="btn btn-primary" value="Update Banner">
					</div>
				</form>

				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<div class="banner">
						<img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>">
					</div>
					<div class="inline-block">
						<label>Logo</label>
						<input type="file" name="logo">
					</div>
					<hr>
					<div class="form-group">
						<input type="submit" name="updateLogo" class="btn btn-primary" value="Update Logo">
					</div>
				</form>
			</section>

			<section class="col-md-6">
				<!-- <form method="post">
					<legend>Update Username</legend>
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" placeholder="Username" class="form-control" 
						value="<?php echo $company['username']?>">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" placeholder="Password" class="form-control">
					</div>
					<input type="submit" name="updateUsername" class="btn btn-primary" value="Update Username">
				</form> -->
				<hr>
				<form method="post">
					<legend>Update Password</legend>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" placeholder="Username" class="form-control" 
						value="<?php echo $company['username']?>" disabled>
					</div>
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<!-- <div class="form-group">
						<label>Old Password</label>
						<input type="password" name="old_password" placeholder="Old Password" class="form-control">
					</div> -->

					<div class="form-group">
						<label>New Password</label>
						<input type="password" name="new_password" placeholder="New Password" class="form-control">
					</div>
					<input type="submit" name="updatePassword" class="btn btn-primary" value="Update Password">
				</form>
				<hr>

				<form method="post" enctype="multipart/form-data">
					<?php if(!empty($company['permit'])):?>
						<a href="file_viewer.php?filename=<?php echo $company['permit']?>" target="_blank">View Permit</a>
					<?php else:?>
						<p>No Permit</p>
					<?php endif;?>
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<div class="form-group">
						<label>Permit</label>
						<input type="file" name="permit" class="form-control">
					</div>
					<input type="submit" name="updatePermit" class="btn btn-primary" value="Update Permit">
				</form>
				<hr>
				<form method="post" enctype="multipart/form-data">
					<?php if(!empty($company['contract'])):?>
						<a href="file_viewer.php?filename=<?php echo $company['contract']?>" target="_blank">View Contract</a>
					<?php else:?>
						<p>No Contract And Agreement</p>
					<?php endif;?>
					<input type="hidden" name="companyid" value="<?php echo $_GET['id']?>">
					<div class="form-group">
						<label>Contract And Agreement</label>
						<input type="file" name="contract" class="form-control">
					</div>
					<input type="submit" name="updateContract" class="btn btn-primary" value="Update Contract">
				</form>
			</section>
		</div>
	</div>
</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>