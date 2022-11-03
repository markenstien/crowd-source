<?php require_once '../dependencies.php';?>
<?php $examList = getExamList(); ?>
<?php build('content')?>
	<?php spaceUp()?>
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Exam List</h4>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table myTable table-bordered dataTable">
					<thead>
						<th>Name</th>
						<th>Description</th>
						<th>Duration</th>
						<th>No of Questions</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($examList as $exam) :?>
							<tr>
								<td><?php echo $exam['name']?></td>
								<td><?php echo $exam['description']?></td>
								<td><?php echo $exam['duration']?></td>
								<td><?php echo $exam['questiontotal']?></td>
								<td>
									<a href="exam_show.php?id=<?php echo $exam['id']?>">Show</a>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>