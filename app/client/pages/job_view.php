<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.content{
		padding: 10px;
		background: #fff;
		margin: 20px;
	}
	section #banner img
	{
		width: 100%;
		height: 350px;
	}

	section #logo img 
	{
		width: 150px;
	}
</style>
</head>
<body>
<?php 
	if(postRequest('apply')){
		apply();
	}
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php $job = getJob($_GET['id']);?>

		<?php $comp = getCompanyInfo($job['companyid']);?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-body">
				<div style="width: 80%; margin: 0px auto;">
					<section class="job-details">
					<section id="banner">
						<img src="<?php echo URL.DS.'public/assets/'.$comp['banner']?>">
					</section>
					<div class="row">
						<section class="job-description content col-md-5">
							<h3>Job Description</h3>
							<section>
								<div>Company : <strong><?php echo $job['comp_name'];?></strong></div>
								<div>Position : <strong><?php echo $job['position'];?></strong></div>
								<div><strong><?php echo $job['title'];?></strong></div>
								<div><strong><?php echo $job['sub_title'];?></strong></div>
							</section>
							<hr>

							<div id="">
								<div>- <strong> Notes</strong></div>
								<p>
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
						</section>

						<section class="job-description content col-md-5">
							<section id="logo">
								<img src="<?php echo URL.DS.'public/assets/'.$comp['logo']?>">
							</section>
							<section>
								<h3>Contact and Address</h3>
								<div>- Address: <strong><?php echo $job['address']?></strong></div>

								<div>- Email: <strong><?php echo $job['email']?></strong></div>

								<div>- Phone: <strong><?php echo $job['phone']?></strong></div>
							</section>
						</section>
					</div>

					<section class="content">
						<h3>Salary</h3>
						<div>- Salary: <strong><?php echo $job['salary']?></strong></div>

						<div>- Salary type: <strong><?php echo $job['salary_type']?></strong></div>
					</section>

					<section class="content">
						<h3>Others</h3>
						<div>- Urgency: <strong><?php echo $job['urgency']?></strong></div>
						<div>- Education: <strong><?php echo $job['education']?></strong></div>
						<div>- Gender: <strong><?php echo $job['gender']?></strong></div>
						<div>- Duration: <strong><?php echo $job['duration']?></strong></div>
						<div>- Employee needed: <strong><?php echo $job['employee_needed']?></strong></div>
					</section>

					<section class="salary-information content">
						<form method="post">
							<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
							<input type="submit" name="apply" class="btn btn-warning" value="Apply Now">
						</form>
					</section>
				</section>
				</div>
			</div>
		</div>
		

		<div class="row">
		
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>