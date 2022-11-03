<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.clean-box{
		background: #fff;
		padding: 10px;
		width: 300px;
		margin-bottom: 10px;
	}
	#image
	{
		width: 150px;
		height: 150px;
		background: red;
	}
	#image img {
		width: 100%;
	}
</style>
</head>
<body>
<?php
	if(postRequest('addEducation')){
		addEducation($_POST);
	}

  if(postRequest('updateEducation'))
  {
    updateOtherEducation($_POST);
  }
?>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php $user = new Profile();?>

		<?php
			$personal = $user->getPersonal();
			$education = $user->getEducation();
			$workExperiences = $user->getWorkExperience();
			$skills   = $user->getSkills();

			$jobApplications = getUserApplications($user->getId());

			$workHistory     = new WorkHistory($user->getId());

      $education_categories = getEducationCategories();

      $applicant_other_educations = getApplicantEducations(Session::get('user')['id']);
		?>
		<h3>Profile</h3>
		<small class="text-danger">This Page is under Construction</small>
		<?php Flash::show();?>
		<div id="wrapper">
			<section class="content-container col-md-3">
				<h3>Personal</h3>
				<?php if($personal['profile'] != 'na'):?>
					<div id="image">
						<img src="<?php echo URL.DS.'public/assets/'.$personal['profile']?>">
					</div>
				<?php else:?>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="profile">
						</div>
						<input type="submit" name="uploadProfile" value="upload" class="btn btn-primary btn-sm">
						<div>
							<small>Upload your profile picture</small>
						</div>
					</form>
				<?php endif;?>
				<hr>

				<div id="changeProfile" style="display: none">
					<h3>Change Profile</h3>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="profile">
						</div>
						<input type="submit" name="uploadProfile" value="upload" class="btn btn-primary btn-sm">
					</form>
					<a href="#" class="el-toggle" data-target="#changeProfile" >Hide</a>
					<hr>
				</div>
				<ul class="list-unstyled">
					<?php if($personal['profile'] != 'na'):?>
						<li><a href="#" class="el-toggle" data-target="#changeProfile">Change Profile picture</a></li>
					<?php endif;?>
					<li>Firstname : <strong><?php echo $personal['firstname']?></strong> </li>
					<li>Lastname : <strong><?php echo $personal['lastname']?></strong></li>
					<li>Gender : <strong><?php echo $personal['gender']?></strong></li>
					<li>Birthday : <strong><?php echo $personal['birthday']?></strong></li>
				</ul>
			</section>

			<section class="content-container col-md-3 col-md-offset-2">
				<h3>Contact</h3>
				<ul>
					<li>Email : <strong><?php echo $personal['email']?></strong></li>
					<li>Phone : <strong><?php echo $personal['phone']?></strong> </li>
					<li>Address :<strong><?php echo $personal['address']?></strong> </li>
				</ul>
			</section>

			<section class="content-container">
				<h3>Education</h3>
				<ul>
					<li>Highest Attainment : <strong><?php echo $education['highest_attainment']?></strong></li>
					<li>School :<strong><?php echo $education['school']?></strong> </li>
					<li>Year : <strong><?php echo $education['year']?></strong></li>
				</ul>
			</section>
			<div class="divider"></div>

			<section class="panel">
				<div class="panel-heading">
					<h3>Educations</h3>
				</div>
				<div class="panel-body">
          <div class="row">
  					<div class="col-md-5">
              <?php if(!isset($_GET['eduid'])):?>
              <h3>Education Create</h3>
  						<form method="post">
  							<div class="form-group">
  								<label>Category</label>
  								<select class="form-control" id="category" name="category" required>
                    <option value="">- Select</option>
                    <?php foreach($education_categories as $cat) :?>
                      <option value="<?php echo $cat['category']?>"><?php echo $cat['category']?></option>
                    <?php endforeach;?>

                    <option value="others">Others</option>
  								</select>

                  <div class="category_container">
                    <input type="text" name="other_category" class="form-control">
                  </div>
  							</div>
                <div class="form-group">
  								<label>Month</label>
  								<select class="form-control" name="month">
                    <?php $numberedMonth = 1;?>
  									<?php foreach(getDates('long') as $month):?>
  										<option value="<?php echo $numberedMonth;?>"><?php echo $month;?></option>
                      <?php $numberedMonth ++;?>
  									<?php endforeach;?>
  								</select>
  							</div>
  							<div class="form-group">
  								<label>Year</label>
  								<select class="form-control" name="year">
  									<?php foreach(generateYear() as $year):?>
  										<option value="<?php echo $year;?>" ><?php echo $year;?></option>
  									<?php endforeach;?>
  								</select>
  							</div>
                <div class="form-group">
  								<label>Course / Field</label>
                  <input type="text" name="course" class="form-control">
  							</div>
  							<div class="form-group">
  								<label>School / University</label>
  								<input type="text" name="school" class="form-control">
  							</div>

                <div class="form-group">
  								<label>Description</label>
                  <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                  <small>Give a Description about your work.</small>
  							</div>

  							<input type="submit" name="addEducation" class="btn btn-primary" value="Add Education">
  						</form>
              <?php else:?>
                <?php $education = getOtherEdu($_GET['eduid']);?>
                <h3>Education Create</h3>
    						<form method="post">
                  <input type="hidden" name="eduid" value="<?php echo $education['id']?>">
    							<div class="form-group">
    								<label>Category</label>
    								<select class="form-control" id="category" name="category" required>
                      <option value="">- Select</option>
                      <?php foreach($education_categories as $cat) :?>
                        <?php $selected = $education['category'] == $cat['category'] ? 'selected' : '' ?>
                        <option value="<?php echo $cat['category']?>" <?php echo $selected;?>><?php echo $cat['category']?></option>
                      <?php endforeach;?>

                      <option value="others">Others</option>
    								</select>

                    <div class="category_container">
                      <input type="text" name="other_category" class="form-control">
                    </div>
    							</div>
                  <div class="form-group">
    								<label>Month</label>
    								<select class="form-control" name="month">
                      <?php $numberedMonth = 1;?>
    									<?php foreach(getDates('long') as $month):?>
                        <?php $selected = $numberedMonth == $education['month'] ? 'selected' : '' ?>
    										<option value="<?php echo $numberedMonth;?>" <?php echo $selected;?>><?php echo $month;?></option>
                        <?php $numberedMonth ++;?>
    									<?php endforeach;?>
    								</select>
    							</div>
    							<div class="form-group">
    								<label>Year</label>
    								<select class="form-control" name="year">
    									<?php foreach(generateYear() as $year):?>
    										<?php $selected = $year == $education['year'] ? 'selected' : '' ;?>
    										<option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
    									<?php endforeach;?>
    								</select>
    							</div>
                  <div class="form-group">
    								<label>Course / Field</label>
                    <input type="text" name="course" class="form-control" value="<?php echo $education['course']?>">
    							</div>
    							<div class="form-group">
    								<label>School / University</label>
    								<input type="text" name="school" class="form-control" value="<?php echo $education['school']?>">
    							</div>

                  <div class="form-group">
    								<label>Description</label>
                    <textarea name="description" rows="8" cols="80" class="form-control"><?php echo $education['description']?></textarea>
                    <small>Give a Description about your work.</small>
    							</div>

    							<input type="submit" name="updateEducation" class="btn btn-primary" value="Update Education">
    						</form>
              <?php endif;?>
  					</div>

            <div class="col-md-7">
              <h3>Other Educations</h3>
              <table class="table">
                <thead>
                  <th>School</th>
                  <th>Category</th>
                  <th>Course / Field</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Description</th>
                  <th>Edit</th>
                </thead>
                <tbody>
                  <?php foreach($applicant_other_educations as $edu) :?>
                    <tr>
                      <td><?php echo $edu['school']?></td>
                      <td><?php echo $edu['category']?></td>
                      <td><?php echo $edu['course']?></td>
                      <td><?php echo getDates('long' , $edu['month'])?></td>
                      <td><?php echo $edu['year']?></td>
                      <td>
                        <p style="width:300px;">
                          <?php echo $edu['description']?>
                        </p>
                      </td>
                      <td>
                        <a href="education_create.php?eduid=<?php echo $edu['id']?>">Edit</a>
                      </td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
				</div>
			</section>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>

<script type="text/javascript">

	$( document ).ready(function()
	{
    $(".category_container").hide();

    $("#category").change(function(evt){

      if($(this).val() == 'others') {
        $(".category_container").show()
      }else{
        $(".category_container").hide();
      }
    });

		$(".el-toggle").each(function(index)
		{
			$(this).on('click' , function(){

				var toggle = $(this).data('target');

				$(toggle).slideToggle();
			});
		});
	});
</script>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>
