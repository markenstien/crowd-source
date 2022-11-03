<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>


<?php

	do_action('__store_skills' , '_save_skills');
	do_action('__store_education' , '_save_education');
	do_action('__save_work_experience' , '_save_work_experience');
	
	$contactIsSaved = do_action('__save_contact' , '_save_contact');

	if($contactIsSaved) {
		$res = account_update(['done_setup' => true] , auth()['id']);
		authUpdate([
			'done_setup' => true
		]);

		if($res) 
		{
			Flash::set("Account finished setup!");
			return redirect('profile.php');
		}
	}
?>
	<?php
		$skills = getCategoryList();
		$hidden = false;
		//get skills

		$applicant = new Applicant(auth()['id']);

		$userSkills = $applicant->getSkills();
		$userEducation = $applicant->getEducation();
		$userWorkExperience = $applicant->getWorkExperience();
	?>
	<?php build('content')?>

       <div style="height: 75px;"></div>
       <h3>Firstime setup</h3>
       <?php Flash::show()?>
		<div class="row">
			<div class="col-md-7">
				<!-- SKILLS -->
				<?php if(empty($userSkills)) :?>
					<form method="post">
						<?php FormHidden('user_id' , auth()['id'])?>

						<div class="card card-theme-dark" style="<?php echo $hidden == false ? 'display: block' : 'display: none'?>">
							<div class="card-header">
								<div class="row">
									<div class="col-md-6">
										<h4 class="card-title">Skills</h4>
										<p>Select atleast 3 skills , click to select.</p>
									</div>

									<div class="col-md-6 text-right">
										<?php
											FormSubmit('_save_skills' , 'Save');
										?>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<?php foreach($skills as $key => $skill) :?>
									<?php $skillDOMID = charGen(12)?>
									<div class="col-md-6 col-lg-6 col-xl-6 skill" data-target="#<?php echo $skillDOMID?>">
					                    <div class="card text-white bg-primary m-b-30">
					                        <div class="card-body">
					                            <h5 class="card-title text-white font-18"><?php echo $skill['category']?></h5>
					                            <p class="card-text"><?php echo $skill['description']?></p>
					                            <?php FormCheckbox('skills[]' , $skill['id'], [
					                            	'id' => $skillDOMID ,
					                            	'style' => 'display:none'
					                            ])?>
					                        </div>
					                    </div>
					                </div>
					            	<?php endforeach?>
								</div>
							</div>
						</div>
					</form>	
				<?php $hidden = true?>
				<?php endif;?>

				<!-- EDUCATION -->
				<?php if(is_null($userEducation)) :?>
				<div class="card card-theme-dark" style="<?php echo $hidden == false ? 'display: block' : 'display: none'?>">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6"><h4 class="card-title">Education</h4></div>
							<div class="col-md-6 text-right"><?php FormSubmit('_save_education' , 'Save' , ['form' => 'education_form']);?></div>
						</div>

					</div>
					<div class="card-body">
						<?php FormOpen( ['id' => 'education_form'])?>
							<?php FormHidden('user_id' , auth()['id'])?>
							<div class="form-group">
								<?php
									FormLabel('Educational Attainment');

									FormSelect('highest_attainment' , [ 
										'High School Diploma',
										'Vocational',
										'College Degree',
										'Masters Degree'
									] , '' , ['class' => 'form-control']);
								?>
							</div>

							<div class="form-group">
								<?php 
									$years = generateYear(1);
									FormLabel('Year');
									FormSelect('year' , $years , '' , ['class' => 'form-control']);
								?>
							</div>

							<div class="form-group">
								<?php
									FormLabel('School/University');
									FormTextarea('school' , '' , ['class' => 'form-control']);
								?>
							</div>
						<?php FormClose()?>
					</div>
				</div>
				<?php $hidden = true?>
				<?php endif;?>

				<!-- WORK EXPERIENCE -->
				<?php if(is_null($userWorkExperience)) :?>
					<div class="card card-theme-dark" style="<?php echo $hidden == false ? 'display: block' : 'display: none'?>">
						<?php
							$workFields = arr_layout_keypair(getJobFields() , ['field' , 'field']);
						?>
						<div class="card-header">
							<div class="row">
								<div class="col-md-6">
									<h4 class="card-title">Work Experience</h4>
									<p>Your latest work experience. <a href="#">I have no work-experience</a></p>
								</div>
								<div class="col-md-6 text-right">
									<?php
										FormSubmit('_save_work_experience' , 'Save Work Experience' , ['form' => 'work_experience_form']);
									?>
								</div>
							</div>
						</div>
						<div class="card-body">
							<?php FormOpen(['id' => 'work_experience_form'])?>
								<?php
									FormHidden('user_id' , auth()['id']);
								?>
								<div class="form-group">
									<?php
										FormLabel('Field/Industry');

										FormSelect('field' , $workFields, '' , ['class' => 'form-control']);
									?>
								</div>

								<div class="form-group">
									<?php
										FormLabel('Position');
										FormText('position' , '' , ['class' => 'form-control']);
									?>
								</div>

								<div class="form-group">
									<?php
										FormLabel('Describe your role');
										FormTextarea('role_description' , '' , ['class' => 'form-control']);
									?>
									<small>Or what benefits have you done for the company.</small>
								</div>

								<div class="form-group">
									<?php FormLabel('Date')?>
									<div class="row">
										<div class="col">
											<?php FormLabel('Month')?>
											<?php FormSelect('date' ,getDates('short'), '' ,['class' => 'form-control'])?>
										</div>
										<div class="col">
											<?php FormLabel('Year')?>
											<?php FormSelect('year' , generateYear() , '' ,['class' => 'form-control'])?>
										</div>
									</div>
								</div>
							<?php FormClose()?>
						</div>
					</div>
					<?php $hidden = true?>
				<?php endif?>

				<!-- CONTACT -->
				<div class="card card-theme-dark" style="<?php echo $hidden == false ? 'display: block' : 'display: none'?>">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h4 class="card-title">Contact Details</h4>
							</div>
							<div class="col-md-6 text-right">
								<div class="form-group">
									<?php FormSubmit('_save_contact' , 'Save' , ['form' => 'contact_form']); ?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="card-body">
						<?php FormOpen(['id' => 'contact_form'])?>
						<?php FormHidden('user_id' , auth()['id'])?>
						<div class="form-group">
							<?php
								FormLabel('Mobile Number');
								FormText('phone' , '' , ['class' => 'form-control']);
							?>
						</div>

						<div class="form-group">
							<?php
								FormLabel('Address');
								FormTextarea('address' , '' , ['class' => 'form-control']);
							?>
						</div>
						<?php FormClose()?>	
					</div>
				</div>
				
			</div>

			<div class="col-md-3">
				<ul class="list-unstyled">
					<li>Skills</li>
					<li>Education</li>
					<li class="active">
						<strong>Work Experience</strong>
					</li>
					<li>Contact</li>
				</ul>
			</div>
		</div>
	<?php endbuild()?>

	<?php build('scripts')?>
		<script type="text/javascript">
			$(document).ready( function() {

				$(".skill").click( function(evt) {
					
					let target = $(this).data('target');

					let isChecked = $(target).is(':checked');

					if(!isChecked){
						$(target).prop('checked' , true);
						$(this).addClass('skill-active');
					}else{
						$(target).prop('checked' , false);
						$(this).removeClass('skill-active');
					}
				});
			});
		</script>
	<?php endbuild()?>

	<?php build('headers') ?>
		<style type="text/css">
			.skill.skill-active > div{
				background-color: var(--orange) !important;
			}
		</style>
	<?php endbuild()?>
<?php loadTo('orbit/app')?>