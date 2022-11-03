<?php require_once '../dependencies.php';?>
<?php
	if(postRequest('updateAppointment'))
	{
		$result = updateAppointment($_POST);

		if($result) {
			Flash::set("Appointment resent!");

			return redirect("appointment_view.php?id={$_POST['appointmentid']}");
		}
	}

	$appointment = getAppointment($_GET['id']);
	$jobApplication = new JobApplication($appointment['applicationid']);
	$applicant      = $jobApplication->getApplicantInfo();

	$personal = $applicant->getPersonal();

	$application = $jobApplication->getJobInfo();
?>
<?php build('content')?>
<?php spaceUp()?>
<div class="card">
	<div class="card-header">
		<h4>Reschedule Appointment</h4>
	</div>

	<div class="card-body">
		<?php
			FormOpen([
				'method' => 'post'
			]);

			FormHidden('appointmentid' , $appointment['id']);
		?>

		<div class="row form-group">
			<div class="col-md-6">
				<?php
					FormLabel('date');
					FormDate('date' , $appointment['dateset'], [
						'class' => 'form-control'
					]);
				?>
			</div>

			<div class="col-md-6">
				<?php
					FormLabel('Time');
					FormTime('time' , $appointment['timeset'], [
						'class' => 'form-control'
					]);
				?>
			</div>
		</div>

		<div class="form-group">
			<?php
				FormLabel('Subject');
				FormText('subject' , "Your Applicant for {$application['comp_name']} will be re-scheduled", [
					'class' => 'form-control'
				]);
			?>
		</div>

		<div class="form-group">
			<?php
				FormLabel('Message');
				FormTextarea('message' , "Dear {$personal['fullname']} , we would like to advice you that your sheduled appointment to us '{$application['comp_name']}', is will be reschedule to some reason.." , [
					'class' => 'form-control'
				]);
			?>
		</div>

		<div class="form-group">
			<?php
				FormLabel('Will be sent to');
				FormText('reciever' , $personal['email'] , [
					'class' => 'form-control',
					'readonly' => ''
				]);
			?>
		</div>

		<input type="submit" name="updateAppointment" class="btn btn-primary" 
				value="Send Appointment">
		<?php FormClose()?>
	</div>
</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>