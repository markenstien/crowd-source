<?php require_once '../dependencies.php';?>

<?php
	if(postRequest('create'))
		createJob($_POST);

	$comp = getCompanyInfo($_GET['id']);
	$employeeList = getEmployeeList( " WHERE emp.companyid = '{$comp['id']}'");
?>


<?php build('content') ?>
<?php spaceUp()?>
<div class="card card-theme-dark">
	<?php Flash::show();?>
	<div class="card-header">
		<h4 class="card-title">Company Info</h4>
	</div>
	<div class="panel-body">
		<div id="panel_wrapper">
			<section id="banner">
				<img src="<?php echo URL.DS.'public/assets/'.$comp['banner']?>">
			</section>

			<section id="general">
				<div class="row">
					<section class="general-1 col-md-8">
						<h3>Company Info</h3>
						<div class="detail-container"> - <a href="company_edit.php?id=<?php echo $comp['id']?>">Manage</a></div>
						<div class="detail-container"> - Name  : <?php echo $comp['name']?></div>
						<div class="detail-container"> - Type  : <?php echo $comp['type']?></div>
						<div class="detail-container"> - Email : <?php echo $comp['email']?></div>
						<div class="detail-container"> - Phone : <?php echo $comp['phone']?></div>
						<div class="detail-container"> - Permit  : <a href="file_viewer.php?filename=<?php echo $comp['permit']?>" target="_blank">View Permit</a></div>
						<div class="detail-container"> - Contract  : <a href="file_viewer.php?filename=<?php echo $comp['contract']?>" target="_blank">View Contract</a></div>
						<div class="detail-container"> - Address  : <?php echo $comp['address']?></div>
						<div class="detail-container"> - Description 
							<p><?php echo $comp['description']?></p>
						</div>
					</section>
					<section class="general-2 col-md-3">
						<div id="logo">
							<img src="<?php echo URL.DS.'public/assets/'.$comp['logo']?>">
							<strong ><small>Company Logo</small></strong>
						</div>
					</section>
				</div>
			</section>

			<section>
				<hr>
				<h3>System Report</h3>
				<?php $company = new Company($comp['id']);?>
				<div class="row">
					<div class="col-md-4">
						<h4>Applicants</h4>
						<div><?php echo $company->getTotalApplicants()?></div>
					</div>

					<div class="col-md-4">
						<h4>Job Post</h4>
						<div><?php echo $company->getTotalJobPosts()?></div>
					</div>

					<div class="col-md-4">
						<h4>Employees</h4>
						<div><?php echo $company->getTotalEmployees()?></div>
					</div>
				</div>
			</section>

			<section>
				<hr>
				<h3>Employee List</h3>
				<table class="table">
				<thead>
					<th>ID</th>
					<th>Name</th>
					<th>Job title</th>
					<th>Position</th>
					<th>Salary</th>
					<th>Salary Type</th>	
					<th>Status</th>
					<th>Action</th>
				</thead>

				<tbody>
					<?php foreach($employeeList as $emp) :?>
						<tr>
							<td><?php echo $emp['empcode']?></td>
							<td><?php echo $emp['fullname']?></td>
							<td><?php echo $emp['job_title']?></td>
							<td><?php echo $emp['job_position']?></td>
							<td><?php echo $emp['salary']?></td>
							<td><?php echo $emp['salary_type']?></td>
							<td><?php echo $emp['emp_status']?></td>
							<td><a href="employee_view.php?id=<?php echo $emp['empid']?>">Preview</a></td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			</section>
		</div>
		<hr>
	</div>
</div>
<?php endbuild()?>

<?php build('headers') ?>
	<style type="text/css">
		.space-up{
			margin: 5px;
		}
		#panel_wrapper{
			width: 1000px; 
			margin: 0px auto;
		}

		#banner img
		{
			width: 100%;
		}
		#logo
		{
			padding: 10px;
		}

		#logo img
		{
			width: 150px;
			display: block;
			margin: 0px auto;
		}
		.detail-container{
			margin-bottom: 10px;
		}
	</style>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>