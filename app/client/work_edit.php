<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
  
  if(isset($_POST['updateWorkExperience']))
  {
    $update = updateWorkExperience($_POST);
    
    if($update) {
      Flash::set("Work Updated");
    }
  }
?>

<?php build('content') ?>
<?php 
  $work = getWorkExperience($_GET['workid']);
  $jobFields     = getJobFields();
?>

<div id="wrapper">
  <div style="margin-top: 50px;"></div>
  <div class="col-md-5">
    <div class="card card-theme-dark">
      <div class="card-header">
        <h4 class="card-title">Update Work Information</h4>
        <?php Flash::show()?>
      </div>
      <div class="card-body">
        <form class="form"  method="post">
          <input type="hidden" name="workid" value="<?php echo $work['id']?>">
          <div class="form-group">
            <label>Field</label>
            <?php FormSelect('field' , arr_layout_keypair($jobFields , ['field' , 'field']) , $work['field'] , [
              'class' => 'form-control'
            ]);?>
          </div>
          <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" class="form-control" value="<?php echo $work['position']?>">
          </div>
          <div class="form-group">
            <label>Role Description</label>
            <textarea class="form-control" rows="10" name="role_description"><?php echo $work['role_description']?></textarea>
          </div>
          <div class="form-group">
            <label>When</label>
            <div class="row">
              <div class="col-md-5">
                <label>Date</label>
                <select class="form-control" name="date">
                  <?php foreach(getDates('short') as $date):?>
                    <?php $selected = $date == $work['date'] ? 'selected' : ''?>
                    <option value="<?php echo $date;?>" <?php echo $selected;?>><?php echo $date;?></option>
                  <?php endforeach;?>
                </select>
              </div>
              <div class="col-md-5">
                <label>Year</label>
                <select class="form-control" name="year">
                  <?php foreach(generateYear() as $year) :?>
                    <?php $selected = $year == $work['year'] ? 'selected' : ''?>
                    <option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          <input type="submit" name="updateWorkExperience" value="Save Changes" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</div>
<?php endbuild()?>
<?php loadTo('orbit/app')?>