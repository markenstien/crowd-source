<?php 	

	class Authenticate
	{
		
		public function __construct()
		{
			$this->db = DB::getInstance();
			$this->error = null;

			$this->type = '';

			$this->doneSetup = false;
		}

		/*
		*@params type client means applicants
		*
		**/
		public function doAction($username , $password , $type = 'client')
		{
			$this->username = $username;
			$this->password = $password;

			//switch type
			switch(strtolower($type))
			{
				case 'client':
					return $this->loginUser();
				break;

				case 'vendor':
					return $this->loginVendor();
				break;

				case 'company':
					return $this->loginCompany();
				break;
			}
		}
		
		private function loginUser()
		{
			$sql = "SELECT * FROM users where username = '$this->username' and type = 'applicant'";
			$query = $this->db->query($sql);

			if($query->num_rows)
			{
				$res = fetchSingle($query);
				if($res['password'] === $this->password)
				{
					Flash::set('Welcom back ' . $res['username']);
					Session::set('user' , $res);
					Session::set('auth' , 'user');

					if($res['done_setup'])
						$this->doneSetup = true;

					$this->type = 'applicant';

					return true;
				}else
				{
					$this->error = 'Password Unmatched';
					return false;
				}
				//check if password matched
			}else{
				$this->error = 'No Account Found';
				return false;
			}
		}

		private function loginCompany()
		{
			$sql = "SELECT * FROM companies where username = '$this->username'";
			$query = $this->db->query($sql);

			if($query->num_rows)
			{
				$res = fetchSingle($query);

				if($res['password'] === $this->password)
				{
					Flash::set('Welcom back ' . $res['username']);
					Session::set('company' , $res);
					Session::set('auth' , 'company');

					$this->type = 'company';
					return true;

				}else
				{
					$this->error = 'Password Unmatched';
					return false;
				}
			}else
			{
				$this->error = 'No Account Found';
			}
		}

		private function loginVendor()
		{
			$sql = "SELECT * 
				FROM users 
				LEFT join user_informations as ui 
				on users.id = ui.userid
				where username = '$this->username' and type = 'Admin'";
			$query = $this->db->query($sql);

			if($query->num_rows)
			{
				$res = fetchSingle($query);

				if($res['password'] === $this->password)
				{
					Flash::set('Welcom back ' . $res['username']);
					Session::set('user' , $res);
					Session::set('auth' , 'vendor');
					
					$this->type = 'vendor';
					return true;
				}else
				{
					$this->error = 'Password Unmatched';
					return false;
				}
				//check if password matched
			}else{
				$this->error = 'No Account Found';
			}
		}

		public function getError()
		{
			return $this->error;
		}
		// private function checkPassword($password , $hash)
		// {
		// 	if()
		// }

	}