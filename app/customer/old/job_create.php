<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
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
							<input type="text" name="title" class="form-control">
						</div>
						<div class="form-group">
							<label>Sub Title</label>
							<input type="text" name="sub_title" class="form-control">
						</div>
						<div class="form-group">
							<label>Category</label>
							<div></div>
							<?php foreach($cat_list as $cat) :?>
								<label class="space-up">
									<input type="checkbox" name="categories[]" value="<?php echo $cat['id']?>">
									<?php echo $cat['category'];?>
								</label>
							<?php endforeach;?>
						</div>
						<div class="form-group">
							<label>Position</label>
							<input type="text" name="position" class="form-control">
						</div>
						<div class="form-group">
							<label>Salary</label>
							<input type="text" name="salary" class="form-control">
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
							<textarea class="form-control" rows="10" name="notes"></textarea>
							<small>Important information that will help applicants</small>
						</div>
						<input type="submit" name="create" class="btn btn-success" value="Create Job">
					</fieldset>
					
					<fieldset class="col-md-6">
						<?php $company = getCompanyInfo(Session::get('company')['id']) ;?>
						<input type="hidden" name="companyid" value="<?php echo $company['id']?>">
						<legend>Company</legend>
						<div class="form-group">
							<label>Company</label>
							<input type="text" name="company" class="form-control" 
							value="<?php echo $company['name']?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" class="form-control" 
							value="<?php echo $company['email']?>">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" 
							value="<?php echo $company['phone']?>">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" 
							value="<?php echo $company['address']?>">
						</div>
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
							</select>
						</div>
					</fieldset>	
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>