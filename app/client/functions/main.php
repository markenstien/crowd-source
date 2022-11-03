<?php 	
	
	function __register()
	{
		global $_errors;

		$firstname = trim( ucwords(_post('firstname')) );
		$lastname  = trim( ucwords(_post('lastname')) );

		$email = trim(_post('email'));
		$birthday = _post('birthday');
		$gender   = _post('gender');

		//check if isset agreement
		$db = DB::getInstance();

		/**
		 * validate
		 * email
		 */

		$emailExists = db_single('user_informations' , db_condition_equal(['email' => $email]));

		if($emailExists) {
			$_errors [] = " Email <strong> {$email} </strong> already exists ";
		}
		/*
		*CREATE USERNAME
		*/
		$usernamePrefix = strtoupper($firstname[0].''.$lastname[0]);
		$username = $usernamePrefix.random_number(2).getUserLastId();
		$password = charGen(4);

		$usernameExists = db_single('users' , db_condition_equal(['username' => $username]) );

		if($usernameExists)
			$_errors [] = " Username <strong> {$username} </strong> alredy exists";
		

		if(!empty($_errors)){

			Flash::set( implode(',' , $_errors) , 'danger');

			return false;
		}else{
			$db->query(
				"INSERT INTO users (username , password , type , status , is_verified)
					VALUES('$username' , '$password' , 'Applicant' , 'active' , true)"
			);

			$userId = insertId($db);

			$db->query(
				" INSERT INTO user_informations(userid , firstname , lastname , gender , birthday , email) 
					VALUES('$userId' , '$firstname' , '$lastname' , '$gender' , '$birthday' , '$email')"
			);

			$isCreated = insertId($db);

			if($isCreated) 
			{
				return createRegistrationConfirmation($userId ,$email);
			}else{
				return false;
			}
		}
	}


	function __store_skills()
	{
		$db = DB::getInstance();


		$post = $_POST;

		$skillError = "You must have atleast 3 skills";

		if( !isset($post['skills']) ){
			Flash::set($skillError , 'danger');
			return false;
		}

		if( count($post['skills']) < 3) {
			Flash::set($skillError , 'danger');
			return false;
		}

		$skills = $_POST['skills'];
		$userId = _post('user_id');

		$sql = " INSERT INTO applicant_skills(userid , category) VALUES";

		$counter = 0;


		foreach($skills as $key => $skillId)
		{
			if($counter < $key) {

				$sql.= " , ";
				$counter++;
			}

			$sql .= " ('$userId' , '$skillId') ";
		}

		return $db->query($sql);
	}

	function __store_education()
	{
		$db = DB::getInstance();

		$userId = _post('user_id');
		$highestAttainment = _post('highest_attainment');
		$year = _post('year');
		$school = _post('school');

		return $db->query(
			"INSERT INTO applicant_educations(userid , highest_attainment , year , school)
				VALUES('$userId' , '$highestAttainment' , '$year' , '$school')"
		);
	}



	function __save_work_experience()
	{
		$db = DB::getInstance();

		$userid = _post('user_id');
		$field = _post('field');
		$position = _post('position');
		$roleDescription = _post('role_description');
		$date = _post('date');
		$year = _post('year');

		return $db->query(
			" INSERT INTO work_experiences(userid , field , position , role_description , date ,year , status)
				VALUES('$userid' , '$field' , '$position' , '$roleDescription' , '$date' , '$year' , 'active')"
		);
	}

	function __save_contact()
	{
		$db = DB::getInstance();
		$userid = _post('user_id');

		$address = _post('address');
		$phone = _post('phone');

		return account_info_update(compact('address' , 'phone') , $userid);
	}

	function __profile()
	{
		return new Profile();
	}