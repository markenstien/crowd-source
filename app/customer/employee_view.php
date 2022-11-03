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

	if(postRequest('applyTermination'))
	{
		applyTermination($_POST);
	}

	if(postRequest('empRegularization')){
		empRegularization($_POST['empid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Employee Management') ;?>
		<?php  $employee = getEmployee($_GET['empid']) ;?>

		<?php $applicant = new Applicant($employee['userid']);?>

		<?php $employee_evaluations = getEmployeeEvaluations($_GET['empid']);?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Employee View
			</div>

			<div class="panel-body">
				<!-- 
					1.) Employee Info on company , Account info
					2.) Employee Evaluation
					3.) 
				-->
				<section>
					<?php extract($employee);?>
					<h3>Employee Info</h3>
					<small>Status : <?php echo $status?></small>
					<ul>
						<li>Started On : <?php echo $date_started?></li>
						<li>Employee ID: <?php echo $empcode?></li>
						<li>Name : <?php echo $fullname?></li>
						<li>Job Title : <?php echo $job_title?></li>
						<li>Position : <?php echo $job_position?></li>
						<li>Salary : <?php echo $salary?></li>
						<li>Salary Type : <?php echo $salary_type?></li>
						<li>Company: <?php echo getCompanyInfo($employee['companyid'])['name']?></li>
					</ul>

				</section>

				<section>
					<?php extract($applicant->getPersonal())?>
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
						<?php if($employee['status'] == 'active') :?>
						<li><a href="evaluation_create.php?empid=<?php echo $employee['empid']?>">Evaluate Employee</a></li>
						<?php endif;?>
					</ul>
				</section>
				<?php if($employee['status'] == 'active') :?>
					<?php if($employee['emp_type'] == 'non-regular') :?>
					<section>
						<form method="post">
							<input type="hidden" name="empid" value="<?php echo $employee['empid']?>">
							<input type="submit" id="empRegularization" name="empRegularization" value="Set as regular employee">
						</form>
					</section>
					<?php else:?>
						<p>Regular Employee</p>
					<?php endif;?>
				<?php endif;?>
				<section>
					<?php $employee_evaluations = evaluationGroup($employee['empid']);?>
					<div class="col-md-12">
						<hr>
						<strong>Previous Result</strong>
						<table class="table">
							<thead>
								<th>Season</th>
								<th>Score</th>
								<th>Remarks</th>
								<th>Review</th>
							</thead>

							<tbody>
								<?php $total = 0 ?>
								<?php foreach($employee_evaluations as $eval) :?>
									<?php $total += $eval['remarks'] ?>
									<tr>
										<td><?php echo $eval['season']?></td>
										<td><?php echo $eval['remarks'] . ' out of 25'?></td>
										<td><?php echo evaluationCriteriaScore(round($eval['average'])) ?></td>
										<td><a href="evaluation_view.php?empid=<?php echo $employee['empid']?>&season=<?php echo $eval[
										'season']?>">Review</a></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<?php if($total > 0) :?>
							<div>
								<h3>Evaluation Summary</h3>
								<p>
									<?php $placeHolder = count($employee_evaluations) * 25;?>

									<?php $percentage = getPercentage($total , $placeHolder)?>
								</p>
								<h3><?php echo $percentage.'%';?> <?php  echo passFail($percentage , 75 )?></h3>
							</div>
						<?php endif;?>
						<?php if(empty($employee['notes'])) :?>
						<section>
							<h3 style="width: 100%; padding: 10px; background: red; color:#fff;">Danger Zone</h3>
							<form class="col-md-5" method="post">
								<legend>Employee Termination</legend>
								<input type="hidden" name="empid" value="<?php echo $employee['empid']?>">
								
								<div class="form-group">
									<label>Reason</label>
									<select id="reason" name="reason" class="form-control">
										<option value="">-Select</option>
										<option value="AWOL">AWOL</option>
										<option value="End Of Contract">End of Contract</option>
										<option value="Resignation">Resignation</option>
										<option value="others">Others</option>
								</select>
								</div>

								<div class="form-group" id="reason_other_container">
									<label>Leave a clear note about the termination</label>
									<input type="text" name="reason_other" class="form-control">
								</div>
								<div class="form-group">
									<input type="submit" id="applyTermination" name="applyTermination" class="btn btn-primary" value="Apply termination">
								</div>
							</form>
						</section>
						<?php else:?>
							<p>Employee has been terminated , reason <?php echo $employee['notes']?></p>
						<?php endif;?>
					</div>
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<script type="text/javascript">
	$( document ).ready(function()
	{
		$("#reason_other_container").hide();

		$("#reason").change(function(evt)
		{
			if($(this).val() === 'others') {
			$("#reason_other_container").show();
		}else{
			$("#reason_other_container").hide();
		}
		});
		
		$("#empRegularization").click(function(evt)
		{
			if(!confirm('are you sure you want to set this employee as regular employee?'))
			{
				evt.preventDefault();
			}

		});

		$("#applyTermination").click(function(evt)
		{
			if(!confirm('are you sure you want to terminate this employee ?'))
			{
				evt.preventDefault();
			}
		});
	});
</script>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>