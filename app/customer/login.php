<?php require_once '../dependencies.php';?>
<?php require_once APPROOT.DS.'templates/client/header.php';?>
<style type="text/css">
	.job{
		background: #fff;
		border-bottom: 1px solid #000;
		margin-bottom: 10px;
		padding: 10px 15px;
	}
	.job .job-logo img{
		min-width: 100px;
	}

	.job_list{
		padding: 10px;
		background: #eee;
	}

	#jobList{
		overflow-y: scroll;
		height: 1000px;
	}

	#mainCentre{

		width: 600px;
		margin: 0px auto;

		margin-bottom: 10px;
	}
</style>
</head>
<body>
<?php 	

	if(postRequest('login'))
	{
		login($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>

<div class="col-md-12">
		<div class="panel panel-default" id="mainCentre">
			<div class="panel-heading">Log in</div>
			<div class="panel-body">
				<form role="form" method="post">
					<input type="hidden" name="type" value="company">
					<fieldset>
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
							<select class="form-control" name="type">
								<option value="company">Company</option>
								<option value="vendor">Vendor</option>
							</select>
						</div>
						<input type="submit" name="login" value="Login" class="btn btn-primary">
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>