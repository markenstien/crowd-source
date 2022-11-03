<?php require_once('../dependencies.php')?>


<?php require_once('functions/main.php')?>

<?php 
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
	   $response = do_action('__register' , '_register');

		if($response) {
			Flash::set("Registration success!");
			return redirect('registration_verify_page.php');
		}
	}
?>
<?php build('content')?>
<div class="col-md-6 mx-auto">	
	<?php $page = 'personal'?>
	<div class="card">
		<div class="card-header">
			<h3>Registration Page</h3>
			<?php Flash::show()?>
			<?php Flash::show('confirmation_error')?>
		</div>

		<div class="card-body">
			<?php if(isEqual($page , 'personal')) : ?>
			<?php 
				FormOpen([
					'method' => 'post',
					'action' => ''
				] , TRUE);
				FormHidden('page' , '_personal');
			?>
			<div class="form-group">
				<?php
					FormLabel('First Name');
					FormText('firstname' , '' , [
						'class' => 'form-control',
						'required' => ''
					]);
				?>
			</div>

			<div class="form-group">
				<?php
					FormLabel('Last Name');
					FormText('lastname' , '' , [
						'class' => 'form-control',
						'required' => ''
					]);
				?>
			</div>

			<div class="form-group">
				<?php
					FormLabel('Email');
					FormEmail('email' , '' , [
						'class' => 'form-control',
						'required' => ''
					]);
				?>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<?php
						FormLabel('Birthday');
						FormDate('birthday' , '', [
							'class' => 'form-control',
							'required' => ''
						]);
					?>
				</div>

				<div class="col-md-6">
					<?php
						FormLabel('Gender');
						FormSelect('gender' , ['Male' , 'Female'], '' ,[
							'class' => 'form-control',
							'required' => ''
						]);
					?>
				</div>
			</div>

			<div class="form-group">
				<a href="#">
					<?php FormCheckbox('' , '' , [
						'required' => '',
						'checked'  => ''
					])?>
					I agree to terms and condition
				</a>
			</div>

			<div class="form-group">
				<?php
					FormSubmit('_register' , 'Register')
				?>
			</div>
			<?php FormClose()?>
		<?php endif;?>	
		</div>
	</div>
</div>
<?php endbuild()?>

<?php loadTo('orbit/index.php')?>