<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php 
	if(postRequest('startExam')){
		startExam($_POST['applicationid'] , $_POST['examid']);
	}

	if(postRequest('submitAnswer')){
		submitAnswer($_POST['examinationid']  , $_POST['questionid'] , $_POST['answer']);
	}
?>

<?php build('content')?>

<div id="wrapper">
    <div style="margin-top: 50px;"></div>

    <div class="card">
    	<div class="card-header">
    		<?php Flash::show();?>
    	</div>
    	<div class="card-body">
    		<?php if(!isset($_GET['examinationid'])) :?>
				<?php 
					$exam = getExam($_GET['examid']);
					$application = getApplication($_GET['applicationid']);
				?>
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

			<?php if(isset($_GET['examinationid'])) :?>
			<div class="col-md-12">
				<h3 class="text-center">Application Examination</h3>
				<hr>
				<?php $examinationid = $_GET['examinationid']?>
				<?php $examination = getExamination($examinationid);?>
				<?php $exam        = getExam($examination['examid'])?>
				<?php $application = getApplication($examination['applicationid']);?>
				<?php $job = getJob($application['jobid'])?>
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
							<img src="<?php echo URL.DS.'public/new_logo.jpg'?>" 
							style="width: 40px; height: 40px;">
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
										<?php for($i = 1 ; $i <= 4 ; $i++) :?>
										<li>
											<?php
												$answer = base64_encode(serialize(
													[
														$question["choice_${i}"], "choice_${i}"
													]
												));
											?>
											<label>
												<input type="radio" name="answer" 
												value="<?php echo $answer?>" required>
												<?php echo $question["choice_${i}"]?>
												<?php echo convertImage($question["image_${i}"]) ?>
											</label>
										</li>
										<?php endfor?>
									</ul>
									<input type="submit" name="submitAnswer" class="btn btn-sm btn-success">
								</form>
							</div>
						</div>
					</div>     
			</div>		
			<?php endif;?>
    	</div>	
    </div>
</div>
<?php endbuild()?>


<?php build('headers')?>
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
		border: 1px solid #000;
		font-weight: bold;
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
<?php endbuild()?>

<?php loadTo('orbit/app');