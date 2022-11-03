<?php require_once '../dependencies.php';?>
<?php $examList = getExamList(); ?>

<?php 
	if(isset($_GET['filter'])){
		$status = $_GET['status'];

		$applicantList = getApplicantList( " WHERE ja.status_label != 'complete' and ja.status = '{$status}' ");
	}else{
		$applicantList = getApplicantList( " WHERE ja.status != 'passed' ORDER BY ja.id desc ");
	}
?>
<?php build('content')?>
	<?php spaceUp()?>
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Applicant List</h4>
		</div>

		<div class="card-body">
			<div>
				<form class="form-inline">
					<input type="hidden" name="filter" value="searchfilter">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option value="pending">pending</option>
							<option value="passed">passed</option>
							<option value="failed">failed</option>
						</select>
					</div>

					<div class="form-group">
						<input type="submit" value="Apply Search">
					</div>
				</form>
				<?php if(isset($_GET['filter'])) :?>
					<a href="application_list.php">Remove Filter</a>
				<?php endif;?>
		    </div>
			<div class="table-responsive">
				<table class="table dataTable">
					<thead>
						<th>Company</th>
						<th>Applicant</th>
						<th>Status</th>
						<th>Label</th>
						<th>Position</th>
						<th>Date</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($applicantList as $applicant) :?>
							<tr>
								<td>
									<a href="company_view.php?id=<?php echo $applicant['compid']?>">
										<?php echo $applicant['comp_name']?>
									</a>	
								</td>
								<td><a href="applicant_view.php?id=<?php echo $applicant['userid']?>"><?php echo $applicant['fullname']?></a>
								</td>
								<td><?php echo $applicant['status']?></td>
								<td><?php echo $applicant['label']?></td>
								<td><?php echo $applicant['position']?></td>
								<td><?php echo $applicant['date']?></td>
								<td>
									<a href="application_view.php?id=<?php echo $applicant['jaid']?>" 
										class="btn btn-primary btn-sm">
										<i class="fa fa-eye"></i>
									</a>
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