<?php require_once '../dependencies.php';?>

<?php 	

	if(postRequest('login')){
		login($_POST);
	}

	redirectTo();
?>

<?php build('content') ?>

	<div class="col-md-5 mx-auto">
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
					<p>You are currently logged in</p>
				<?php endif;?>	
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php loadTo('orbit/index.php')?>