<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}
	.categoryContainer
	{
		height: 100px;
		overflow-y: scroll;
	}
	.categoryContainer .category
	{
		display: block;
	}
</style>
</head>
<body>
<?php
	if(postRequest('create'))
	{
		createJob($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php $cat_list = getCategoryList();?>
		<?php $company = getCompanyInfo(Session::get('company')['id']);?>
		<?php $examList = getExamList();?>
		<?php $jobPositions = getJobPositions(" order by position asc ");?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job information
			</div>
			<div class="panel-body">
				<form method="post" action="">
					<fieldset class="col-md-6">
						<legend>General</legend>
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
								<label class="category">
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
					</fieldset>
					
					<fieldset class="col-md-6">
						<legend>Company</legend>
						<div class="form-group">
							<label>Company</label>
							<input type="hidden" name="companyid" value="<?php echo $company['id']?>">
							<input type="text" name="companyname" value="<?php echo $company['name']?>" class="form-control" readonly>
						</div>
						<legend>Exam</legend>
						<select class="form-control" name="examid">
							<?php foreach($examList as $exam) :?>
								<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
							<?php endforeach;?>
						</select>

						<legend>Requirements</legend>
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
							<input type="date" name="duration" class="form-control">
							<small class="text-danger">Use user informative duration eg. "2 months contract"</small>
						</div>

						<div class="form-group">
							<label>Employee Needed</label>
							<input type="number" name="employee_needed" class="form-control">
						</div>
						<input type="submit" name="create" class="btn btn-success" value="Create Job">
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>

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
<?php require_once APPROOT.DS.'templates/user/footer.php';?>