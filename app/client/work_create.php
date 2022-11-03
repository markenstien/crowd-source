<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
  if(postRequest('createWorkExperience')) {
      
      if(createWorkExperience($_POST)) {
        Flash::set("{$_POST['work_field']} has been added to your work");
        return redirect('profile.php');
      }
  }
?>

<?php $user = new Profile();?>

<?php
  $personal = $user->getPersonal();
  $education = $user->getEducation();
  $workExperiences = $user->getWorkExperience();
  $skills   = $user->getSkills();

  $jobApplications = getUserApplications($user->getId());

  $workHistory     = new WorkHistory($user->getId());
  $jobFields     = getJobFields();
?>

<?php build('content') ?>

<div id="wrapper">
  <div style="margin-top: 50px;"></div>

  <div class="col-md-5">
    <div class="card card-theme-dark">
      <div class="card-header">
        <h4 class="card-title">Works</h4>
        Add Work Experience
      </div>

      <div class="card-body">
        <form method="post">
          <div class="form-group">
            <label>Field</label>
            <?php 
              FormSelect('work_field' , jobFields() , '' , [
                'class' => 'form-control',
                'required' => ''
              ]);
            ?>
          </div>
          <div class="form-group">
            <label>Position</label>
            <?php FormText('position' , '' , ['class' => 'form-control'])?>
          </div>
          <div class="form-group">
            <label>Role Description</label>
            <?php FormTextarea('role_description' , '' , ['class' => 'form-control' , 'rows' => 5])?>
          </div>
          <div class="form-group">
            <label>When</label>
            <div class="row">
              <div class="col-md-5">
                <label>Date</label>
                <?php FormSelect('work_date' , getDates('short') , '' , ['class' => 'form-control'])?>
              </div>
              <div class="col-md-5">
                <label>Year</label>
                <?php FormSelect('work_year' , generateYear() , '' , ['class' => 'form-control'])?>
              </div>
            </div>
          </div>
          <input type="submit" name="createWorkExperience" value="Save Work" class="btn btn-primary">
      </form>
      </div>
    </div>
  </div>
</div>

<?php endbuild()?>


<?php loadTo('orbit/app')?>


