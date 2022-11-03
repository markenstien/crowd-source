<?php require_once '../dependencies.php';?>

<?php
	if(postRequest('createExam'))
	{
		examCreate($_POST);
	}
?>

<?php build('content') ?>
	<?php spaceUp()?>
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Create Exam</h4>
			<?php Flash::show();?>
		</div>

		<div class="card-body">
			<div class="col-md-5">
				<form method="post">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control">	
					</div>

					<div class="form-group">
						<label>Description</label>
						<input type="text" name="desc" class="form-control">	
					</div>

					<div class="form-group">
						<label>Duration</label>
						<input type="text" name="duration" class="form-control" placeholder="eg. 3:30">	
						<small>Always use the hour:min syntax</small>
					</div>

					<input type="submit" name="createExam" class="btn btn-primary" value="Create Exam">
				</form>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>