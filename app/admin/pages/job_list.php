<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $job_list = getJobList() ;?>

		<?php 
			if(isset($_GET['filter'])) {
				$type = trim($_GET['type']);

				$job_list = getJobList( " WHERE jobs.status like '%$type%'");
			}
		?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job List
			</div>

			<div class="panel-body">
				<div class="col-md-3" style="margin-bottom: 20px;">
					<form method="get" class="form-inline">
						<input type="hidden" name="filter">
						<div class="form-group">
							<label>Filter</label>
						</div>

						<div class="form-group">
							<select class="form-control" name="type">
								<option value="">-Select</option>
								<option value="posted">posted</option>
								<option value="for posting">for posting</option>
								<option value="closed">closed</option>
							</select>
						</div>

						<div class="form-group">
							<input type="submit" name="" class="btn btn-dark">
						</div>
					</form>
				</div>
				<div class="divider"></div>
				<table class="table myTable">
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
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<script defer>
	$(document).ready( function () {
	    $('.myTable').DataTable();
	} );
</script>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>