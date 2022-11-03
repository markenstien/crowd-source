<?php 
	require_once '../dependencies.php';
	if(postRequest('create'))
		createCategory($_POST);
?>

<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Categories</h4>
			<?php Flash::show()?>
		</div>

		<div class="card-body">
			<form method="post" action="" class="col-md-5">
				<div class="form-group">
					<label>Category</label>
					<input type="" name="category" class="form-control">
				</div>
				<div class="form-group">
					<label>Description</label>
					<input type="" name="description" class="form-control">
				</div>
				<input type="submit" name="create" class="btn btn-success">
			</form>
		</div>
	</div>	
<?php endbuild()?>
<?php
	build('breadcrum');
		loadBreadCrumb('Categories');
	endbuild();
	loadTo('orbit/app-admin');
?>