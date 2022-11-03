<?php require_once '../dependencies.php';?>


<?php
	
	$userId = Session::get('user')['id'];
	
	$appointments = getAppointmentList(
		"WHERE aa.userid = '{$userId}' "
	);
?>

<?php build('content')?>
	<?php spaceUp()?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Appointments</h4>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>Date</th>
						<th>Time</th>
						<th>Applicant</th>
						<th>Status</th>
						<th>Job title</th>
						<th>Position</th>	
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($appointments as $sched) :?>
							<tr>
								<td><?php echo $sched['dateset']?></td>
								<td><?php echo $sched['timeset']?></td>
								<td><?php echo $sched['fullname']?></td>
								<td><?php echo $sched['status']?></td>
								<td><?php echo $sched['job_title']?></td>
								<td><?php echo $sched['job_position']?></td>
								<td><a href="appointment_view.php?id=<?php echo $sched['schedid']?>">Preview</a></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php loadTo('orbit/app')?>