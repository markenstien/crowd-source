<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>

<style type="text/css">
	.clean-box{
		background: #fff;
		padding: 10px;
		width: 300px;
		margin-bottom: 10px;
	}
	#image
	{
		width: 150px;
		height: 150px;
		background: red;
	}
	#image img {
		width: 100%;
	}
</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Applicant View') ;?>
	
		<?php $work = new Work($_GET['workid']);?>
		<?php $details = $work->getDetails();?>
		<?php $standing = $work->getStanding();?>
		<?php $company = getCompanyInfo($details['companyid']) ?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicant Information
			</div>

			<div class="panel-content">
				<!-- TOP CONTENT -->
				<section class="content-container container-fluid">
					<h3>Work Information</h3>
					<p>
						Employment status : <strong><?php echo $details['employment_status'] ?></strong>
					</p>
					<div>
						<ul>
							<li>Start : <?php echo $details['date_started']?> </li>
							<li>Employee Code :<?php echo $details['empcode']?></li>
							<li>Job : <?php echo $details['job_title']?></li>
							<li>Position : <?php echo $details['position']?></li>
							<li>Salary Type: <?php echo $details['salary_type']?></li>
							<li>Salary : <?php echo $details['salary']?></li>
							<li>Company : <a href="company_view.php?id=<?php echo $details['companyid']?>"><?php echo $details['company_name']?></a></li>
						</ul>
					</div>
				</section>
				<section class="content-container container-fluid">
					<h3>Work Standing</h3>
					<table class="table">
						<thead>
							<th>Punctuality</th>
							<th>Personal Performance</th>
							<th>Performance Quality</th>
							<th>Notes</th>
							<th>Remarks</th>
						</thead>

						<tbody>
							<?php foreach($standing as $row) :?>
								<tr>
									<td><?php echo $row['punctuality']?></td>
									<td><?php echo $row['personal_performance']?></td>
									<td><?php echo $row['performance_quality']?></td>
									<td>
										<p style="width: 300px;"><?php echo $row['notes']?></p>
									</td>
									<td>remarks</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>