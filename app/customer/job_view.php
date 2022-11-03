<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php
	if(postRequest('closeJob'))
	{
		closeJob($_POST['jobid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $job = getJob($_GET['id']) ;?>
		<?php  $company = getCompanyInfo($job['companyid']) ?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job Info
			</div>

			<div class="panel-body">
				<section>
					<p>Job vacancy commands</p>
					<form method="post">
						<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
						<?php if($job['status'] == 'posted') :?>
							<div class="form-group inline-block">
								<input type="submit" name="closeJob" class="btn btn-warning" value="close job">
							</div>
						<?php endif;?>
					</form>


					<section>
						<div class="row">
							<div class="col-md-6">
								<h3><?php echo $job['title']?> - <a href="profile.php"><?php echo $job['comp_name']?></a></h3>
								<p><?php echo $job['sub_title']?></p>
								<p>Status: <span class="badge"><?php echo $job['status']?></span> </p>
							</div>

							<div class="col-md-6">
								<img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>">
							</div>
						</div>
					</section>

					<section>
						<div class="row">
							<div class="col-md-5">
								<h3>Salary : <?php echo $job['salary']?></h3>
								<h3>Salary : <?php echo $job['salary_type']?></h3>
								<p style="width: 600px;">Notes <br>
									<?php echo $job['notes']?>
								</p>
							</div>

							<div class="col-md-5">
								<h3>Education : <?php echo $job['education']?></h3>
								<h3>Gender : <?php echo $job['gender']?></h3>
								<h3>Urgency : <?php echo $job['urgency']?></h3>
								<h3>Duration : <?php echo $job['duration']?></h3>
								<h3>Employee needed :  <?php echo totalEmployed($job['id'])?> of out <?php echo $job['employee_needed']?></h3>
							</div>
						</div>
					</section>

					<section>
						<h3>Company Information</h3>
						<div>Phone : <?php echo $company['phone']?></div>
						<div>Email : <?php echo $company['email']?></div>
						<div>Address : <?php echo $company['address']?></div>
					</section>
				</section>

				<div class="divider"></div>
				<hr>
				<section>
					<?php
						$applicantList = getApplicantList( " WHERE job.id = '{$job['id']}' 
							and ja.status = 'active' and ja.label = 'recommended'") ;
						?>
					<h3>Applicants</h3>
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
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>