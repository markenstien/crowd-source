<?php 
	require_once '../dependencies.php';

	if(postRequest('closeJob'))
		closeJob($_POST['jobid']);

	if(postRequest('openJob'))
		openJob($_POST['jobid']);

	if(postRequest('postJob'))
		postJob($_POST['jobid']);

	$job = getJob($_GET['id']);
	$company = getCompanyInfo($job['companyid']);
?>

<?php build('content') ?>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="card-title">
						<h4><?php echo $job['title'] . ' - '. $job['sub_title']?></h4>
						<label class="badge badge-info">Urgency :</label>
						<label class="badge badge-warning"><?php echo $job['urgency']?></label>
						<label class="badge badge-primary"><?php echo $job['status']?></label>
					</div>
				</div>
				<div class="card-body">
					<h4>Job Description</h4>
					<table class="table">
						<tr>
							<th>Position</th>
							<th><?php echo $job['position']?></th>
						</tr>
						<tr>
							<th>Salary</th>
							<th><?php echo $job['salary']?></th>
						</tr>
						<tr>
							<th>Type</th>
							<th><?php echo $job['salary_type']?></th>
						</tr>
						<tr>
							<th>Categories</th>
							<th>
								<?php
									$categories = explode(',', $job['categories']);

									foreach($categories as $cat) 
										echo '#'.$cat;
								?>
							</th>
						</tr>
						<tr>
							<th><h4>Requirements</h4></th>
						</tr>
						<tr>
							<th>Education</th>
							<th><?php echo $job['education']?></th>
						</tr>
						<tr>
							<th>Gender</th>
							<th><?php echo $job['gender']?></th>
						</tr>
						<tr>
							<th>Urgency</th>
							<th><?php echo $job['urgency']?></th>
						</tr>
						<tr>
							<th>Duration</th>
							<th><?php echo $job['duration']?></th>
						</tr>
						<tr>
							<th>Employee Needed</th>
							<th><?php echo $job['employee_needed']?></th>
						</tr>
					</table>

					<div>
						<h4>Notes</h4>
						<p><?php echo $job['notes']?></p>
					</div>
				</div>

				<div class="card-footer">
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
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">
						<a href="company_view.php?id=<?php echo $company['id']?>"><?php echo $company['name']?></a>
						<?php echo '-' .$company['type']?>
					</h4>
				</div>

				<div class="card-body">
					<img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>" id="compLogo">
					<div class="text-center">
						<dl>
							<dd><?php echo $company['email']?></dd>
							<dd><?php echo $company['phone']?></dd>
							<dd><?php echo $company['address']?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</div>	
<?php endbuild()?>
<?php
	build('breadcrum');
		loadBreadCrumb('Job Preview');
	endbuild();
	loadTo('orbit/app-admin');
?>