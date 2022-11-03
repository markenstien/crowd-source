<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
	<?php
		if(postRequest('readMessage'))
		{
			readMessage($_POST['notifid']);
		}
	?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<?php
		$summary = new Summary();

		$notificationList = getNotifications( " WHERE date(created_at) = date(now()) ORDER BY status desc limit 30");
	?>
	<?php  $job_list = getJobList( " WHERE date(jobs.created_at) = date(now()) order by jobs.status asc") ;?>
	<?php  $applicantList = getApplicantList("WHERE ja.date_applied = date(now()) and ja.status = 'pending'") ;?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Dashboard') ;?>
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-4 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-blue"></em>
							<div class="large"><?php echo $summary->company();?></div>
							<div class="text-muted">Companies</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
							<div class="large"><?php echo $summary->jobPost();?></div>
							<div class="text-muted">Job Post</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-teal"></em>
							<div class="large"><?php echo $summary->user();?></div>
							<div class="text-muted">Users</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				Job Post Today.
			</div>

			<div class="panel-body">
				<table class="table <?php echo count($job_list) > 10 ? 'myTable':'' ?>">
					<thead>
						<th>Title</th>
						<th>Sub Title</th>
						<th>Company</th>
						<th>Position</th>	
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Status</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($job_list as $job) :?>
							<tr>
								<td><?php echo $job['title']?></td>
								<td><?php echo $job['sub_title']?></td>
								<td><?php echo $job['comp_name']?></td>
								<td><?php echo $job['position']?></td>
								<td><?php echo $job['email']?></td>
								<td><?php echo $job['phone']?></td>
								<td><?php echo limitText($job['address'] , 5)?></td>
								<td><?php echo limitText($job['status'] , 10)?></td>
								<td>
									<a href="job_view.php?id=<?php echo $job['id']?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a> 
									<a href="job_edit.php?id=<?php echo $job['id']?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-dafault">
			<div class="panel-heading">
					Job Applications
			</div>
			<div class="panel-body">
				<table class="table <?php echo count($applicantList) > 10 ? 'myTable':'' ?>">
					<thead>
						<th>Company</th>
						<th>Applicant</th>
						<th>Status</th>
						<th>Label</th>
						<th>Position</th>
						<th>Date</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($applicantList as $applicant) :?>
							<tr>
								<td>
									<a href="company_view.php?id=<?php echo $applicant['compid']?>">
										<?php echo $applicant['comp_name']?>
									</a>	
								</td>
								<td><a href="applicant_view.php?id=<?php echo $applicant['userid']?>"><?php echo $applicant['fullname']?></a>
								</td>
								<td><?php echo $applicant['status']?></td>
								<td><?php echo $applicant['label']?></td>
								<td><?php echo $applicant['position']?></td>
								<td><?php echo $applicant['date']?></td>
								<td>
									<a href="application_view.php?id=<?php echo $applicant['jaid']?>" 
										class="btn btn-primary btn-sm">
										<i class="fa fa-eye"></i>
									</a>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel panel-default ">
					<div class="panel-heading">
						Notifications
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body timeline-container">
						<ul class="timeline">
							<?php foreach($notificationList as $notif) :?>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-pushpin"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title"><?php echo $notif['subject']?></h4>
									</div>
									<div class="timeline-body">
										<p><?php echo $notif['message']?></p>
										<span>Time : <small><?php echo $notif['created_at']?></small></span>
										<?php if($notif['status'] == 'unread') :?>
											<form method="post">
												<input type="hidden" name="notifid" value="<?php echo $notif['id']?>">
												<input type="submit" name="readMessage" value="read" class="btn btn-sm btn-primary">
											</form>
											<?php else:?>
												<p>Message have been read.</p>
										<?php endif;?>
									</div>
								</div>
							</li>
							<?php endforeach?>
						</ul>
					</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<script defer>
	$(document).ready( function () {
	    $('.myTable').DataTable();
	} );
</script>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>