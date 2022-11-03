<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}
</style>
</head>
<body>
<?php
	if(postRequest('updateGeneral'))
	{
		updateCompany($_POST);
	}

	if(postRequest('updatePassword'))
	{
		updateCompanyPassword($_POST);
	}

	if(postRequest('updateLogo'))
	{
		updateLogo($_POST['companyid']);
	}

	if(postRequest('updateBanner'))
	{
		updateBanner($_POST['companyid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php
			$company = getCompanyInfo(Session::get('company')['id']);
		?>
		<?php pageHeader('Company Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Company information
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="companyid" value="<?php echo $company['id']?>">
							<fieldset>
								<legend>General</legend>
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" placeholder="Company Name" class="form-control" 
									value="<?php echo $company['name']?>" readonly>
								</div>
								<div class="form-group">
									<label>Type</label>
									<input type="text" name="type" placeholder="Type Name" class="form-control" 
									value="<?php echo $company['type']?>" readonly>
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
									value="<?php echo $company['address']?>" readonly>
								</div>
							</fieldset>

							<input type="submit" name="updateGeneral" class="btn btn-primary btn-sm" value="Update Gneral">
						</form>

						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="companyid" value="<?php echo $company['id']?>">
							<fieldset>
								<legend>Others</legend>
								<div class="inline-block">
									<label>Change Banner</label>
									<input type="file" name="banner">
								</div>
								<input type="submit" name="updateBanner" value="change banner" class="btn btn-primary btn-sm">
							</fieldset>
						</form>
						<hr>
						<div class="divider"></div>
						<form method="post" enctype="multipart/form-data">
							<div class="inline-block">
								<label>Change Logo</label>
								<input type="file" name="logo">
							</div>
							<input type="submit" name="updateLogo" value="change logo" class="btn btn-primary btn-sm">
						</form>
					</div>

					<div class="col-md-6">	
						<form method="post" >
							<input type="hidden" name="companyid" value="<?php echo $company['id']?>">
							<section>
								<fieldset>
									<legend>Login</legend>
									<div class="form-group">
										<label>Username</label>
										<input type="text" name="username" placeholder="Username" class="form-control" 
										value="<?php echo $company['username']?>" readonly>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" placeholder="Password" class="form-control">
									</div>
								</fieldset>

								<input type="submit" name="updatePassword" class="btn btn-primary" value="Update Password">
							</section>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>