<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.questionanswer
	{
		padding: 10px 5px;
		margin-bottom: 5px;
		border: 1px solid #000;
	}
</style>
</head>
<body>

<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<?php
		$applicationExam = new ExaminationResult($_GET['applicationExamId']);

		$application     = new JobApplication($applicationExam->applicationid);

		$job  = $application->getJobInfo();

		$applicationInfo = $application->getJobApplicationInfo();

		$exam = getExam($applicationExam->examid);

		$examAnswers = $applicationExam->getSummary();

		$remarks     = $applicationExam->getRemarks();

	?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Applicatiop View
			</div>

			<div class="panel-body">
				<div id="examResult">
					<h1>Examination Result</h1>
					<div>
						<p><strong>-Examination for : <?php echo $job['title']?> <?php echo $job['sub_title']?></strong></p>
						<p><strong>-Position : <?php echo $job['position']?></strong></p>
					</div>
					<div>
						<div><strong>Exam Info</strong></div>
						<div>Max Duration: <?php echo $applicationExam->getTimeConsumed() ?>mins</div>
						<div>Time Finish: <?php echo $exam['duration']?>mins</div>
						<div>Total Questions: <?php echo $exam['questiontotal']?></div>
					</div>

					<div>
						<div><strong>Exam Result</strong></div>
						<div>Corrects  : <?php echo count($applicationExam->getCorrects())?></div>
						<div>Incorrects: <?php echo count($applicationExam->getInCorrects())?></div>
						<div>Remarks: <?php echo strtoUpper($remarks['remarks'])?> (<?php echo $remarks['score'].'%'?>)</div>

						<hr>
						<div>Exam Copy</div>
						<?php foreach($examAnswers as $answer) :?>
							<div class="questionanswer">
								<div class="question"> Question : <?php echo $answer['question']?> </div>
								<div class="answer"> Correct Answer: <?php echo $answer['correctanswer']?> </div>
								<div class="answer"> Answer :<?php echo $answer['useranswer']?> </div>
								<div class="answer"> Remarks :<strong><?php echo $answer['remarks']?> </strong></div>
							</div>
						<?php endforeach;?>

						<a href="application_view.php?id=<?php echo $applicationInfo['id']?>">Finish</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>