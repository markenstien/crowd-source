<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>
<?php
	if(postRequest('updateSkill'))
	{
		updateUserSkills($_POST['skills']);
	}

	if(postRequest('createNewSkill'))
	{
		createNewSkill($_POST['category'] , $_POST['description']);
	}

	//delete skills
	if( getRequest('delete') )
	{
		$id = $_GET['id'];

		$db = DB::getInstance();

		$res = $db->query(
			"DELETE FROM applicant_skills 
				where id = '{$id}' "
		);
		if($res) {
			Flash::set("Skill is deleted");
			return redirect('skills_edit.php');
		}
	}

	$skillCategoryList = getCategoryList();
	$skills   = __profile()->getSkills();
?>
<?php build('content') ?>

<div id="wrapper">
	<div style="margin-top: 50px;"></div>
	<div class="card card-theme-dark">
		<div class="card-header">
			<h4 class="card-title">Your Skills</h4>
		</div>

		<div class="card-body">
			<div class="row">
				<?php foreach($skills as $key => $row) :?>
					<div class="col-md-6 col-lg-6 col-xl-3">
	                    <div class="card text-white bg-dark m-b-30">
	                        <div class="card-header"><?php echo $row['category']?></div>
	                        <div class="card-body">
	                            <p class="card-text"><?php echo $row['description']?></p>
	                        </div>

	                        <div class="card-footer">
	                        	<a href="?action=delete&id=<?php echo $row['id']?>" class="btn btn-danger btn-sm"> Delete </a>
	                        </div>
	                    </div>
	                </div>
				<?php endforeach?>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-7">
			<div class="card card-theme-dark">
				<div class="card-header">
					<h4 class="card-title">Select Skills</h4>
				</div>

				<div class="card-body">
					<form method="post">
						<div class="form-group">
							<label>Hold *crtl* to select multiple</label>
							<select class="form-control" name="skills[]" multiple>
								<?php foreach($skillCategoryList as $cat) :?>
									<option value="<?php echo $cat['id']?>">
										<?php echo $cat['category']?>
									</option>
								<?php endforeach;?>
							</select>
						</div>

						<div class="form-group">
							<input type="submit" name="updateSkill" value="Update skill" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-5">
			<div class="card card-theme-dark">
				<div class="card-header">
					<h4 class="card-title">Add Skill</h4>
				</div>

				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label>Category</label>
							<input type="" name="category" class="form-control">
						</div>
						<div class="form-group">
							<label>Description</label>
							<input type="" name="description" class="form-control">
						</div>
						<input type="submit" name="createNewSkill" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endbuild()?>

<?php build('headers')?>

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
<?php endbuild()?>
<?php loadTo('orbit/app')?>

