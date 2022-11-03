
<?php
	require_once '../dependencies.php';

	if(postRequest('create_company'))
		createCompany($_POST);

	$businessNatures = getBusinessNatures();
?>

<?php build('breadcrum')?>
	<?php loadBreadCrumb('companies')?>
<?php endbuild() ?>
<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Create Companies</h4>
		</div>

		<div class="card-body">
			<form method="post" enctype="multipart/form-data" enctype="multipart/form-data">
				<div class="row">
					<section class="col-md-6">
						<fieldset>
							<legend>General</legend>
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" placeholder="Company Name" class="form-control" 
								value="<?php echo $_POST['name'] ?? ''?>" required>
							</div>
							<div class="form-group">
								<label>Nature Of business</label>
								<select name="type" class="form-control" id="bizNature" required>
									<option value="">-Select </option>
									<?php foreach($businessNatures as $nature) :?>
										<option value="<?php echo $nature['nature'];?>"><?php echo ucfirst($nature['nature']);?></option>
									<?php endforeach;?>
									<option value="others">Others..</option>
								</select>

								<div id="businessNatureOthers">
									<small>Other Nature of business</small>
									<input type="text" name="type_other" placeholder="Type Name" class="form-control" 
									value="<?php echo $_POST['type'] ?? ''?>">
								</div>
								
							</div>
							<div class="form-group">
								<label>Description</label>
								<input type="text" name="description" placeholder="Description" class="form-control" 
								value="<?php echo $_POST['description'] ?? ''?>" required>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" placeholder="Email" class="form-control" 
								value="<?php echo $_POST['email'] ?? ''?>" required>
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input type="text" name="phone" placeholder="Phone" class="form-control" 
								value="<?php echo $_POST['phone'] ?? ''?>" required>
							</div>
							<div class="form-group">
								<label>Address</label>
								<input type="text" name="address" placeholder="Address" class="form-control" 
								value="<?php echo $_POST['address'] ?? ''?>" required>
							</div>
						</fieldset>

						<fieldset>
							<legend>Others</legend>
							<div class="inline-block">
								<label>Banner</label>
								<input type="file" name="banner" required>
							</div>

							<div class="inline-block">
								<label>Logo</label>
								<input type="file" name="logo" required>
							</div>
						</fieldset>
					</section>
					<section class="col-md-6">
						<fieldset>
							<legend>Login</legend>
							<p class="text-danger">Logins will be automated and be sent to customers email.</p>
						</fieldset>

						<fieldset>
							<legend>Contact</legend>
							<div class="form-group">
								<label>Person</label>
								<input type="text" name="contact_person" placeholder="Contact name" class="form-control" 
								value="<?php echo $_POST['contact_person'] ?? ''?>" required>
							</div>
							<div class="form-group">
								<label>Number</label>
								<input type="text" name="contact_number" placeholder="Contact number" class="form-control" 
								value="<?php echo $_POST['contact_number'] ?? ''?>" required>
							</div>
						</fieldset>
						<input type="submit" name="create_company" class="btn btn-primary" value="Create Company">
					</section>
				</div>
			</form>	
		</div>
	</div>
<?php endbuild()?>


<?php build('scripts')?>

<script type="text/javascript">
	$( document ).ready(function()
	{
		$("#businessNatureOthers").hide();

		$("#bizNature").change(function(evt){

			if($(this).val() === 'others') 
			{
				$("#businessNatureOthers").show();
			}else{
				$("#businessNatureOthers").hide();
			}
		});
	});
</script>

<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>