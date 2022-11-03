<?php 	
	function auth()
	{
		if(empty(Session::get('auth')) ) 
			return '';

		$type = Session::get('auth');

		switch ( strtolower($type) ) {
			case 'company':

				$auth = Session::get('company');

				$auth = array_merge($auth , [
					'auth-type' => 'company'
				]);

				return $auth;
				break;
			case 'vendor':
				$auth = Session::get('user');

				$auth = array_merge($auth , [
					'auth-type' => 'vendor'
				]);

				return $auth;

				break;
			default:

				$auth = Session::get('user');

				$auth = array_merge($auth , [
					'auth-type' => 'applicant'
				]);

				return $auth;
		}
	}


	function isDoneSetup()
	{
		$auth = auth();

		if($auth['done_setup'])
			return true;
		return false;
	}

	function authUpdate($values)
	{
		$auth = Session::get('auth');

		$authValues = auth();

		$authUpdate = array_merge($authValues , $values);

		Session::set("{$auth}" , $authUpdate);
	}