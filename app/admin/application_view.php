<!-- START -->
<?php require_once '../dependencies.php';?>

<?php
	/*ACTIONS*/
	if(postRequest('_updateApplicationStatus'))
	{
		$result = updateApplicationStatusOnly($_POST['applicationid'] , $_POST['status']);
		if($result)
			Flash::set("Application updated to {$_POST['status']}");
	}

	if(postRequest('updateApplicationLabel'))
		updateApplicationLabel($_POST['applicationid'] , $_POST['label']);

	if(postRequest('sendAppointment'))
		createAppointment($_POST);

	if(postRequest('passApplicant'))
		updateApplicationStatus($_POST['applicationid'] , 'passed' , $_POST['notes']);

	if(postRequest('failApplicant'))
		updateApplicationStatus($_POST['applicationid'] , 'failed' , $_POST['notes']);

	$ja = new JobApplication($_GET['id']);

	$jaInfo    = $ja->getJobApplicationInfo();
	$job       = $ja->getJobInfo();
	$company   = $ja->getCompany();
	$applicant = $ja->getApplicantInfo();

	$applicant = [
		'personal'        => $applicant->getPersonal(),
		'workExperiences' => $applicant->getWorkExperience(),
		'skills'          => $applicant->getSkills(),
		'education'       => $applicant->getEducation()
	];

	$appointment   = getJobApplicantAppointment($_GET['id']);

	$exam = getJobExam($job['id'],1);
	$applicantExam    = getExamByParam(" WHERE applicationid = '{$jaInfo['id']}'");

	$isEmployed = isEmployed($applicant['personal']['id']);
?>

<?php build('content')?>
<?php spaceUp()?>

<div class="card card-theme-dark">
	<div class="card-header">
		<h4>Application Details</h4>
		<?php Flash::show()?>
	</div>

	<div class="card-body">
		<div class="row">
            <div class="col-md-3">
                <img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>" id="logo" style="width: 100%">
            </div>
            <div class="col-md-9">
                <h3><?php echo $company['name'] . ' , ' . $company['type']?></h3>
                <small><?php echo $company['description']?> <strong><?php echo $company['address']?></strong> </small>
                <ul>
                    <li><?php echo $company['email']?></li>
                    <li><?php echo $company['phone']?></li>
                    <li><a href="<?php echo URL.DS."app/client/catalog.php?keyword={$company['name']}"?>" target="_blank">Vacancies</a></li>
                </ul>
            </div>
        </div>
	</div>
</div>

