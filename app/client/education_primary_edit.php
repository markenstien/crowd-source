<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
	if(postRequest('updateEducation')){

		updateEducation($_POST);	
	}

	$education = __profile()->getEducation();
?>
<?php build('content') ?>
<div style="margin-top: 50px;"></div>

<div class="card">
	<div class="card-header">
		<h4>Education Update</h4>
		<?php Flash::show()?>
	</div>

	<div class="card-body">
		<form method="post">
			<div class="form-group">
				<label>Educational Attainment</label>
				<select class="form-control" name="highest_attainment">
					<option value="High School Diploma" 
					<?php echo $education['highest_attainment'] == 'High School Diploma' ? 'selected' : ''?> >High School Diploma</option>

					<option value="Vocational" 
					<?php echo $education['highest_attainment'] == 'Vocational' ? 'selected' : ''?>>Vocational</option>

					<option value="College Degree" 
					<?php echo $education['highest_attainment'] == 'College Degree' ? 'selected' : ''?>>College Degree</option>

					<option value="Masters Degree" 
					<?php echo $education['highest_attainment'] == 'Masters Degree' ? 'selected' : ''?>>Masters Degree</option>
				</select>
			</div>
			<div class="form-group">
				<label>Year</label>
				<select class="form-control" name="school_year">
					<?php foreach(generateYear() as $year):?>
						<?php $selected = $year == $education['year'] ? 'selected' : '' ;?>
						<option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="form-group">
				<label>School / University</label>
				<input type="text" name="school" class="form-control" 
				value="<?php echo $education['school']?>"> 
			</div>

			<input type="submit" name="updateEducation" class="btn btn-primary" value="Update">
		</form>
	</div>
</div>

<?php endbuild()?>
<?php loadTo('orbit/app')?>

