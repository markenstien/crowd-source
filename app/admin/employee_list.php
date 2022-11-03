<?php require_once '../dependencies.php';?>
<?php  $employeeList = getEmployeeList( " order by emp.id desc ") ;?>
<?php
	if(isset($_GET['filter'])) {

		$type = trim(strtolower($_GET['type']));

		switch ($type) {
			case 'non-regular':
				$employeeList = getEmployeeList( " WHERE emp_type like '%non-regular%' and status ='active'");
				break;
			case 'regular':
				$employeeList = getEmployeeList( " WHERE emp_type like '%regularr%'");
				break;

			case 'terminated':
				$employeeList = getEmployeeList( " WHERE emp.status ='inactive'");
				break;
		}
	}
?>
<?php build('content')?>
	<?php spaceUp()?>
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Employee List</h4>
		</div>

		<div class="card-body">
			<div class="col-md-3" style="margin-bottom: 20px;">
				<form method="get" class="form-inline">
					<input type="hidden" name="filter">
					<div class="form-group">
						<label>Filter</label>
					</div>

					<div class="form-group">
						<select class="form-control" name="type">
							<option value="">-Select</option>
							<option value="non-regular">Non regular</option>
							<option value="regular">Regular</option>
							<option value="terminated">Terminated</option>
						</select>
					</div>

					<div class="form-group">
						<input type="submit" name="" class="btn btn-dark">
					</div>
				</form>
			</div>
			<div class="divider"></div>

			<div class="table-responsive">
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
						<th>Employment Status</th>
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
								<td><?php echo $emp['empnote']?></td>
								<td><a href="employee_view.php?id=<?php echo $emp['empid']?>">Preview</a></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div> 	
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>