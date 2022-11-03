<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant Appointments Schedules') ;?>
		<?php $company = Session::get('company'); ?>
		<?php  $scheduleList = getAppointmentList(" WHERE job.companyid = '{$company['id']}' and appointment_for = 'company' and aa.status != 'finished' order by aa.status desc ") ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant Appointments
			</div>

			<div class="panel-body">
				<table class="table">
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
						<?php foreach($scheduleList as $sched) :?>
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
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>