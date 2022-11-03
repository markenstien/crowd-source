<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.clean-box{
		background: #fff;
		padding: 10px;
		width: 300px;
		margin-bottom: 10px;
	}
	.banner img
	{
		width: 100%;
	}

	.logo
	{
		width: 170px;
	}
	.logo img
	{
		width: 100%;
	}
</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php $user = new Profile();?>
		<?php $employee = getEmployee($_GET['workid']) ;?>
		<?php $company  = getCompanyInfo($employee['companyid'])?>
		<?php $applicant = new Applicant($employee['userid']);?>
		<?php $employee_evaluations = evaluationGroup($employee['empid']);?>

		<h3>Work Review</h3>
		<div id="wrapper">
			<section class="content-container col-md-4">
				<h3>Work Information</h3>
				<p>
					Employment status : <strong><?php echo $employee['employment_status'] ?></strong>
				</p>
				<div>
					<ul>
						<li>Start : <?php echo $employee['date_started']?> </li>
						<li>Employee Code :<?php echo $employee['empcode']?></li>
						<li>Job : <?php echo $employee['job_title']?></li>
						<li>Position : <?php echo $employee['job_position']?></li>
						<li>Salary Type: <?php echo $employee['salary_type']?></li>
						<li>Salary : <?php echo $employee['salary']?></li>
					</ul>
				</div>
			</section>

			<section class="content-container col-md-6 col-md-offset-2">
				<h3>Company</h3>
				<div class="banner">
					<img src="<?php echo URL.DS?>public/assets/<?php echo $company['banner']?>">
				</div>
				<hr>
				<div class="logo">
					<img src="<?php echo URL.DS?>public/assets/<?php echo $company['logo']?>">
				</div>
				<ul>
					<li>Company : <?php echo $company['name']?></li>
					<li>Type : <?php echo $company['type']?></li>
					<li>address : <?php echo $company['address']?></li>
					<li>Email : <?php echo $company['email']?></li>
					<li><a href="catalog.php?keyword=<?php echo $company['name']?>" target="_blank">Job Vacancies</a></li>
				</ul>
			</section>
			<div class="divider"></div>
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
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>