<?php require_once '../dependencies.php';?>
<?php $examList = getExaminationlist();?>

<?php build('content')?>
<?php spaceUp()?>
<div class="card card-theme-dark">
	<div class="card-header">
		<h4 class="card-title">Exam List</h4>
	</div>

	<div class="card-body">
		<?php Flash::show();?>

		<div class="table-responsive">
			<table class="table table-bordered dataTable">
				<thead>
					<th>Name</th>
					<th>Examname</th>
					<th>Score</th>
					<th>Remarks</th>
					<th>View Result</th>
				</thead>
				<tbody>
					<?php foreach($examList as $exam) :?>
						<tr>
							<td><?php echo $exam['examineename']?></td>
							<td><?php echo $exam['examname']?></td>
							<td><?php echo $exam['correct'] . ' out of ' .($exam['correct'] + $exam['incorrect']) ?></td>
							<td><?php echo $exam['remarks']?></td>
							<td><a href="examination_result.php?resultid=<?php echo $exam['resultid']?>">Edit</a></td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>