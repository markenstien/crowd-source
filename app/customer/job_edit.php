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
	if(postRequest('update')){
		updateJob($_POST);
	}

	if(postRequest('updateCategory'))
	{
		updateJobCategory($_POST['jobid'] , $_POST['categoryList']);
	}
	if(postRequest('attachExam')){
		examJobAttach($_POST['jobid'] , $_POST['examid'] , $_POST['number']);
	}

	if(postRequest('removeExam')){
		removeJobExam($_POST['jobexamid']);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $job = getJob($_GET['id']) ;?>

		<?php
			$categoryList = getUnSelectedCategory($job['id']);
			$examList = getExamList();
		?>

		<?php  $job_cat_list = getJobPostCategory($_GET['id']);?>
		<?php $jobPositions = getJobPositions(" order by position asc ");?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job information
			</div>
			<div class="panel-body">
				<form method="post" action="" class="col-md-12">
					<input type="hidden" name="jobid" class="form-control" 
							 value="<?php echo $job['id']?>">
					<fieldset class="col-md-6">
						<legend>General</legend>
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" 
							 value="<?php echo $job['title']?>">
						</div>
						<div class="form-group">
							<label>Sub Title</label>
							<input type="text" name="sub_title" class="form-control" 
							value="<?php echo $job['sub_title']?>">
						</div>

						<div class="form-group">
							<label>Position</label>
							<select id="position" name="position" class="form-control" required>
								<option value="">-Select</option>
								<?php foreach($jobPositions as $pos): ?>
									<?php $selected = strtolower($job['position']) == strtolower($pos['position']) ? 'selected' : ''?>
									<option value="<?php echo $pos['position']?>" <?php echo $selected;?>><?php echo $pos['position']?></option>
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
							value="<?php echo $job['salary'] ?? ''?>">
							<small>Default Hourly Rate: 71.00</small>
						</div>

						<div class="form-group">
							<label>Others</label>
							<textarea class="form-control" rows="10" name="notes"><?php echo $job['notes']?></textarea>
							<small>Important information that will help applicants</small>
						</div>
					</fieldset>
					
					<fieldset class="col-md-6">
						<legend>Company</legend>
						<div class="form-group">
							<label>Company</label>
							<input type="text" name="company" class="form-control" value="<?php echo $job['comp_name']?>" readonly>

						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" class="form-control" value="<?php echo $job['email']?>">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" value="<?php echo $job['phone']?>">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" value="<?php echo $job['address']?>">
						</div>

						<legend>Requirements</legend>
						<div class="form-group">
							<label>Education</label>
							<select class="form-control" name="education">
								<?php foreach(educationaAttainments() as $attainment) :?>
									<?php $selected = $attainment == $job['education'] ? 'selected' : ''?>
									<option value="<?php echo $attainment;?>" <?php echo $selected;?>><?php echo $attainment;?></option>
								<?php endforeach;?>
							</select>
						</div>

						<div class="form-group">
							<label>Preffered Gender</label>
							<select class="form-control" name="gender">
								<option value="Male" <?php echo 'Male' == $job['gender'] ? 'selected' : ''?> >Male</option>
								<option value="Female" <?php echo 'Female' == $job['gender'] ? 'selected' : '' ?>>Female</option>
								<option value="Male Female" <?php echo 'Male Female' == $job['gender'] ? 'selected' : '' ?>>Male  Female</option>
							</select>
						</div>

						<div class="form-group">
							<label>Urgency</label>
							<select class="form-control" name="urgency" required>
								<option value="low"  <?php echo 'low' == $job['urgency'] ? 'selected' : ''?> >Low</option>
								<option value="mid"  <?php echo 'mid' == $job['urgency'] ? 'selected' : ''?>>Mid</option>
								<option value="high" <?php echo 'high' == $job['urgency'] ? 'selected' : ''?>>High</option>
							</select>
						</div>


						<div class="form-group">
							<label>Duration</label>
							<input type="date" name="duration" class="form-control" value="<?php echo $job['duration']?>">
							<small class="text-danger">Use user informative duration eg. "2 months contract"</small>
						</div>

						<div class="form-group">
							<label>Employee Needed</label>
							<input type="number" name="employee_needed" class="form-control" 
							value="<?php echo $job['employee_needed']?>">
						</div>
						<input type="submit" name="update" class="btn btn-success" value="Update Job">
					</fieldset>	
				</form>
				<form class="col-md-5" method="post">
					<input type="hidden" name="jobid" value="<?php echo $_GET['id']?>">
					<hr>
					<fieldset>
						<legend>Category</legend>
						<?php if(!empty($job['categories'])) :?>
						<?php 
							$categories = explode(',', $job['categories']);

							echo '<div> <strong> Current Categories </strong> </div>';
							foreach($categories as $cat) {
								echo '#'.$cat;
							}
						?>
						<?php else:?>
							<p>No Cate gories</p>
						<?php endif;?>
					</fieldset>
					<div class="form-group">
						<label>Category</label>
						<div class="categoryContainer">
							<?php foreach($categoryList as $cat) :?>
							<label class="category">
								<input type="checkbox" name="categoryList[]" value="<?php echo $cat['category']?>">
								 <?php echo ucWords($cat['category']);?>
							</label>
							<?php endforeach;?>
						</div>
					</div>
					<input type="submit" name="updateCategory" class="btn btn-success" value="Update">
				</form>
				<div class="divider"></div>
			</div>

			<?php $examone = getJobExam($_GET['id'] , 1);?>
			<?php if(empty($examone)) :?>
			<div class="panel-heading">
				Job Exam Attach 1
			</div>
			<div class="panel-body">					
				<form method="post">
					<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
					<input type="hidden" name="number" value="1">
					<fieldset>
						<legend>Select Exam</legend>

						<div class="form-group">
							<label>Exam List</label>
							<select class="form-control" name="examid">
								<?php foreach($examList as $exam) :?>
									<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
								<?php endforeach;?>
							</select>
						</div>

						<input type="submit" name="attachExam" class="btn btn-success" value="Select Exam">
					</fieldset>
				</form>
				<section class="container">
				</section>
			</div>

			<?php else:?>
			<div class="container-fluid">
				<form method="post">
					<input type="hidden" name="jobexamid" value="<?php echo $examone['id']?>">
					<div class="form-group">
						<legend>Remove Exam 1</legend>
						<div>Current Exam : <?php echo $examone['name']?></div>
						<input type="submit" name="removeExam" class="btn btn-danger" value="Remove Exam">
					</div>
				</form>
			</div>
			<?php endif;?>

			<!--- ----->

			<?php $examtwo = getJobExam($_GET['id'] , 2);?>
			<?php if(empty($examtwo)) :?>
			<div class="panel-heading">
				Job Exam Attach 2
			</div>
			<div class="panel-body">					
				<form method="post">
					<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
					<input type="hidden" name="number" value="2">
					<fieldset>
						<legend>Select Exam</legend>

						<div class="form-group">
							<label>Exam List</label>
							<select class="form-control" name="examid">
								<?php foreach($examList as $exam) :?>
									<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
								<?php endforeach;?>
							</select>
						</div>

						<input type="submit" name="attachExam" class="btn btn-success" value="Select Exam">
					</fieldset>
				</form>
				<section class="container">
				</section>
			</div>

			<?php else:?>
			<div class="container-fluid">
				<form method="post">
					<input type="hidden" name="jobexamid" value="<?php echo $examtwo['id']?>">
					<div class="form-group">
						<legend>Remove Exam 2</legend>
						<div>Current Exam : <?php echo $examtwo['name']?></div>
						<input type="submit" name="removeExam" class="btn btn-danger" value="Remove Exam">
					</div>
				</form>
			</div>
			<?php endif;?>


			<!-- ---->
			<?php $examthree = getJobExam($_GET['id'] , 3);?>
			<?php if(empty($examthree)) :?>
			<div class="panel-heading">
				Job Exam Attach 3
			</div>
			<div class="panel-body">					
				<form method="post">
					<input type="hidden" name="number" value="3">
					<input type="hidden" name="jobid" value="<?php echo $job['id']?>">
					<fieldset>
						<legend>Select Exam</legend>

						<div class="form-group">
							<label>Exam List</label>
							<select class="form-control" name="examid">
								<?php foreach($examList as $exam) :?>
									<option value="<?php echo $exam['id']?>"><?php echo $exam['name']?></option>
								<?php endforeach;?>
							</select>
						</div>

						<input type="submit" name="attachExam" class="btn btn-success" value="Select Exam">
					</fieldset>
				</form>
				<section class="container">
				</section>
			</div>

			<?php else:?>
			<div class="container-fluid">
				<form method="post">
					<input type="hidden" name="jobexamid" value="<?php echo $examthree['id']?>">
					<div class="form-group">
						<legend>Remove Exam 3</legend>
						<div>Current Exam : <?php echo $examthree['name']?></div>
						<input type="submit" name="removeExam" class="btn btn-danger" value="Remove Exam">
					</div>
				</form>
			</div>
			<?php endif;?>
			<!--- --->
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