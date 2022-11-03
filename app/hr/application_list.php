<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant Management') ;?>
		<?php  $applicantList = getApplicantList() ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant List
			</div>

			<div class="panel-body">
				<table class="table">
					<thead>
						<th>Company</th>
						<th>Applicant</th>
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
								<td><a href="applicant_view.php?id=<?php echo $applicant['userid']?>"><?php echo $applicant['fullname']?></a></td>
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