<?php require_once '../dependencies.php';?>
<?php 	
	if(postRequest('evaluateEmp'))
		evaluateEmployee($_POST);

	if(postRequest('removeEval'))
		removeEvaluation($_POST['evalid']);

	$employee = getEmployee($_GET['id']);
	$applicant = new Applicant($employee['userid']);
	$employee_evaluations = evaluationGroup($employee['empid']);
?>

<?php build('content') ?>

<?php spaceUp()?>
<div class="card card-theme-dark">
	<div class="card-header">
		<h4 class="card-title">Employee View</h4>
	</div>

	<div class="card-body">
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
				<li>Company: <a href="company_view.php?id=<?php echo $employee['companyid']?>"><?php echo getCompanyInfo($employee['companyid'])['name']?></a> </li>
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
			</ul>
		</section>

		<section>
		<hr>
			<strong>Previous Result</strong>
			<table class="table">
				<thead>
					<th>Season</th>
					<th>Score</th>
					<th>Remarks</th>
				</thead>

				<tbody>
					<?php $total = 0 ?>
					<?php foreach($employee_evaluations as $eval) :?>
						<?php $total += $eval['remarks'] ?>
						<tr>
							<td><?php echo $eval['season']?></td>
							<td><?php echo $eval['remarks'] . ' out of 25'?></td>
							<td><?php echo evaluationCriteriaScore(round($eval['average'])) ?></td>
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
				<h3><?php echo $percentage.'%';?> <?php  echo passFail($percentage ,$placeHolder)?></h3>
			</div>
			<?php endif;?>
		</section>
	</div>
</div>

<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>