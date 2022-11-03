<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php

	if(postRequest('updateUsername'))
	{
		updateUsername($_POST['username']);
	}

	if(postRequest('updatePassword'))
	{
		updateUserPassword($_POST['password']);
	}

	$auth = auth();
?>

<?php build('content') ?>
<div style="height: 75px;"></div>

<div class="card">
	<div class="card-header">
		<h3>Authentication Update</h3>
		<?php Flash::show()?>
	</div>

	<div class="card-body">
		<form class="form" method="post">
			<div class="row">
				<div class="col-md-1">
					Username
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<input type="text" name="username" class="form-control" 
						value="<?php echo $auth['username']?>" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input type="submit" name="updateUsername" class="btn btn-primary">
					</div>
				</div>
			</div>
		</form>

		<form class="form" method="post">
			<div class="row">
				<div class="col-md-1">
					Password
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<input type="password" name="password" class="form-control" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input type="submit" name="updatePassword" class="btn btn-primary">
					</div>
				</div>
			</div>
		</form>	
	</div>
</div>

<?php endbuild()?>


<?php loadTo('orbit/app')?>

