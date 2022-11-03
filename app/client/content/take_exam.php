<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>
<style type="text/css">
	.examBreadCrum{
		display: flex;
		flex-direction: row;
	}
	.examBreadCrum > div
	{
		margin: 2px;
		padding: 5px 10px;
		flex: 1;
		height: 50px;
		background: #fff;
	}
	.examBreadCrum img
	{
		width: 30px;
		height: 30px;
	}
	.examContent
	{
		box-sizing: border-box;
		padding: 10px 15px;
		background: #fff;
	}
	.question
	{
		margin-bottom: 5px;
	}

	.question p
	{
		text-align: center;
		padding: 15px;
	}

	.choices li
	{
		list-style: none;
		border-bottom: 1px solid #000;
		padding: 10px;
	}

	.choices img
	{
		width: 65px;
	}
</style>
</head>
<body>
	<?php 
		if(postRequest('startExam')){
			startExam($_POST['applicationid']);
		}

		if(postRequest('submitAnswer')){
			submitAnswer($_POST['examinationid']  , $_POST['questionid'] , $_POST['answer']);
		}
	?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<?php
		$application = getApplication($_GET['applicationid']);
		$job         = getJob($application['jobid']);
		$exam        = getJobExam($application['jobid']);
		$examination = getExamByParam(" WHERE applicationid = '{$_GET['applicationid']}'");
	?>
	<?php Flash::show();?>
	<?php if(empty($examination)) :?>
		<div style="width: 400px; margin: 0px auto; text-align: center;">
			<h3>Application Examination</h3>
			<ul class="list-unstyled">
				<li>Duration : <?php echo $exam['duration']?></li>
				<li>Question : <?php echo $exam['questiontotal']?></li>
			</ul>

			<form method="post" action="">
				<input type="hidden" name="applicationid" value="<?php echo $application['id']?>">
				<input type="hidden" name="examid" value="<?php echo $exam['id']?>">
				<input type="submit" name="startExam" value="Start Exam" class="btn btn-success btn-block">
			</form>
			<p style="padding: 10px; color: red;">! Once you start the exam you need to finish it.</p>
		</div>
	<?php endif;?>

	<div class="col-md-12">
		<?php if(!empty($examination)) :?>
			<?php $question = getExamQA($_GET['qaid']);?>
			<div class="examBreadCrum  container">
				<div class="summary">
					<div class="jobTitle"><?php echo $job['comp_name'] . ' - ' .$job['title']?></div>
					<div><small class="examName"><?php echo $exam['name']?></small></div>
				</div>

				<div class="exam-info">
					<div class="exam-duration"><?php echo $exam['duration']?></div>
					<div class="exam-progress"><?php echo $question['orderNumber']?> out of <?php echo $exam['questiontotal']?></div>
				</div>

				<div class="logo">
					<img src="<?php echo URL.DS.'public/logo.jpg'?>">
				</div>
			</div>
			<div class="examPanel container">
				<div class="examContent">
					<div class="question">
						<p><?php echo $question['question']?></p>
					</div>
					<div>
						<form method="post">
							<input type="hidden" name="examid" value="<?php echo $exam['id'] ?>">
							<input type="hidden" name="examinationid" value="<?php echo $examination['id']?>">
							<input type="hidden" name="questionid" value="<?php echo $question['id']?>">
							<input type="hidden" name="applicationid" value="<?php echo $application['id']?>">
							<ul class="choices">
								<li>
									<?php
										$answer = base64_encode(serialize(
											[
												$question['choice_1'], 'choice_1'
											]
										));
									?>
									<label>
										<input type="radio" name="answer" 
										value="<?php echo $answer?>" required>
										<?php echo $question['choice_1']?>
										<?php echo convertImage($question['image_1']) ?>
									</label>
								</li>
								<li>
									<?php
										$answer = base64_encode(serialize(
											[
												$question['choice_2'], 'choice_2'
											]
										));
									?>
									<label>
										<input type="radio" name="answer" 
										value="<?php echo $answer?>" required>
										<?php echo $question['choice_2']?>
										<?php echo convertImage($question['image_2']) ?>
									</label>
								</li>
								<li>
									<?php
										$answer = base64_encode(serialize(
											[
												$question['choice_3'], 'choice_3'
											]
										));
									?>

									<label>
										<input type="radio" name="answer" 
										value="<?php echo 'choice_3'?>" required>
										<?php echo $question['choice_3']?>
										<?php echo convertImage($question['image_3']) ?>
									</label>
								</li>
								<li>
									<?php
										$answer = base64_encode(serialize(
											[
												$question['choice_4'], 'choice_4'
											]
										));
									?>
									<label>
										<input type="radio" name="answer" 
										value="<?php echo $answer?>" required>
										<?php echo $question['choice_4']?>
										<?php echo convertImage($question['image_4']) ?>
									</label>
								</li>
							</ul>
							<input type="submit" name="submitAnswer" class="btn btn-sm btn-success">
						</form>
					</div>
				</div>
			</div>         
		<?php endif;?>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>