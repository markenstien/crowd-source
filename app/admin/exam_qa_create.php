<?php require_once '../dependencies.php';?>

<?php 
	$exam = getExam($_GET['id']);
	if(postRequest('qandcreate'))
		examQCACreate($_POST);
?>

<?php build('content')?>

<?php spaceUp()?>
	
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Add Exam Question</h4>
		</div>
		<?php Flash::show('examcreate');?>
		<?php Flash::show();?>
		<div class="card-body">

			<?php
				FormOpenMeta([
					'method' => 'post',
					'action' => ''
				]);

				FormHidden('examid' , $exam['id']);
			?>
			<div class="well">
				<?php 
					FormLabel('Question');

					FormText('question' , '' , [
						'class' => 'form-control'
					]);
				?>

				<a href="#" class="link-toggle" id="clickToggle" data-target="question_image">Attach Image</a>

				<?php FormFile('question_img' , ['class' => 'question_image']); ?>
			</div>

			<div class="well">
				<h4>Choices</h4>

				<div class="row form-group">
					<div class="col-md-6">
						<?php
							FormLabel('A.');
							FormText('choice_1' , '' , [
								'class' => 'form-control'
							])
						?>
						<a href="#" class="link-toggle" id="clickToggle" data-target=".question_image">Attach Image</a>
						<?php FormFile('image_1' , ['class' => 'question_image']); ?>
					</div>
					<div class="col-md-6">
						<?php
							FormLabel('B.');
							FormText('choice_2' , '' , [
								'class' => 'form-control'
							])
						?>
						<a href="#" class="link-toggle" id="clickToggle" data-target=".question_image">Attach Image</a>
						<?php FormFile('image_2' , ['class' => 'question_image']); ?>
					</div>
				</div>

				<div class="row form-group">
					<div class="col-md-6">
						<?php
							FormLabel('C.');
							FormText('choice_3' , '' , [
								'class' => 'form-control'
							])
						?>
						<a href="#" class="link-toggle" id="clickToggle" data-target=".question_image">Attach Image</a>
						<?php FormFile('image_3' , ['class' => 'question_image']); ?>
					</div>
					<div class="col-md-6">
						<?php
							FormLabel('D.');
							FormText('choice_4' , '' , [
								'class' => 'form-control'
							])
						?>
						<a href="#" class="link-toggle" id="clickToggle" data-target=".question_image">Attach Image</a>
						<?php FormFile('image_4' , ['class' => 'question_image']); ?>
					</div>
				</div>

				<div class="form-group">
					<?php
						FormLabel('Correct Answer');
						FormSelect('answer' , [
							'choice_1' => 'A.',
							'choice_2' => 'B.',
							'choice_3' => 'C.',
							'choice_4' => 'D.'
						], '' , [
							'class' => 'form-control'
						]);
					?>
				</div>

				<div class="form-group">
					<?php
						FormSubmit('qandcreate' , 'Save Question' , [
							'class' => 'btn btn-primary btn-sm'
						])
					?>
				</div>

				<?php FormClose()?>
		</div>
	</div>
<?php endbuild()?>

<?php build('headers')?>

<style type="text/css">
	.space-up{
		margin: 5px;
	}

	.choices img
	{
		width: 70px;
		height: 70px;
	}
	.well{
		margin-bottom: 30px;
		border: 1px solid #000;
		padding: 20px;
	}
</style>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>