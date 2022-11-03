<?php require_once '../dependencies.php';?>

<?php
	if(postRequest('generateReport'))
		$applicantList = reportGenerateApplicants($_POST);
?>

<?php build('content') ?>
	<?php spaceUp()?>
	<div class="card card-theme-dark">
		<?php Flash::show();?>
		<div class="card-header">
			<h3 class="card-title">Report Generation</h3>
		</div>

		<div class="card-body">
			<div class="col-md-8">
				<form method="post">
					<div class="row container-fluid">
						<div class="form-group col-md-6">
							<label>Start Date</label>
							<input type="date" name="start" class="form-control" 
							value="<?php echo $_POST['start'] ?? ''?>">
						</div>

						<div class="form-group col-md-6">
							<label>End Date</label>
							<input type="date" name="end" class="form-control" 
							value="<?php echo $_POST['end'] ?? ''?>">
						</div>
					</div>

					<div class="row container-fluid">
						<div class="form-group col-md-6">
							<label>Type</label>
							<select class="form-control" name="type">
								<option value="all">All</option>
								<option value="accepted">Accepted</option>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label>Show Report</label>
							<input type="submit" name="generateReport" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>	

			<?php if(isset($applicantList)) :?>
				<?php if(empty($applicantList)) :?>
					<div class="col-md-12">
						<p>No Application found on within the date</p>
					</div>
				<?php endif;?>

				<?php if(!empty($applicantList)) :?>
				<div class="col-md-12">
					<table class="table">
						<thead>
							<th>Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Job</th>
							<th>Company</th>
							<th>Status</th>
							<th>Date</th>
						</thead>

						<tbody>
							<?php foreach($applicantList as $applicant) :?>
								<tr>
									<td><?php echo $applicant['name']?></td>
									<td><?php echo $applicant['mobile']?></td>
									<td><?php echo $applicant['email']?></td>
									<td><?php echo $applicant['jobname']?></td>
									<td><?php echo $applicant['companyname']?></td>
									<td><?php echo $applicant['status_label']?></td>
									<td><?php echo $applicant['date']?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<div>
						<form method="post" action="export_applicants.php">
							<?php
								$parameters = base64_encode(serialize($applicantList));
							?>
							<input type="hidden" name="parameters" value="<?php echo $parameters;?>">
							<input type="submit" name="export" class="btn btn-success" value="Export">
						</form>
					</div>
					<?php endif;?>
				</div>
				<?php endif;?>			
		</div>
	</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>