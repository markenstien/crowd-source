<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Employee Management') ;?>
		<?php $company = Session::get('company');?>
		<?php  $employeeList = getEmployeeList( " WHERE emp.companyid = '".$company['id']."'") ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Employee List
			</div>

			<div class="panel-body">
				<table class="table dataTable">
					<thead>
						<th>ID</th>
						<th>Type</th>
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
								<td><?php echo $emp['emp_type']?></td>
								<td><?php echo $emp['fullname']?></td>
								<td><?php echo $emp['job_title']?></td>
								<td><?php echo $emp['job_position']?></td>
								<td><?php echo $emp['salary']?></td>
								<td><?php echo $emp['salary_type']?></td>
								<td><?php echo $emp['emp_status']?></td>
								<td><a href="employee_view.php?empid=<?php echo $emp['empid']?>">Preview</a></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>