<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php 	

	if(postRequest('evaluateEmp'))
	{
		evaluateEmployee($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Employee Management') ;?>
		<?php  $employee = getEmployee($_GET['empid']) ;?>

		<?php $applicant = new Applicant($employee['userid']);?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Employee View
			</div>

			<div class="panel-body">
				<section>
					<?php extract($employee);?>
					<h3>Employee Info</h3>
					<ul>
						<li>Started On : <?php echo $date_started?></li>
						<li>Employee ID: <?php echo $empcode?></li>
						<li>Name : <?php echo $fullname?></li>
						<li>Job Title : <?php echo $job_title?></li>
						<li>Position : <?php echo $job_position?></li>
						<li>Salary : <?php echo $salary?></li>
						<li>Salary Type : <?php echo $salary_type?></li>
						<li><a href="employee_view.php?id=<?php echo $employee['empid']?>">View Employee</a></li>
					</ul>
				</section>

				<section>
					<h3>Evaluate Employee</h3>
					<?php if(! isset($_GET['start_date'] , $_GET['end_date'] , $_GET['empid'])) :?>
					<div class="col-md-6">
						<form method="get">
							<input type="hidden" name="empid" value="<?php echo $employee['empid']?>">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Start</label>
									<input type="date" name="start_date" class="form-control" 
									value="<?php echo $_GET['start_date'] ?? ''?>">
								</div>

								<div class="form-group col-md-6">
									<label>Start</label>
									<input type="date" name="end_date" class="form-control" 
									value="<?php echo $_GET['end_date'] ?? ''?>">
								</div>
							</div>
							<input type="submit" name="" class="btn btn-primary" value="Set Evaluation Date">
						</form>
					</div>
					<?php endif;?>

					<?php if(isset($_GET['start_date'] , $_GET['end_date'] , $_GET['empid'])) :?>
						<div class="divider"></div>
						<div>
							<h3>Evalutaion for <?php echo $_GET['start_date']?> to  <?php echo $_GET['end_date']?></h3>
						</div>
						<section class="col-md-6">
							<form class="form" method="post">
								<input type="hidden" name="start_date"
								value="<?php echo $_GET['start_date']?>">

								<input type="hidden" name="end_date"
								value="<?php echo $_GET['end_date']?>">

								<input type="hidden" name="companyid"
								value="<?php echo $employee['companyid']?>">

								<input type="hidden" name="empid"
								value="<?php echo $employee['empid']?>">

								<div class="form-group">
									<label>Criteria</label>
									<select class="form-control"  name="criteria">
										<?php foreach(evaluationCriteriaList() as $eval) :?>
											<option value="<?php echo $eval?>"><?php echo $eval?></option>
										<?php endforeach;?>
									</select>
								</div>

								<div class="form-group">
									<label>Remark</label>
									<input type="range" name="remarks" class="form-control" min="1" max="10">
								</div>

								<div class="form-group">
									<label>Notes</label>
									<textarea name="notes" class="form-control" rows="10"></textarea>
								</div>

								<input type="submit" name="evaluateEmp" class="btn btn-primary" value="Post Evaluation">
							</form>
						</section>
					<?php endif;?>
				</section>
				<?php if(isset($_GET['start_date'] , $_GET['end_date'] , $_GET['empid'])) :?>
				<section class="col-md-12">
					<?php
						list($start_date , $end_date , $empid) = [$_GET['start_date'] , $_GET['end_date'] , $employee['empid'] ];
					?>
					<?php $employee_evaluations = getEmployeeEvaluations($_GET['empid'] , " WHERE date_start = '$start_date' and date_end = '$end_date' and empid = '$empid'");?>
					<h3>Evaluation for <?php echo $_GET['start_date']?> to  <?php echo $_GET['end_date']?> </h3>
					<table class="table">
						<thead>
							<th>Date Start</th>
							<th>Date End</th>
							<th>Criteria</th>
							<th>Remarks</th>
							<th>Notes</th>
						</thead>
						<tbody>
							<?php foreach($employee_evaluations as $eval) :?>
								<tr>
									<td><?php echo $eval['date_start']?></td>
									<td><?php echo $eval['date_end']?></td>
									<td><?php echo $eval['criteria']?></td>
									<td><?php echo $eval['remarks']?></td>
									<td><?php echo $eval['notes']?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</section>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>