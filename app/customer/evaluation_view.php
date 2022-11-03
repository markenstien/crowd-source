<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php 	

	if(postRequest('evaluateEmp'))
	{
		evaluateEmployee($_POST);
	}

	if(postRequest('removeEval'))
	{
		removeEvaluation($_POST['evalid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Employee Management') ;?>
		<?php $employee = getEmployee($_GET['empid']) ;?>

		<?php $user = getUser($employee['userid'])?>
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
					</ul>
				</section>

				<section>
					<?php extract($user)?>
					<h3>Employee Personal Info</h3>
					<ul>
						<li>Firstname : <?php echo $firstname?></li>
						<li>Lastname : <?php echo $lastname?></li>
						<li>Gender : <?php echo $gender?></li>
						<li>Birthday : <?php echo $birthday?></li>
						<ul>
							<li><strong>Contact</strong></li>
							<li>Phone : <?php echo $phone?></li>
							<li>Email : <?php echo $email?></li>
							<li>Address : <?php echo $address?></li>
						</ul>
						<li><a href="employee_view.php?id=<?php echo $employee['empid']?>">Evaluate Employee</a></li>
					</ul>
				</section>

				<section>
					<?php $season = $_GET['season'];?>
					<?php $employee_evaluations = getEmployeeEvaluations($employee['empid'],  
					" WHERE empid = '{$employee['empid']}' and season = '{$season}'");?>
					<div class="col-md-12">
						<hr>
						<strong>Previous Result</strong>
						<table class="table">
							<thead>
								<th>Season</th>
								<th>Criteria</th>
								<th>Score</th>
								<th>Remarks</th>
								<th>Notes</th>
							</thead>

							<tbody>
								<?php $total = 0 ?>
								<?php foreach($employee_evaluations as $eval) :?>
									<?php $total += $eval['remarks'] ?>
									<tr>
										<td><?php echo $eval['season']?></td>
										<td><?php echo $eval['criteria']?></td>
										<td><?php echo $eval['remarks']?></td>
										<td><?php echo evaluationCriteriaScore($eval['remarks']) ?></td>
										<td><?php echo $eval['notes'] . ' out of 5'?></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<?php if($total > 0) :?>
							<div>
								<h3>Evaluation Summary</h3>
								<p>
									<?php $placeHolder = count($employee_evaluations) * 5;?>
									
									<?php $percentage = getPercentage($total , $placeHolder)?>
								</p>
								<h3><?php echo $percentage.'%';?> <?php  echo passFail($percentage , 75)?></h3>
						</div>
						<?php endif;?>
					</div>
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>