<?php 
	require_once '../dependencies.php';

	if(postRequest('create'))
		createJobAdmin($_POST);

	$cat_list = getCategoryList();
	$companyList = getCompanyList();
	$examList = getExamList();
	$jobPositions = getJobPositions(" order by position asc ");
?>

<?php build('content') ?>
	<?php Flash::show()?>
	<form class="row" method="post">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">General</h4>
				</div>

				<div class="card-body">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" class="form-control" 
						value="<?php echo $_POST['title'] ?? ''?>" required>
					</div>
					<div class="form-group">
						<label>Sub Title</label>
						<input type="text" name="sub_title" class="form-control" 
						value="<?php echo $_POST['sub_title'] ?? ''?>" required>
					</div>
					<div class="form-group">
						<label>Category</label>
						<div class="categoryContainer">
							<?php foreach($cat_list as $cat) :?>
							<label class="badge badge-secondary" style="margin-right: 10px; font-size: 1em">
								<input type="checkbox" name="category_list[]" value="<?php echo $cat['category']?>">
								 <?php echo ucWords($cat['category']);?>
							</label>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group">
						<label>Position</label>
						<select id="position" name="position" class="form-control" required>
							<option value="">-Select</option>
							<?php foreach($jobPositions as $pos): ?>
								<option value="<?php echo $pos['position']?>"><?php echo $pos['position']?></option>
							<?php endforeach;?>
							<option value="others">Others</option>
						</select>

						<div id="positionContainer">
							<small>Other Position</small>
							<input type="text" name="position_others" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label>Salary</label>
						<input type="text" name="salary" class="form-control" 
						value="<?php echo $_POST['salary'] ?? ''?>">
						<small>Default Hourly Rate: 71.00</small>
					</div>
					<div class="form-group">
						<label>Salary Type</label>
						<select class="form-control" name="salary_type">
							<?php foreach(salary_type_list() as $salary_type) :?>
								<option value="<?php echo $salary_type?>"><?php echo $salary_type?></option>
							<?php endforeach;?>
						</select>
					</div>

					<div class="form-group">
						<label>Others</label>
						<textarea class="form-control" rows="10" name="notes"><?php echo $_POST['notes'] ?? ''?></textarea>
						<small>Important information that will help applicants</small>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Company</h4>
				</div>

				<div class="card-body">
					<div class="form-group">
						<label>Company</label>
						<select class="form-control" name="companyid">
							<?php foreach($companyList as $company) :?>
								<option value="<?php echo $company['id']?>"><?php echo $company['name']?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Exam</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Exam One</label>
						<select class="form-control" name="examid">
							<?php foreach($examList as $exam) :?>
								<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
							<?php endforeach;?>
						</select>
					</div>

					<div class="form-group">
						<label>Exam Two</label>
						<select class="form-control" name="examid">
							<?php foreach($examList as $exam) :?>
								<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Requirements</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Education</label>
						<select class="form-control" name="education">
							<?php foreach(educationaAttainments() as $attainment) :?>
								<option value="<?php echo $attainment;?>"><?php echo $attainment;?></option>
							<?php endforeach;?>
						</select>
					</div>

					<div class="form-group">
						<label>Preffered Gender</label>
						<select class="form-control" name="gender">
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Male Female">Male / Female</option>
						</select>
					</div>

					<div class="form-group">
						<label>Urgency</label>
						<select class="form-control" name="urgency" required>
							<option value="low">Low</option>
							<option value="mid">Mid</option>
							<option value="high">High</option>
						</select>
					</div>

					<div class="form-group">
						<label>Duration</label>
						<input type="text" name="duration" class="form-control">
						<small class="text-danger">Use user informative duration eg. "2 months contract"</small>
					</div>

					<div class="form-group">
						<label>Employee Needed</label>
						<input type="number" name="employee_needed" class="form-control">
					</div>

					<div class="form-group">
						<input type="submit" name="create" class="btn btn-success" value="Create Job">
					</div>
				</div>
			</div>

		</div>
	</form>
<?php endbuild()?>


<?php build('scripts')?>
<script type="text/javascript">
	
	$("#positionContainer").hide();

	$("#position").change(function(evt)
	{
		if($(this).val() === 'others'){
			$("#positionContainer").show()
		}else{
			$("#positionContainer").hide();
		}
	});

</script>
<?php endbuild()?>
<?php
	build('breadcrum');
		loadBreadCrumb('Job Management');
	endbuild();
	loadTo('orbit/app-admin');
?>