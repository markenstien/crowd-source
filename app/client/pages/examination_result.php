<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>
<style type="text/css">
	#examResult
	{
		width: 600px;
		margin: 0px auto;
		background: #fff;
		padding: 15px 20px;
	}
	.exam-info
	{
		padding: 10px;
		font-size: .90em;
	}
	span.important{
		color: red;
	}
	.ex-details
	{
		margin-bottom: 3px;
	}
	.questionanswer
	{
		margin-top: 5px;
		border-bottom: 1px solid #000;
		line-height: 20px;
		font-weight: bold;
		font-size: .80em;
		width: 100%;
	}
	.examtitle{
		margin-bottom: 15px;
		color: green;
	}
</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<?php

		$result = getExamResult(" WHERE id = '{$_GET['resultid']}'");


		$applicationExam = new ExaminationResult($result['examinationid']);

		$application     = new JobApplication($applicationExam->applicationid);

		$job  = $application->getJobInfo();

		$ja   = $application->getJobApplicationInfo();

		$examiner = getUser($ja['userid']);

		$exam = getExam($applicationExam->examid);

		$examAnswers = $applicationExam->getSummary();

		$remarks     = $applicationExam->getRemarks();
	?>
	<div id="examResult" class="container-fluid">
		<h1 class="examtitle">Examination Result</h1>

		<div class="header">
			<div class="row">
				<section class="left col-md-6">
					<div class="ex-details">Exam Name : <strong><?php echo $exam['name']?></strong></div>
					<div class="ex-details">Examiner : <strong><?php echo $examiner['fullname']?></strong></div>
					<div class="ex-details">Exam Name : <strong><?php echo $exam['name']?></strong></div>
				</section>
				<section class="right col-md-6">
					<div class="ex-details">Date: <strong><?php echo $applicationExam->exam_date?></strong></div>
					<div class="ex-details">Score : <strong><?php echo $remarks['score'].'%'?></strong></div>
					<div class="ex-details">Remarks : <strong><?php echo $remarks['remarks']?></strong></div>
					<div class="ex-details">Duration : <strong><?php echo $applicationExam->getTimeConsumed()?>min</strong></div>
					<div class="ex-details">Corrects | Incorrects : <strong><?php echo count($applicationExam->getCorrects()) . ' | ' . count($applicationExam->getInCorrects())?></strong></div>
				</section>
			</div>

			<div class="divider"></div>
			<div class="exam-info">
				<p>This examination is for company <span class="important"><?php echo $job['comp_name']?></span> , <span class="important"><?php echo $job['position']?></span> job position </p>
			</div>

			<div style="text-align: center;">
				Exam Duration : <?php echo $exam['duration'] ?> | Exam total question : <?php echo $exam['questiontotal'];?>
			</div>
		</div>
		<div>
			<div><strong>Exam Info</strong></div>
			<div>Duration : <?php echo $exam['duration']?>mins</div>
			<div>Total Questions: <?php echo $exam['questiontotal']?></div>
		</div>

		<section class="exam-copy">
			<?php foreach($examAnswers as $answer) :?>
			<div class="questionanswer">
				<div class="question"> Question : <?php echo $answer['question']?> </div>
				<div class="answer"> Correct Answer: <?php echo $answer['correctanswer']?> </div>
				<div class="answer"> Answer :<?php echo $answer['useranswer']?> </div>
				<div class="answer"> Remarks :<?php echo $answer['remarks']?> </div>
			</div>
			<?php endforeach;?>
		</section>
		<div>
			<a href="profile.php">Finish</a>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>
