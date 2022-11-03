<?php 
	require_once '../dependencies.php';
	$job_list = getJobList();

	if(isset($_GET['filter'])) {
		$type = trim($_GET['type']);

		$job_list = getJobList( " WHERE jobs.status like '%$type%'");
	}
?>

<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Job Management</h4>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table dataTable">
					<thead>
						<th>Title</th>
						<th>Status</th>
						<th>Company</th>
						<th>Position</th>	
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Vacant</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($job_list as $job) :?>
							<?php $totalEmployed = totalEmployed($job['id']);?>
							<?php if($totalEmployed >= $job['employee_needed']) { continue ;}?>
							<tr>
								<td><?php echo $job['title']?></td>
								<td><?php echo $job['status']?></td>
								<td><?php echo $job['comp_name']?></td>
								<td><?php echo $job['position']?></td>
								<td><?php echo $job['email']?></td>
								<td><?php echo $job['phone']?></td>
								<td><?php echo limitText($job['address'] , 5)?></td>
								<td><?php echo  $totalEmployed. ' out of ' .$job['employee_needed']?></td>
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
	</div>	
<?php endbuild()?>


<?php
	build('breadcrum');
		loadBreadCrumb('Job Management');
	endbuild();
	loadTo('orbit/app-admin');
?>