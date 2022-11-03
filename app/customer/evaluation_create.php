<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	
	#testPaper
	{
		width: 1000px;
		margin: 0px auto;
	}
	.test-question
	{
		float: left;
		margin-right: 30px;
		margin-bottom: 10px;
		padding: 10px;
		width: 450px;
		background: #eee;
		display: inline-block;
	}
</style>
</head>
<body>
<?php 	

	if(postRequest('submitExam'))
	{

		createEvaluation($_POST);
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
						<li><a href="employee_view.php?empid=<?php echo $employee['empid']?>">View Employee</a></li>
					</ul>
				</section>

				<section>
					<?php if(!isset($_GET['category'])) :?>
						<form method="get" class="form-inline">
							<input type="hidden" name="empid" value="<?php echo $_GET['empid']?>">
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="category">
									<?php foreach(evaluationSeason() as $season) :?>
										<option value="<?php echo $season?>"><?php echo $season?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="" class="btn btn-danger">
							</div>
						</form>
						<?php else:?>
					<?php endif;?>

					<?php if(isset($_GET['category'])) :?>
					<div id="testPaper">
						<h4 class="text-center">Category : <?php echo $_GET['category']?></h4>
						<form method="post">
							<?php
								$others = [
									'season' => $_GET['category'] ,
									'companyid' => $employee['companyid'],
									'empid'    => $employee['empid']
								];
							?>
						<input type="hidden" name="others" value="<?php echo sealInput($others);?>">
						<?php $counter = 0;?>
						<?php foreach(evaluationCriteriaList() as $key=> $criteria) :?>
							<?php if($counter % 2 == 0) :?>
								<?php else:?>
									<div class="test-question">
										<p><?php echo $criteria;?></p>
										<?php foreach(evaluationCriteriaScore() as $score => $scoreName) :?>
											<div>
												<?php 
													$criteriaAndScore = [
														$criteria , $score
													];
												?>
												<label>
													<input type="radio" name="<?php echo "$key"?>" value="<?php echo sealInput($criteriaAndScore)?>" required>
													<?php echo $scoreName?>
												</label>
											</div>
										<?php endforeach;?>
										Comment : <input type="text" name="<?php echo "{$key}Comment"?>" class="form-control">
									</div>
							<?php endif;?>
							<?php $counter++;?>
						<?php endforeach;?>
							<div style="clear: both;"></div>
							<input type="submit" name="submitExam" class="btn btn-success" value="Submit Evaluation">
						</form>
					</div>
				<?php endif;?> 
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>