<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
  if(postRequest('addEducation'))
  {
    $result = addEducation($_POST);

    if($result) {
      Flash::set("Education {$_POST['category']} added" );

      return redirect('profile.php');
    }
  }
?>

<?php
  $user = new Profile();
  $personal = $user->getPersonal();
  $education = $user->getEducation();
  $workExperiences = $user->getWorkExperience();
  $skills   = $user->getSkills();

  $jobApplications = getUserApplications($user->getId());

  $workHistory     = new WorkHistory($user->getId());

  $education_categories = getEducationCategories();

  $applicant_other_educations = getApplicantEducations(Session::get('user')['id']);
?>


<?php build('content') ?>
<div style="margin-top: 50px;"></div>
<div class="card card-theme-dark col-md-5">
  <?php Flash::show()?>
  <div class="card-header">
    <h4 class="card-title">Educations</h4>
  </div>

  <div class="card-body">
    <form method="post">
        <div class="form-group">
          <div id="category">
              <label>Category</label>

              <?php
                  $education_categories = arr_layout_keypair($education_categories , ['category' , 'category']);

                  $education_categories['Others'] = 'Others';

                  FormSelect('category' , $education_categories ,  ''  , [
                      'class' => 'form-control',
                  ]);
              ?>
          </div>

          <label>
              <?php FormCheckbox('others' ,'' , ['id' => 'other_category']) ?>
              Check if others
          </label>

          <div class="hidden other">
              <label>Others</label>
              <div class="category_container">
                <input type="text" name="other_category" class="form-control">
              </div>
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
        <?php
          FormSelect('year' , generateYear() , '', [
            'class' => 'form-control'
          ]);
        ?>
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
        <small>Tell us something about this education</small>
      </div>

      <input type="submit" name="addEducation" class="btn btn-primary" value="Add Education">
    </form>
  </div>
</div>
<?php endbuild()?>


<?php build('scripts')?>

    <script type="text/javascript">
        $( document ).ready( function(evt) {

            $("#other_category").click( function(evt) {

                let isChecked  = $(this).is(':checked');

                $('.hidden').toggle();
                $('#category').toggle();
            });

            $('.hidden').hide();
        });
    </script>
<?php endbuild()?>


<?php loadTo('orbit/app')?>

