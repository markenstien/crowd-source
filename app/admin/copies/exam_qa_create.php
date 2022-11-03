<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}

	.choices img
	{
		width: 70px;
		height: 70px;
	}
</style>
</head>
<body>
	<?php 
		if(postRequest('qandcreate'))
		{
			examQCACreate($_POST);
		}
	?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Exam Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show('examcreate');?>
			<?php Flash::show();?>
			<?php $exam = getExam($_GET['id']);?>
			<div class="panel-heading"> Question and Answer Info </div>
			<div class="panel-body">
				<h3>Exam: <?php echo $exam['name']?></h3>
				<div class="row">
					<div class="col-md-7">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="examid" value="<?php echo $exam['id']?>">
							<div class="form-group">
								<label>Question</label>
								<input type="text" name="question" class="form-control" required autocomplete="off">
								<input type="file" name="question_img" class="form-control">	
							</div>

							<fieldset>
								<legend>Choices</legend>
								<?php for($i = 1 ; $i <= 4 ; $i++) :?>
								<div class="form-group">
									<label><?php echo $i;?></label>
									<input type="text" name="choice_<?php echo $i;?>" class="form-control" autocomplete="off">	
									<input type="file" name="image_<?php echo $i;?>" class="form-control">	
								</div>
								<?php endfor;?>
							</fieldset>

							<div class="form-group">
								<label>Answer</label>
								<select class="form-control" name="answer">
									<option>-Set Correct Answer</option>
									<?php for($i = 1 ; $i <= 4 ; $i++) :?>
										<option value="choice_<?php echo $i;?>">Choice - <?php echo $i;?></option>
									<?php endfor;?>
								</select>
							</div>
							<input type="submit" name="qandcreate" class="btn btn-primary" value="Add Question">
						</form>
					</div>

					<div class="col-md-4">
						<h3>QA list</h3>
						<?php $qaList = getExamQAList($exam['id']);?>
						<ol>
							<?php foreach($qaList as $qa) :?>
								<li class="choices">
									<a href="exam_qa_edit.php?id=<?php echo $qa['id']?>">edit</a>
									<div>
										<ul>
											<li>
												<strong>
													<?php echo $qa['question'] . ' ' .convertImage($qa['question_img'])?>
												</strong>
											</li>
											<ol>
												<!--  -->
												<li><?php echo $qa['choice_1']. ' ' . convertImage($qa['image_1'])?></li>
												<li><?php echo $qa['choice_2']. ' ' . convertImage($qa['image_2'])?></li>
												<li><?php echo $qa['choice_3']. ' ' . convertImage($qa['image_3'])?></li>
												<li><?php echo $qa['choice_4']. ' ' . convertImage($qa['image_4'])?></li>
												<li>
													<strong>
														Answer : <?php echo substr($qa['answer'] , 7)?>
													</strong>
												</li>
											</ol>
										</ul>
									</div>
								</li>
							<?php endforeach;?>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>