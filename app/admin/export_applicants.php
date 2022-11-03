<?php require_once '../dependencies.php';?>

<?php
	
	$applicantList = unserialize(base64_decode($_POST['parameters']));


	// header("Content-Type: application/xls");    
	// header("Content-Disposition: attachment; filename=$filename.xls");  
	// header("Pragma: no-cache"); 
	// header("Expires: 0");
?>
<?php
		
	$headers = [
		'name' => 'Name' ,
		'mobile' => 'Mobile',
		'email' => 'Email',
		'jobname' => 'Job',
		'companyname' => 'Company',
		'date'   => 'Date',
		'label'  => 'Status'
	];

	export($applicantList , $headers);
?>	

