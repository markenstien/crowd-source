<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php

	/*
	*check for confirmation token
	*/

	if(!isset($_GET['token']))
	{
		Flash::set("Invalid Request");
		return redirect('register.php');
	}

	$token = $_GET['token'];

	$confirmation = getRegistrationConfirmation($token);

	if($confirmation && !$confirmation['is_used']) 
	{
		//confirm account
		$isConfirmed = account_update([
			'is_verified' => TRUE
		], $confirmation['user_id']);


		//update registration
		registration_confirmation_udpate([
			'is_used' => true
		] , $confirmation['id']);

		if($isConfirmed) 
		{
			Flash::set("Account is confirmed");
			//set session

			$account = getUser($confirmation['user_id']);


			$emailBody = mailTemplate("
					<p> Your registration has been verified. use the following authentications below to 
						access your account. you change your password later on your account page</p>
					
					<ul> 
						<li> Username : {$account['username']} </li>
						<li> Password : {$account['password']} </li>
					</ul>
				");

			$emailSent = _mail($account['email'] , 'Thank you for Joining us' , $emailBody);

			$auth = new Authenticate();

			$authenticated = $auth->doAction($account['username'] , $account['password']);

			if(!$authenticated) {
				Flash::set( implode(',', $auth->getError()) , 'danger' ,'_error');
				return redirect('register.php');
			}else{
				Flash::set("Your Account username and password has been sent to your email credentials are automatically created by the system to ensure secure registration. you can the details after setting up your account." , 'primary' , 'heads_up');
				return redirect('account_setup.php');
			}
		}
	}else{
		Flash::set("Confirmation expired" , 'danger');
		return redirect('register.php');
	}
?>