<div class="card card-theme-dark">
	<div class="card-header">
		<h4>Application Details</h4>
	</div>
	
	<div class="card-body">
        <h3><?php echo $applicant['personal']['fullname']?></h3>

        <?php if($isEmployed) :?>
        	<div class="alert alert-danger">
        		<p>Employee is currently employed</p>
        	</div>
        <?php endif?>
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li>Date Applied : <?php echo $jaInfo['date_applied']?></li>
                    <li>Status : <?php echo $jaInfo['status']?></li>
                    <li>Resume Image : <a href="file_viewer.php?filename=<?php echo $jaInfo['resume_image']?>" target="_blanks">Preview</a></li>
                    <li>Resume Document : <a href="file_viewer.php?filename=<?php echo $jaInfo['resume_text']?>" target="_blanks">Preview</a></li>
                    <li>
                    	<a href="applicant_view.php?id=<?php echo $applicant['personal']['id']?>">Review Account</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <p style="word-wrap: break-word;">
                    <strong>Pitch</strong> <br/>
                    <?php echo $jaInfo['applicant_pitch']?>
                </p>
            </div>
        </div>

        <?php $education = $applicant['education']?>
        <?php $skills = $applicant['skills']?>
        <div class="row">
        	<div class="col-md-4">
        		<h4>Education</h4>
				<ul>
					<li>Highest Attainment : <?php echo $education['highest_attainment']?></li>
					<li>Year : <?php echo $education['year']?></li>
					<li>School : <?php echo $education['school']?></li>
					<li>Status : <?php echo $education['status']?></li>
				</ul>
        	</div>
        	<div class="col-md-4">
        		<h4>Skills</h4>
				<?php foreach($skills as $skill) :?>
					<div>
						<div>Category : <?php echo $skill['category']?></div>
						<div>
							<p><?php echo $skill['description']?></p>
						</div>
					</div>
				<?php endforeach;?>
        	</div>
        </div>
    </div>

	<div class="card-body">
		<div class="col-md-12">
            <h4>Job Description</h4>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li> Title : <?php echo $job['title']?> </li>
                        <li> Sub : <?php echo $job['sub_title']?> </li>
                        <li> Position : <?php echo $job['position']?> </li>
                        <li> Salary : <?php echo $job['salary']?> </li>
                        <li> Salary Type : <?php echo $job['salary_type']?> </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li> Education : <?php echo $job['education']?> </li>
                        <li> Gender : <?php echo $job['gender']?> </li>
                        <li> Categories : <?php echo $job['categories']?> </li>
                        <li> Urgency : <?php echo $job['urgency']?> </li>
                        <li> Employee Needed : <?php echo $job['employee_needed']?> </li>
                    </ul>
                </div>
            </div>
        </div>
	</div>

	<div class="card-body">
		<div class="row">
		<?php for($i = 1 ; $i < 4 ; $i++) :?>
			<div class="col-md-4">
				<div> <strong> Exam 1</strong></div>
				<?php $exam = getJobExam($job['id'], $i);?>
				<?php if(empty($exam)) :?>
					<a href="#">No exam</a>
				<?php else:?>
					<?php $examTooked = hasTookExam($_GET['id'] , $exam['examid']);?>

					<!-- IF EXAMINATION IS TAKEN -->
					<?php if($examTooked):?>
						<?php $result = getExamResult(" WHERE examinationid = '{$examTooked['id']}'");?>
						<div>
							<div><?php echo $result['score'] . '%'?><?php echo $result['remarks']?></div>
							<a href="examination_result.php?resultid=<?php echo $result['id']?>" target="_blank">Review</a>
						</div>
					<?php else:?>
						<p>No Exam Taken.</p>
					<?php endif;?>
				<?php endif;?>
			</div>
		<?php endfor?>
		</div>
	</div>
</div>

<div class="card card-theme-dark">
	<div class="card-header">
		<h4>Application Proccess</h4>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<h4>Remarks</h4>
				<div>
					<strong>Status</strong>
					<p><?php echo $jaInfo['status']?></p>

					<strong>Notes</strong>
					<p><?php echo $jaInfo['notes']?></p>
				</div>

				<h4>Evaluate Employee</h4>
				<form method="post">
					<input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
					<div class="form-group">
						<label>Add Notes</label>
						<textarea name="notes" class="form-control" rows="5"><?php echo $jaInfo['notes']?></textarea>
					</div>
					<div class="form-group">
						<input type="submit" id="failApplicant" name="failApplicant" class="btn btn-danger" value="Fail">
						<input type="submit" id="passApplicant" name="passApplicant" class="btn btn-primary" value="Pass">
					</div>
				</form>
			</div>

			<div class="col-md-6">
				<h4>Appointments</h4>
				<?php if($appointment) :?>
					<a href="appointment_view.php?id=<?php echo $appointment['id']?>" target="_blank">View Appointment</a>
				<?php else:?>
					<p>No appointment at the moment <a href="appointment_create.php?applicationid=<?php echo $jaInfo['id']?>">Click here to create</a></p>
				<?php endif;?>
			</div>
		</div>
	</div>


	<div class="card-body alert alert-danger">
		<form method="post">
			<input type="hidden" name="applicationid" value="<?php echo $jaInfo['id']?>">
			<div class="form-group">
				<?php
					FormSelect('status' , ['pending','passed','failed','cancelled','denied'] , $jaInfo['status'] , [
						'class' => 'form-control'
					]);
				?>
			</div>
			<input type="submit" name="_updateApplicationStatus" value="Update Application Status"
				class="btn btn-primary">
		</form>
	</div>
</div>
<?php endbuild()?>


<?php build('headers')?>
<style type="text/css">
	.sm-content{

		border: 1px solid #fff;
		background: #eee;
		border-radius: 2px;
		padding: 20px 15px;
		margin-bottom: 10px;
	}
	.appointment 
	{
		border: 1px solid #eee;
		padding: 5px 5px;
	}
	.appointment div
	{
		margin-bottom: 7px;
	}
</style>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>