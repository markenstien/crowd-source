<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant Management') ;?>
		<?php 
			$company = Session::get('company');
		?>
		<?php  $applicantList = getApplicantList( " WHERE 
			job.companyid = '{$company['id']}' and ja.status = 'passed'") ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant List
			</div>

			<div class="panel-body">
				<table class="table">
					<thead>
						<th>Applicant</th>
						<th>Label</th>
						<th>Position</th>
						<th>Date</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($applicantList as $applicant) :?>
							<tr>
								<td>
									<a href="applicant_view.php?id=<?php echo $applicant['userid']?>"><?php echo $applicant['fullname']?></a>
								</td>
								<td><?php echo $applicant['status_label']?></td>
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
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>