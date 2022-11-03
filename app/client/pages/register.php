<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.content{
		padding: 10px;
		background: #fff;
		margin: 20px;
	}
</style>
</head>
<body>
<?php

	if(postRequest('register'))
	{
		register($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php
			$jobCategoryList = getCategoryList();
		?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				<h3>Registration</h3>
			</div>
			<div class="panel-body">
				<section class="col-md-12">
					<form method="post" action="">
						<div class="row">
							<div class="col-md-5">
								<fieldset>
									<legend>Personal</legend>
									<div class="form-group">
										<label>Firstname</label>
										<input type="text" name="firstname" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Lastname</label>
										<input type="text" name="lastname" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Birthday</label>
										<input type="date" name="birthday" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Gender</label>
										<select class="form-control" name="gender">
											<option>Male</option>
											<option>Female</option>
										</select>
									</div>
								</fieldset>

								<fieldset>
									<legend>Skills</legend>
									<small>Hold *crtl* to select multiple</small>
									<select class="form-control" name="skills[]" multiple>
										<?php foreach($jobCategoryList as $cat) :?>
											<option value="<?php echo $cat['id']?>">
												<?php echo $cat['category']?>
											</option>
										<?php endforeach;?>
									</select>
									<small>Select atleast 3</small>
								</fieldset>

								<fieldset>
									<legend>Education</legend>
									<div class="form-group">
										<label>Educational Attainment</label>
										<select class="form-control" name="highest_attainment">
											<option value="High School Diploma">High School Diploma</option>
											<option value="Vocational">Vocational</option>
											<option value="College Degree">College Degree</option>
											<option value="Masters Degree">Masters Degree</option>
										</select>
									</div>
									<div class="form-group">
										<label>Year</label>
										<select class="form-control" name="school_year">
											<?php foreach(generateYear() as $year):?>
												<option value="<?php echo $year;?>"><?php echo $year;?></option>
											<?php endforeach;?>
										</select>
									</div>
									<div class="form-group">
										<label>School / University</label>
										<input type="text" name="school" class="form-control">
									</div>
								</fieldset>
							</div>

							<div class="col-md-5">
								<fieldset>
									<legend>Contact</legend>
									<div class="form-group">
										<label>Phone</label>
										<input type="number" name="phone" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Address</label>
										<input type="text" name="address" class="form-control" required>
									</div>
								</fieldset>

								<fieldset>
									<legend>Latest Work Experience</legend>

									<div class="form-group">
										<label>
											<input type="radio" class="jobexpi" id="jobexpi" name="jobexpi" value="available"
											checked>
											With Work Experience
										</label>
										<label>
											<input type="radio" class="jobexpi" id="jobexpi" name="jobexpi" value="n/a">
											No Work Experience
										</label>
									</div>
									<p class="text-danger">
										<small>If you no job experience select no work expirience</small>
									</p>
									<section id="workInfo">
										<div class="form-group">
											<label>Field</label>
											<select class="form-control" name="work_field" id="work_field">
												<?php foreach(getJobFields() as $jobs) :?>
													<option value="<?php echo $jobs['field']?>"><?php echo $jobs['field']?></option>
												<?php endforeach;?>
												<option value="others">Others</option>
											</select>

											<div id="work_field_container">
												<label>Other Field</label>
												<input type="text" name="work_field_other" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label>Position</label>
											<input type="text" name="position" class="form-control">
										</div>
										<div class="form-group">
											<label>Role Description</label>
											<textarea class="form-control" rows="10" name="role_description"></textarea>
										</div>
										<div class="form-group">
											<label>When</label>
											<div class="row">
												<div class="col-md-5">
													<label>Date</label>
													<select class="form-control" name="work_date">
														<?php foreach(getDates('short') as $date):?>
															<option value="<?php echo $date;?>"><?php echo $date;?></option>
														<?php endforeach;?>
													</select>
												</div>
												<div class="col-md-5">
													<label>Year</label>
													<select class="form-control" name="work_year">
														<?php foreach(generateYear() as $year):?>
															<option value="<?php echo $year;?>"><?php echo $year;?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
										</div>
									</section>
								</fieldset>
								<div class="form-group">
									<input type="submit" name="register" class="btn btn-primary" value="Create Account">
								</div>
							</div>
						</div>
					</form>
				</section>
			</div>
		</div>


		<div class="row">

		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>

<script type="text/javascript">

	$( document ).ready(function()
	{
		$("#work_field_container").hide();

		$(".jobexpi").change(function(){

			if($(this).val() == 'n/a'){
				$("#workInfo").hide();
			}else{
				$("#workInfo").show();
			}
		});

		$("#work_field").change(function()
		{
			if($(this).val() === 'others'){
				$("#work_field_container").show();
			}else{
				$("#work_field_container").hide();
			}
		});
	});
</script>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>
