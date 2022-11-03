<?php 	

	class Authentication
	{
		private $warnings = null;

		private $user;

		public function __construct()
		{
			$this->db = DB::getInstance();
		}
		private function getUserName($username)
		{
			$username = strtolower($username);

			$query = $this->db->query(
				"SELECT * FROM users where username = '$username'"
			);
			if($user = $query->fetch_assoc())
			{
				$this->user = $user;

				return $user;
			}else
			{
				$this->warnings = 'No User Found';

				return '';
			}
		}

		private function checkPasswordMatch($pwd , $hashsed)
		{
			if(password_verify($pwd, $hashsed))
				return true;
			return false;
		}

		public function authenticate($username , $password , $accountType = 'client')
		{
			if(strtolower($accountType) === 'company')
			{
				
			}else if($accountType === 'client')
			{
				$user = $this->getUserName($username);
				if(empty($user))
				{
					Flash::set('No user found' , 'warning');
					return false;
				}else
				{
					if($password == $user['password']){
						$this->setSession();
						Flash::set('Welcome back ' . $user['username']);
						return true;
					}else
					{
						Flash::set('Password Unmatched' , 'warning');
						return false;	
					}
				}
			}
			
		}

		public function getCompany($username , $password)
		{
			$query = $this->db->query("SELECT * FROM companies where username = '$username'");

			if($query->num_rows)
			{
				$res = fetchSingle($query);
				//check password
				if($res['password'] == $password){
					Flash::set('Logged in');
					Session::set('user' , $res);

					return true;
				}else
				{
					Flash::set('Password doest not match' , 'primary');
					return false;
				}
			}else
			{
				Flash::set('No account found' , 'primary');
				return false;
			}
		}

		public function setSession()
		{
			Session::set('user' , array(
				'id' => $this->user['id'],
				'type' => $this->user['type'],
				'username' => $this->user['username']
			));
		}
		public function warnings()
		{
			return $this->warnings;
		}
	}