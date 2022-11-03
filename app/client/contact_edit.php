<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>
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

	$personal = __profile()->getPersonal();
?>


<?php build('content') ?>
<div style="height: 75px;"></div>

<div class="card">
	<div class="card-header">
		<h3>Contact Update</h3>
		<?php Flash::show()?>
	</div>

	<div class="card-body">
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
</div>
<?php endbuild()?>


<?php loadTo('orbit/app')?>

