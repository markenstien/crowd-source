<?php require_once('../dependencies.php')?>
<?php 	

	if(!isset($_GET['token'])) 
	{
		Flash::set("Invalid Request!" , 'danger');
		return redirect('account_setup.php');
	}

	$token = $_GET['token'];
	$auth = auth();

	if( isEqual($token , sealInput($auth['username'].''.$auth['id'])) )
	{
		$res = account_update(['done_setup' => true] , $auth['id']);

		authUpdate(['done_setup' => true]);
		
		if($res) {
			Flash::set("Setup finished");
			return redirect('profile.php');
		}
	}else{
		Flash::set("Invalid Token!" , 'danger');
		return redirect('account_setup.php');
	}