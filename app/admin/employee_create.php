<?php require_once '../dependencies.php';?>
<?php
	if(postRequest('addemployee'))
	{
		$result = addEmployee($_POST);
		if($result) {
			Flash::set("A new employee has been added!");
			return redirect("employee_view.php?id={$result}");
		}
	}

	$applicationid = $_GET['applicationid'];
	$jobApplication = new JobApplication($applicationid);
	$applicant      = $jobApplication->getApplicantInfo();
	$personal = $applicant->getPersonal();
	$workExperience = $applicant->getWorkExperience();
	$jaInfo = $jobApplication->getJobApplicationInfo();


	$jobInfo = $jobApplication->getJobInfo();

	$isEmployed = isEmployed($personal['id']);
?>

<?php build('content')?>
<?php spaceUp()?>
<div class="card">
	<div class="card-header">
		<h3>Add New Employee</h3>
		<?php Flash::show()?>
	</div>

	<div class="card-body">

	<?php if($isEmployed): ?>
		<div class="alert alert-danger">
			<p>Employee is currently employed</p>
		</div>
	<?php endif?>
	<?php
		FormOpen([
			'method' => 'post'
		]);

		FormHidden('applicationid' , $jaInfo['id']);
		FormHidden('companyid' , $jobInfo['companyid']);
		FormHidden('userid' , $personal['id']);

		if(isset($appointment))
			FormHidden('appointmentid' , $appointment['id']);
		
	?>

	<div class="form-group">
		<label>Date Started</label>
		<input type="date" name="date_started" class="form-control" required>
	</div>

	<div class="form-group">
		<label>Job title</label>
		<input type="text" name="job_title" class="form-control" 
		value="<?php echo $jobInfo['title']?>">
	</div>

	<div class="form-group">
		<label>Position</label>
		<input type="text" name="position" class="form-control" 
		value="<?php echo $jobInfo['position']?>">
	</div>

	<div class="form-group">
		<label>Salary</label>
		<input type="text" name="salary" class="form-control" 
		value="<?php echo $jobInfo['salary']?>">
	</div>

	<div class="form-group">
		<label>Salary Type</label>
		<?php
			FormSelect('salary_type' , salary_type_list(), $jobInfo['salary_type'] , [
				'class' => 'form-control'
			])
		?>
	</div>

	<input type="submit" name="addemployee" class="btn btn-primary" value="Add Employee">
	<a href="appointment_view.php?id=1" class="btn btn-primary btn-warning">Cancel</a>

	<?php
		FormClose();
	?>		
	</div>
</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>