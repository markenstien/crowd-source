<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	#compLogo
	{
		width: 200px;
	}
</style>
</head>
<body>
<?php
	if(postRequest('closeJob'))
	{
		closeJob($_POST['jobid']);
	}

	if(postRequest('openJob'))
	{
		openJob($_POST['jobid']);
	}

	if(postRequest('postJob'))
	{
		postJob($_POST['jobid']);
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

						<?php if($job['status'] != 'posted') :?>
							<div class="form-group inline-block">
								<input type="submit" name="postJob" class="btn btn-success" value="Post job">
							</div>
						<?php endif;?>

						<?php if($job['status'] == 'posted') :?>
							<div class="form-group inline-block">
								<input type="submit" name="closeJob" class="btn btn-warning" value="close job">
							</div>
						<?php endif;?>

						<?php if($job['status'] == 'closed') :?>
							<div class="form-group inline-block">
								<input type="submit" name="openJob" class="btn btn-primary" value="re-open job">
							</div>
						<?php endif;?>
					</form>


					<section>
						<div class="row">
							<div class="col-md-6">
								<h3><?php echo $job['title']?> - <a href="company_view.php?id=<?php echo $company['id']?>"><?php echo $job['comp_name']?></a></h3>
								<p><?php echo $job['sub_title']?></p>
								<p>Status: <span class="badge"><?php echo $job['status']?></span> </p>
							</div>

							<div class="col-md-6">
								<img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>" id="compLogo">
							</div>
						</div>
					</section>

					<section>
						<div class="row">
							<div class="col-md-5">
								<h3>Position: <?php echo $job['position']?></h3>
								<h3>Salary : <?php echo $job['salary']?></h3>
								<h3>Type: <?php echo $job['salary_type']?></h3>
								<p style="width: 600px;">Notes <br>
									<?php echo $job['notes']?>
								</p>
								<p>
									<?php if(!empty($job['categories'])) :?>
									<?php 
										$categories = explode(',', $job['categories']);

										echo ' <strong> Current Categories </strong>';
										foreach($categories as $cat) {
											echo '#'.$cat;
										}
									?>
									<?php else:?>
										<p>No Categories</p>
									<?php endif;?>
								</p>
							</div>

							<div class="col-md-5">
								<h3>Education : <?php echo $job['education']?></h3>
								<h3>Gender : <?php echo $job['gender']?></h3>
								<h3>Urgency : <?php echo $job['urgency']?></h3>
								<h3>Duration : <?php echo $job['duration']?></h3>
								<h3>Employee needed : <?php echo $job['employee_needed']?></h3>
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
					<?php  $applicantList = getApplicantList( " WHERE ja.status_label != 'complete' and job.id = '{$job['id']}' ORDER BY ja.id desc ") ;?>
					<div class="panel panel-default">
						<?php Flash::show();?>
						<div class="panel-heading">
							Applicant List
						</div>

						<div class="panel-body">
							<table class="table <?php echo count($applicantList) > 10 ? 'myTable' : ''?>">
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
				</section>
				</div>
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>