<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>


<?php
    
    if(isset($_POST['updateEducation']))
    {
        $update = updateOtherEducation($_POST);

        if($update) {
            Flash::set("Education Updated");
        }
    }

     $education_categories = getEducationCategories();
?>

<?php build('content') ?>
<?php $education = getOtherEdu($_GET['eduid']);?>


<div style="margin-top: 50px;"></div>
<div class="card">
    <div class="card-header">
        <h4>Education Edit</h4>
        <?php Flash::show()?>
    </div>

    <div class="card-body">
        <form method="post">
            <input type="hidden" name="eduid" value="<?php echo $education['id']?>">

            <div class="form-group">
                <div id="category">
                    <label>Category</label>

                    <?php
                        $education_categories = arr_layout_keypair($education_categories , ['category' , 'category']);

                        $education_categories['Others'] = 'Others';

                        FormSelect('category' , $education_categories ,  $education['category']  , [
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
