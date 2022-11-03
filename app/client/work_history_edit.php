<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php
	if(postRequest('uploadProfile'))
	{
		$userid = Session::get('user')['id'];

		uploadProfile($userid);
	}

	if(postRequest('updateWorkHistory'))
	{
		updateWorkHistory($_POST);
	}


	$workExperiences = __profile()->getWorkExperience();
	$jobFields = getJobFields();
?>
<?php build('content') ?>
	
<?php endbuild()?>

<?php loadTo('orbit/app')?>

