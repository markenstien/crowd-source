<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php $companyid = Session::get('company')['id'];?>
		<?php  $job_list = getJobList( " WHERE companyid = '$companyid'") ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job List
			</div>

			<div class="panel-body">
				<table class="table">
					<thead>
						<th>Title</th>
						<th>Status</th>
						<th>Sub Title</th>
						<th>Position</th>
						<th>Vacant</th>	
						<th>Notes</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($job_list as $job) :?>
							<?php $totalEmployed = totalEmployed($job['id']);?>

							<?php if($totalEmployed == $job['employee_needed']){ continue ;}?>
							<tr>
								<td><?php echo $job['title']?></td>
								<td><?php echo $job['status']?></td>
								<td><?php echo $job['sub_title']?></td>
								<td><?php echo $job['position']?></td>
								<td><?php echo  $totalEmployed.' out of '.$job['employee_needed']?></td>
								<td><?php echo limitText($job['notes'] , '10')?></td>
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
<?php require_once APPROOT.DS.'templates/user/footer.php';?>