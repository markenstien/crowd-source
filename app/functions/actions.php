<?php
	############GLOBAL############
	function postRequest($name = null)
	{
		if(is_null($name))
		{
			if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
				return TRUE;
			return FALSE;
		}
		else
		{
			if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
			{	
				if(isset($_POST[$name]))
				{
					return TRUE;
				}else
				{
					return FALSE;
				}
			}
			return FALSE;
		}
	}


	function getRequest($actionName)
	{
		if( isset($_GET['action']) && isEqual($_GET['action'] ,$actionName ) )
			return true;
		return false;
	}
	
	########ADMINISTRATOR#########
	function updateCategory($category)
	{
		extract($category);

		$db = DB::getInstance();

		$description = filter_var($description , FILTER_SANITIZE_STRING);

		$sql = "UPDATE job_categories set category = '$category' , description = '$description'
		 where id = '$catid'";

		if($db->query($sql)){
			Flash::set("Job category Updated");
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}
	function createCompany($company)
	{
		extract($company);
		$errors = [];
		//file uploads

		$file = new File();

		//insert logo
		$logo   = '';
		$banner = '';

		$file->setFile($_FILES['logo'])
		->setPrefix('logo')
		->setDIR(BASEROOT.DS.'public/assets/')
		->upload();

		if(!empty($file->getErrors()))
		{
			array_push($errors, $file->getErrors());
		}

		$logo = $file->getFileUploadName();

		$file->setFile($_FILES['banner'])
		->setPrefix('banner')
		->setDIR(BASEROOT.DS.'public/assets/')
		->upload();

		if(!empty($file->getErrors()))
		{
			array_push($errors, $file->getErrors());
		}

		$banner = $file->getFileUploadName();

		if($type == 'others')
		{
			//check if strlen is ok
			if(empty(strlen($type_other))){
				Flash::set('Business Type should not be empty' , 'danger');
			}
			else{
				$type = $type_other;
				if(!createBusinessNature($type_other))
				{
					array_push($errors, "Business Nature Already Exists");
				}
			}
		}


		if(!empty($errors))
		{
			Flash::set(implode(',',$errors) , 'warning');
		}else
		{
			list($username , $password) = generateLoginToken();

			$description = filter_var($description , FILTER_SANITIZE_STRING);
			$address     = filter_var($address , FILTER_SANITIZE_STRING); 
			$status = 'active';

			$sql = "INSERT INTO companies(username , password , name , description , type ,
			address , email , phone , banner , logo , contact_person , contact_number)

			VALUES('$username' , '$password' , '$name' , '$description' , '$type',
			'$address' , '$email' , '$phone' , '$banner' , '$logo' , '$contact_person' , '$contact_number')";

			$db = DB::getInstance();

			$query = $db->query($sql);

			if($query)
			{
				$message = "Congratulations you are now registered to CAREERS-METROJOBS <br/> thsese are your logins <br/>
					<div> Username : {$username}</div> <div> Password : {$password}</div>";

				mailUserAuth($message , $email);

				Flash::set('Company Created' , 'success' , 'company');
				redirect('company_list.php');
			}else
			{
				Flash::set(mysqli_error($db) , 'warning');
			}
		}
	}

	function createJobAdmin($job)
	{
		extract($job);

		$db = DB::getInstance();
		$date_posted = dateNow();
		//temporary id

		$notes = filter_var($notes , FILTER_SANITIZE_STRING);

		$company = getCompanyInfo($companyid);


		if($position === 'others')
		{
			if(empty($position_others)){
				Flash::set("Position others cannot be empty");
				return;
			}else{
				$position = $position_others;

				if(!createJobPosition($position_others)){
					Flash::set("Job position already exists" , 'danger');
				}
			}
		}
		if(!empty($category_list)) {
			$categories = implode(',' , $category_list);


			$sql = "INSERT INTO jobs(date_posted , title , sub_title , position , companyid , email ,
			phone , salary , salary_type, address , notes , status , education , gender, categories , urgency,duration,employee_needed)
			VALUES('$date_posted' , '$title' , '$sub_title' , '$position' , '{$company['id']}' , '{$company['email']}',
			'{$company['phone']}' , '$salary', '$salary_type', '{$company['address']}' , '$notes','for posting' ,
			'$education' , '$gender' , '$categories' , '$urgency','$duration','$employee_needed')";

			$query = $db->query($sql);

			if($query)
			{
				$lastid = insertId($db);
				//insert job post category
				if(!empty($examid))
				{
					examJobAttach($lastid , $examid);

					Flash::set('Job Created!');

					redirect('job_view.php?id='.$lastid);
				}else{
					Flash::set('Exam Not set', 'danger');
				}

				redirect('job_list.php');
			}else
			{
				Flash::set(mysqli_error($db) , 'danger');
			}
		}else{
			Flash::set('You must have a category for this job' , 'danger');
		}

	}
	function changePassword($password)
	{
		$user = Session::get('user');

		$db = DB::getInstance();

		$sql = "UPDATE users set password = '$password' where id = '{$user['id']}'";

		if($db->query($sql)){
			Flash::set('Users password has been updated');
		}
	}
	function createJob($job)
	{
		####################
		extract($job);

		$db = DB::getInstance();
		$date_posted = dateNow();
		//temporary id

		$notes = filter_var($notes , FILTER_SANITIZE_STRING);

		$company = getCompanyInfo($companyid);

		if($position === 'others')
		{
			if(empty($position_others)){
				Flash::set("Position others cannot be empty");
				return;
			}else{
				$position = $position_others;

				if(!createJobPosition($position_others)){
					Flash::set("Job position already exists" , 'danger');
				}
			}
		}


		if(!empty($category_list)) {
			$categories = implode(',' , $category_list);
			$sql = "INSERT INTO jobs(date_posted , title , sub_title , position , companyid , email ,
			phone , salary , salary_type, address , notes , status , education , gender, categories , urgency, duration , employee_needed)
			VALUES('$date_posted' , '$title' , '$sub_title' , '$position' , '{$company['id']}' , '{$company['email']}',
			'{$company['phone']}' , '$salary', '$salary_type', '{$company['address']}' , '$notes','for posting' ,
			 '$education' , '$gender' , '$categories' , '$urgency' , '$duration' , '$employee_needed')";

			$query = $db->query($sql);

			if($query)
			{
				$lastid = insertId($db);
				Flash::set('Job Created!');
				redirect('job_view.php?id='.$lastid);
				//insert job post category
			}else
			{
				Flash::set(mysqli_error($db) , 'danger');
			}
		}else{
			Flash::set('You must have a category for this job' , 'danger');
		}
		#####################
	}

	function createJobPostCategories($categories , $jobid)
	{
		$sql = "INSERT INTO job_post_categories(jobid , categoryid) VALUES";

		$counter = 0;

		for($i = 0 ; $i < count($categories) ; $i++)
		{
			if($counter < $i)
			{
				$sql .= ' , ';
				$counter++;
			}

			$sql .= "('$jobid','{$categories[$i]}')";
		}

		$db = DB::getInstance();

		return $db->query($sql);
	}
	function updateJob($job)
	{
		extract($job);
		if($position === 'others')
		{
			if(empty($position_others)){
				Flash::set("Position others cannot be empty");
				return;
			}else{
				$position = $position_others;

				if(!createJobPosition($position_others)){
					Flash::set("Job position already exists" , 'danger');
				}
			}
		}
		if(is_numeric($salary))
		{
			$db = DB::getInstance();
			$date_posted = dateNow();
			//temporary id
			$userid = 1;

			$notes = filter_var($notes , FILTER_SANITIZE_STRING);
			$sql = "UPDATE jobs set  title = '$title' , sub_title = '$sub_title' ,
			position = '$position' , email = '$email' , phone = '$phone' , salary = '$salary' ,
			education = '$education' , gender = '$gender' , urgency = '$urgency',
			address = '$address', notes = '$notes' , duration = '$duration' , employee_needed = '$employee_needed'
			where id = '$jobid'";

			$query = $db->query($sql);

			if($query){
				Flash::set('Job Updated');
			}else
			{
				Flash::set(mysqli_error($db) , 'danger');
			}
		}else
		{
			Flash::set('Salary must be number');
		}

	}

	function updateJobCategory($jobid , $category_list)
	{
		$db = DB::getInstance();

		if(!empty($category_list))
		{
			$categories = implode(',', $category_list);
			$sql = "UPDATE jobs set categories = '$categories' where id = '$jobid'";

			if(!$query = $db->query($sql))
			{
				Flash::set(mysqli_error($db) , 'danger');
			}else{
				Flash::set('Job Category has been updated');
			}
		}else
		{
			Flash::set('Job update category failed');
		}

	}

	function postJob($jobid)
	{
		$db = DB::getInstance();
		$sql = "UPDATE jobs set status = 'posted' where id = '$jobid'";

		$query = $db->query($sql);

		if($query)
		{
			Flash::set('Job Posted!');
		}else
		{
			Flash::set('Something went wrong' , 'danger');
		}
	}

	function cancelJob($jobid)
	{
		$db = DB::getInstance();
		$sql = "UPDATE jobs set status = 'cancelled' where id = '$jobid'";

		$query = $db->query($sql);

		if($query)
		{
			Flash::set('Job Cancelled!');
		}else
		{
			Flash::set('Something went wrong' , 'danger');
		}
	}

	function closeJob($jobid)
	{
		$db = DB::getInstance();
		$sql = "UPDATE jobs set status = 'closed' where id = '$jobid'";

		$query = $db->query($sql);

		if($query)
		{
			Flash::set('Job Closed!');
		}else
		{
			Flash::set('Something went wrong' , 'danger');
		}
	}

	function openJob($jobid)
	{
		$db = DB::getInstance();
		$sql = "UPDATE jobs set status = 'open' where id = '$jobid'";

		$query = $db->query($sql);

		if($query)
		{
			Flash::set('Job Posted!');
		}else
		{
			Flash::set('Something went wrong' , 'danger');
		}
	}
	function createCategory($category)
	{
		extract($category);

		$db = DB::getInstance();

		$sql = "INSERT INTO job_categories(category , description , status)
		values('$category' , '$description' ,'activie')";

		if($query = $db->query($sql))
		{
			Flash::set('Category Created' , 'success' , 'category');
			return redirect('category_list.php');
			// redirect('category_view.php?id='.insertId($db));
		}else
		{
			Flash::set(mysqli_error($db) , 'warning');
		}
	}
	#####################APPLICANT#############

	function apply()
	{
		//validate
		redirect('job_application.php?id='.$_POST['jobid']);
	}

	function sendJobApplication($jobApplication)
	{
		//if missing resume is > 1 its not allowed

		$missingResume = 0;

		$errors = array();

		extract($jobApplication);

		$db = DB::getInstance();

		$userid = Session::get('user')['id'];

		$job = getJob($jobid);

		$pitchWordCount = str_word_count( $applicant_pitch );
		
		if($pitchWordCount < 10 )
		{
			Flash::set("Applicant Pitch no lesser than 10 words" , 'warning');
			return;
		}else if($pitchWordCount > 500)
		{
			Flash::set("Applicant Pitch no greater than 500 words" , 'warning');
			return;
		}

		if(hasApplied($userid , $jobid)){
			Flash::set('You have already applied for the job' , 'danger');
			return;
		}

		if(isPreviousEmployer($job['companyid'] , $jobid))
		{
			Flash::set("You have already been an employee of the employer" , "danger");
			return;
		}

		if(isEmployed($userid))
		{
			Flash::set('You are currently employed check your job history for details' , 'danger');
			return;
		}

		
		
		
		$attachmentName = '';
		$resumeImage = '';
		$resumeText   ='';
		//check if isset files resume image

		if(isset($_FILES['resume_image']))
		{
			$file = new File();

			$file->setFile($_FILES['resume_image'])
			->setPrefix('resumeImage')
			->setDIR(BASEROOT.DS.'public/assets/')
			->upload();

			if(!empty($file->getErrors()))
			{
			}else{
				$resumeImage = $file->getFileUploadName();
			}
		}else{
			$missingResume++;
		}

		$resumeText = '';

		if(isset($_FILES['resume_text']))
		{
			$file = new File();

			$file->setFile($_FILES['resume_text'])
			->setPrefix('resumeText')
			->setDIR(BASEROOT.DS.'public/assets/')
			->upload();

			if(!empty($file->getErrors()))
			{
				array_push($errors, $file->getErrors());
			}else
			{
				$resumeText = $file->getFileUploadName();
			}
		}else
		{
			$missingResume++;
		}

		//check if missing resume is 2 then failed

		if($missingResume == 2)
		{
			Flash::set('Upload atleast 1 resume' , 'warning');
			return;
		}

		
		if(!empty($errors))
		{
			Flash::set(implode(',' , $errors) , 'danger');
		}else{
			$applicant_pitch = filter_var($applicant_pitch , FILTER_SANITIZE_STRING);

			$query = db_insert('job_applications' , [
				'jobid'           => $jobid,
				'userid'          => $userid, 
				'date_applied'    => dateNow(),
				'applicant_pitch' => $applicant_pitch,
				'status'          => 'pending',
				'label'           => 'pending',
				'resume_image'    => $resumeImage,
				'resume_text'     => $resumeText,
			]);

			$query = true;


			if($query)
			{
				$notificationParam = [
					'company_id' => $job['companyid'],
					'sender'  => $userid,
					'subject' => 'New Job Application',
					'message' => 'New Applicant for ' . $job['title'],
					'link'    => 'http://localhost/metrojobs/app/admin/application_view.php?id='.$db->insert_id
				];

				$result = notifyCompany($notificationParam);
				
				Flash::set('Application Sent , check your application and take the exam ' , 'success' , 'jobapplication');
				redirect('profile.php');
			}else
			{
				echo mysqli_error($db);
			}
		}
	}


	function updateApplicationStatus($applicationid , $status , $notes = null)
	{
		$db = DB::getInstance();

		$notes = filter_var($notes , FILTER_SANITIZE_STRING);

		$sql = "UPDATE job_applications set status = '$status' , notes = '$notes'
		where id = '$applicationid'";

		$query = $db->query($sql);

		if($query)
		{
			if($status == 'passed') {
				$status = 'endorsed';
			}

			$application = getApplication($applicationid);

			$link = "application_view.php?id={$applicationid}";

			createNotification("APPLICANT" , [
				'notification' => 'You job application status has been changed to '.$status,
				'link'  => $link
			] ,$application['userid']);

			Flash::set('Application status updated');

			return updateApplicationLabelStatus($applicationid , $status);
		}

		return false;
	}

	function updateApplicationStatusOnly($applicationid , $status)
	{
		$result = db_update('job_applications' , [
			'status' => $status
		] , " id = '$applicationid' ");

		$application = getApplication($applicationid);

		$link = "application_view.php?id={$applicationid}";

		createNotification("APPLICANT" , [
			'notification' => 'You job application status has been changed to '.$status,
			'link'  => $link
		] ,$application['userid']);

		return $result;
	}

	function updateApplicationLabel($applicationid , $label)
	{
		$db = DB::getInstance();

		$sql = "UPDATE job_applications set label = '$label'
		where id = '$applicationid'";
		$query = $db->query($sql);
		if($query)
		{
			Flash::set('Application label updated');
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}
	/*USER*/

	function userFilesCreate($files)
	{
		extract($files);

		$db = DB::getInstance();

		$userid = Session::get('user')['id'];

		//check if file is ok

		$file = new File();

		$file->setFile($_FILES['file'])
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('userfile');

		if($type == 'text'){
			//check if file is ok
			if(!in_array(strtolower($file->getExtension()) , ['docx','doc' ,'pdf','wpd','txt','odt'])){
				$errors [] = 'Text File type should be a text file ' . implode(',', ['docx','doc' ,'pdf','wpd','txt','odt']);
			}
		}

		if($type == 'picture'){
			//check if file is ok
			if(!in_array($file->getExtension(), ['jpeg' , 'jpg' ,'png'])){
				$errors [] = 'Picture file type should be a picture file';
			}
		}


		if(!empty($errors))
		{
			Flash::set(implode(',' , $errors) , 'danger');
			return;
		}else
		{
			$file->upload();

			if($file->getErrors())
			{
				Flash::set(implode(',' , $file->getErrors() ) ,  'danger');
			}else
			{
				$filename = $file->getFileUploadName();

				$sql = "INSERT INTO user_files(title , userid , type , filename)
				VALUES('$title' , '$userid' , '$type' , '$filename')";

				if($db->query($sql)){
					Flash::set('User file added');
				}else
				{
					Flash::set(mysqli_error($db) , 'danger');
				}
			}
		}

	}

	function generateLoginToken()
	{
		return [
			charGen(7),
			random_number(4)
		];
	}


	function register($userInformation)
	{
		extract($userInformation);

		$db = DB::getInstance();
		//error tracker
		$errors = 0;
		$error_names = array();
		try{
			$type   = 'Applicant';
			$status = 'active';

			list($username , $password) = generateLoginToken();

			//insert user infomration
			$sql = "INSERT INTO users(username , password , type , status)";
			$sql .= "VALUES('$username' , '$password' , '$type' , '$status')";

			$query = $db->query($sql);

			if($query)
			{
				//get userid
				$userid = insertId($db);
				//insert user informations
				$sql = "INSERT INTO user_informations(userid , firstname , lastname , gender ,
				birthday ,phone , email ,address , profile)";

				$sql .="VALUES('$userid' , '$firstname' , '$lastname' , '$gender' , '$birthday' ,
				'$phone', '$email' , '$address' , 'na')";

				$query = $db->query($sql);
				if($query){
					//insert applicant educations
					$sql = "INSERT INTO applicant_educations(userid,highest_attainment , year , school , status)";
					$sql .= "VALUES('$userid','$highest_attainment' , '$school_year' , '$school' , 'active')";

					$query = $db->query($sql);

					if($query)
					{
						//insert applicant skills
						$sql = "INSERT INTO applicant_skills(userid , category) VALUES";

						if(!empty($skills))
						{
							$counter = 0;
							foreach($skills as $key => $skill) {
								if($counter < $key)
								{
									$counter++; //wala dati to
									$sql .= ' , ';
								}
								$sql .="('$userid' , '$skill')";
							}

							$query = $db->query($sql);

							if($query){
								//inser work experiences
								$role_description = filter_var($role_description , FILTER_SANITIZE_STRING);


								if($jobexpi == 'n/a') {

									$sql = "INSERT INTO work_experiences(userid ,field, position , role_description ,
									date , year , status)";

									$sql .="VALUES('$userid' , 'n/a', 'n/a' ,'n/a' , 'n/a' , 'n/a',
									'inactive')";

									$query = $db->query($sql);

								}else{
									if($work_field== 'others'){
										$work_field = $work_field_other;

										createWorkField($work_field_other);
									}

									$sql = "INSERT INTO work_experiences(userid ,field, position , role_description ,
									date , year , status)";

									$sql .="VALUES('$userid' , '$work_field', '$position' ,'$role_description' , '$work_date' , '$work_year',
									'active')";

									$query = $db->query($sql);

									if($query)
									{

									}else{
										array_push($error_names, 'Error on experiences query ' . mysqli_error($db));
										$errors++;
									}
								}
							}else
							{
								array_push($error_names, 'Error on skills query ' . mysqli_error($db));
								$errors++;
							}
						}
					}else{
						array_push($error_names, 'Error on educations query ' . mysqli_error($db));
						$errors++;
					}

				}else{
					array_push($error_names, 'Error on user informations query ' . mysqli_error($db));
					$errors++;
				}
			}else
			{
					array_push($error_names, 'Error on users query ' . mysqli_error($db));

				$errors++;
			}

			if(!empty($error_names))
			{
				Flash::set(implode(',',$error_names) , 'danger');
			}else
			{
				$message = "Congratulations you are now registered to CAREERS-METROJOBS <br/> thsese are your logins <br/>
					<div> Username : {$username}</div> <div> Password : {$password}</div>";

				mailUserAuth($message, $email);

				Flash::set("Registration successfull! your logins credential has been sent to your email '{$email}'" , 'success' , 'registration');

				redirect('login.php');
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function createWorkExperience($workExperience)
	{
		extract($workExperience);
		
		$db = DB::getInstance();

		$hasError = false;
		
		foreach($workExperience as $key => $row)
		{
			if($row['createWorkExperience'])
				continue;

			if( empty($row) ){
				$hasError = true;
				break;
			}
		}	

		if($hasError){
			Flash::set("All fields are required" , 'warning');
			return false;
		}

		$userid = Session::get('user')['id'];

		$sql = "INSERT INTO work_experiences(userid ,field, position , role_description ,
		date , year , status)
		VALUES('$userid' , '$work_field', '$position' ,'$role_description' , '$work_date' , '$work_year',
		'active')";

		if($db->query($sql)) {
			Flash::set("Work Experience Added");
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function logout($url = null)
	{
		session_destroy();
		
		Flash::set('Account logged out');

		$url = URL.DS.'app/client/index.php';

		return redirect($url);
	}
	function login($authDetails)
	{
		extract($authDetails);

		$auth = new Authenticate();
		//this will do everything redirection and session settings
		$auth->doAction($username , $password , $type);
		//wont redirect if derror found
		
		if( !is_null($auth->getError() ))
		{
			Flash::set($auth->getError() , 'warning');
			return false;
		}else
		{
			return redirectLogin($auth);
		}
	}


	function redirectLogin($auth)
	{

		Flash::set("Welcome back");

		if( isEqual($auth->type , 'applicant') ) 
		{
			if( boolval($auth->doneSetup) == false) 
				return redirectRaw(URL_CLIENT.'/account_setup.php');
			return redirectRaw(URL_CLIENT.'/profile.php');
		}

		if( isEqual($auth->type , 'vendor') ) 
			return redirectRaw(URL_ADMIN.DS.'profile.php');


		if( isEqual($auth->type , 'company') )
			return redirectRaw(URL_CUSTOMER.DS.'profile.php');

		$type  = strtolower($type);
		return true;
	}

	/***//***//***//***/
	#######EXAMINATION######
	/***//***//***//***/


	function startExam($applicationid , $examid)
	{
		$application = getApplication($applicationid);
		//get job using application
		$job   = getJob($application['jobid']);
		//get job Exam using job
		// $jobExam = getJobExam($job['id'] , $examid);

		/*INSERT NEW EXAMINATION*/
		$userid = Session::get('user')['id'];
		$status = 'unfinish';
		$exam = getExam($examid);
		$exam_time = date('h:i:s');

		$db = DB::getInstance();

		$sql = "INSERT INTO application_examinations(applicationid , examid , userid , status , exam_time)
		VALUES('$applicationid' , '{$examid}' , '$userid'  , '$status' , '$exam_time')";

		if($db->query($sql)){
			$examinationid = insertId($db);

			$firstQuestion = getFirstQuestion($exam['id']);

			Flash::set('Exam Started');
			redirect("take_exam.php?examinationid={$examinationid}&qaid={$firstQuestion['id']}");
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function getFirstQuestion($examid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM exam_question_choices_answer where examid = '$examid' order by orderNumber asc limit 1";

		return fetchSingle($db->query($sql));

	}

	function submitAnswer($examinationid , $questionid , $answer)
	{

		$examination = getExamination($examinationid);

		$userId = Session::get('user')['id'];

		if(insertAnswer($examinationid, $questionid, $answer))
		{
			$question = getExamQA($questionid);

			$nextQuestion = getNextQuestion($question['examid'],$question['orderNumber']);

			// if has next question
			if($nextQuestion){
				Flash::set('Answer Submitted Next Question');
				return redirect("take_exam.php?examinationid={$examinationid}&qaid={$nextQuestion['id']}&applicationid={$examination['applicationid']}");
			}else
			{
				if(updateExamination($examinationid)){

					$result = new ExaminationResult($examinationid);

					$remarkAndScore = $result->getRemarks();

					$resultArray = [
						'examinationid' => $examinationid ,
						'correct'   => count($result->getCorrects()),
						'incorrect' => count($result->getInCorrects()),
						'score'     => $remarkAndScore['score'],
						'remarks'   => $remarkAndScore['remarks']
					];

					$resultid = insertExamResult($resultArray);

					$href = "examination_result.php?resultid={$resultid}";

					createNotification('APPLICANT' , [
						'notification' => 'An applicant has just finished taking exam.',
						'link'      =>  $href
					] , 0);

					createNotification('APPLICANT' , [
						'notification' => 'You have just finished taking exam.',
						'link'      =>  $href
					] , $userId);

					redirect("examination_result.php?resultid={$resultid}");
				}
			}
		}
	}

	function updateExamination($examinationid)
	{
		$db = DB::getInstance();
		$sql = "UPDATE application_examinations set status = 'finished' where id = '$examinationid'";

		$query = $db->query($sql);

		if($query)
			return true;
		return false;
	}

	function computeExaminationResult($examinationid)
	{
		$notes = 'sample notes';

		$sql = "INSERT INTO examination_results(examinationid , time_consumed , corrects , incorrects , result , notes)

		(SELECT '$examinationid' , ";
	}
	function getNextQuestion($examid , $previous)
	{
		$db = DB::getInstance();

		$lastOrderNumber = getLastQuestion($examid);

		if($lastOrderNumber == $previous)
		{
			return false;
		}else
		{
			$nextQuestionNumber = $previous + 1;

			$sql = "SELECT * FROM exam_question_choices_answer where orderNumber = '$nextQuestionNumber' and examid = '$examid'";

			return fetchSingle($db->query($sql));
		}
	}

	function getLastQuestion($examid)
	{
		$db = DB::getInstance();

		$sql = "SELECT orderNumber from exam_question_choices_answer where id = '$examid' order by orderNumber desc limit 1";

		$query = $db->query($sql);

		return fetchSingle($db->query($sql));
	}

	function insertAnswer($examinationid , $questionid , $answer)
	{
		$db = DB::getInstance();

		list( $textAnswer , $valueAnswer ) = unserialize(base64_decode($answer));

		$sql = "SELECT * FROM exam_question_choices_answer where id = '$questionid' and answer = '$valueAnswer'";

		$query = $db->query($sql);

		if(fetchSingle($query))
		{
			//if answer is correct fire this
			$sql = "INSERT INTO exam_answers(examinationid , questionid , answer , remarks)
			VALUES('$examinationid' , '$questionid' , '$textAnswer' ,'correct')";
		}else
		{
			$sql = "INSERT INTO exam_answers(examinationid , questionid , answer , remarks)
			VALUES('$examinationid' , '$questionid' , '$textAnswer' ,'incorrect')";
		}

		if($db->query($sql)){
			return true;
		}else
		{
			return false;
		}
	}
	#######
	/*require customers actions*/
// 	require_once 'customer/actions.php';

	function sendAppointment($applicantEmail , $applicantId , $senderId , $message , $applicantName = null , $appointmentId = null)
	{
		/*SUBJECT MESSAGE , RECIEVER */

		$href = 'appointment_view.php?id='.$appointmentId;
		// $link = 

		createNotification('APPLICANT', [
			'notification' => "You have an appointment",
			'link' => $href,
			'meta_id' => $applicantId,
		] , $applicantId);

		createNotification('APPLICANT', [
			'notification' => "You have an appointment",
			'link' => $href,
			'meta_id' => 0,
		] , $applicantId);

		return mailAppointmentSchedule($message , $applicantEmail , $applicantName);
		// return createNotification(SCHEDULE_APPOINTMENT , $message , $applicantId , $senderId);
	}

	function createNotification($META_KEY , $PARAMETERS = [] , $recieverId)
	{
		$db = DB::getInstance();

		return db_insert('notifications',[
			'meta_key'  => $META_KEY,
			'meta_id'  => $recieverId,
			'notification' => $PARAMETERS['notification'],
			'link'   => $PARAMETERS['link']
		]);
	}

	function saveNotification(array $values)
	{
		$db = DBH::getInstance();

		return $db->store($values , 'notifications');
	}


	function notifyCompany(array $values)
	{
		$db = DBH::getInstance();

		return $db->store($values , 'notifications_companies');
	}

	function createAppointment($appointmentInfo , $appointment_for = 'agency')
	{
		extract($appointmentInfo);

		$db = DB::getInstance();

		$user = '';

		if(Session::check('user')) {
			$user = Session::get('user');
		}else
		{
			$user = Session::get('company');
		}

		$appointment      = getApplication($applicationid);
		$job              = getJob($appointment['jobid']);
		$applicant        = getUser($appointment['userid']);

		$subject          = SCHEDULE_APPOINTMENT;

		$furtherMore = empty($notes) ? '': "Notes: {$notes}";


		$message = " <p> You have an scheduled appointment for </p> ";

		$message .= " <ul> 
			<li> Company :  {$job['comp_name']} </li>
			<li> Job Position : {$job['title']} </li>
			<li> When : {$date} {$time} </li>
			<li> Job Position : {$job['title']} </li>
			<li> At : {$address}</li>
		</ul>";

		$message .= "<p> {$furtherMore} </p>";

		$sql = "INSERT INTO applicant_appointments (applicationid, appointment_for , jobid,userid,dateset,timeset,subject,message,reciever,status)
		VALUES('$applicationid' , '$appointment_for','{$job['id']}' ,'{$user['id']}','$date' , '$time' , '$subject' , '$message',
		'{$applicant['id']}','pending')";

		$appointmentid  = db_insert('applicant_appointments' , [
			'applicationid'   => $applicationid, 
			'appointment_for' => $appointment_for,
			'jobid'           => $job['id'],
			'userid'          => $user['id'],
			'dateset'         => $date,
			'timeset'         => $time,
			'subject'         => $subject,
			'message'         => $message,
			'reciever'        => $applicant['id'],
			'status'          => 'pending'
		]);

		if($appointmentid)
		{
			sendAppointment($applicant['email']  , $applicant['id'] , $user['id'] , $message , $applicant['fullname']);

			Flash::set('Application sent!' , 'application');

			return $appointmentid;
		}else
		{
			Flash::set(mysqli_error($db) , 'warning');
			return false;
		}
	}

	function updateAppointment($rescheduleInfo)
	{
		extract($rescheduleInfo);

		$appointment      = getAppointment($appointmentid);

		$job              = getJob($appointment['jobid']);

		$applicant        = getUser($appointment['userid']);

		$user = '';

		if(Session::check('user')) {
			$user = Session::get('user');
		}else{
			$user = Session::get('company');
		}

		$db = DB::getInstance();

		$subject = filter_var($subject , FILTER_SANITIZE_STRING);
		$message = filter_var($message , FILTER_SANITIZE_STRING);

		$query = db_update('applicant_appointments' , [
			'dateset' => $date,
			'timeset' => $time,
			'subject' => $subject,
			'message' => $message
		] , " id = '{$appointmentid}' ");

		if($query)
		{
			$message = "You have been rescheduled appointment for {$job['comp_name']} {$job['title']} position. on {$date} {$time}";
			$message = filter_var($message , FILTER_SANITIZE_STRING);

			Flash::set('Appointment Updated');

			return sendAppointment($reciever, $applicant['id'], $user['id'], $message , $applicant['fullname']);
		}else
		{
			Flash::set(mysqli_error($db) , 'warning');
			return false;
		}
	}

	function applicationToFinish($application)
	{
		extract($application);
		$db = DB::getInstance();
		//remarks
		$sql = "UPDATE applicant_appointments
		set status = 'finished' , remarks = '$remarks'
		where id = '$appointmentid'";

		$query = $db->query($sql);
		if($query)
		{

			$appointment = getAppointment($appointmentid);

			if($remarks != 'passed'){

				$remarks = 'failed';
			}
			else{
				$remarks = 'completed';
			}
			updateApplicationLabelStatus($appointment['applicationid'], $remarks);

			Flash::set('Appointment set to finished');
		}else
		{
			Flash::set(mysqli_error($db) , 'warning');
		}
	}
	function addEmployee($employee)
	{
		extract($employee);

		$db = DB::getInstance();

		$empcode = createdEmployeeCode($companyid);

		//check if user id currently employed

		$isEmployed = isEmployed($userid);

		if($isEmployed) {
			Flash::set("Applicant is currently employed , adding to employees failed" , 'danger');
			return false;
		}
		
		$employeeID = db_insert('employees' , [
			'companyid' => $companyid,
			'empcode'   => $empcode,
			'userid'    => $userid, 
			'date_started' => $date_started, 
			'job_title' => $job_title, 
			'position'  => $position, 
			'salary'    => $salary, 
			'salary_type' => $salary_type,
			'status' => 'active'
		]);

		if($employeeID)
		{
			if(isset($appointmentid))
			{
				db_update('applicant_appointments' , [
					'remarks' => 'passed' , 'appointmentid' => $appointmentid
				] , " id = '{$appointmentid}' ");
			}

			updateApplicationStatus($applicationid , 'finished');
			updateApplicationLabelStatus($applicationid , 'complete');

			createNotification("APPLICANT" , [
				'notification' => "You are now an employee!"
			] ,$userid);

			return $employeeID;
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}


	function evaluateEmployee($evaluation)
	{
		extract($evaluation);

		$db = DB::getInstance();

		$notes = filter_var($notes , FILTER_SANITIZE_STRING);


		$evalExists = evaluationExists($start_date , $end_date , $criteria , $empid);


		if($evalExists)
		{
			Flash::set("Evaluation already exists");
			return;
		}

		$status = 'active';

		$sql = "INSERT INTO employee_evaluations(date_start , date_end , companyid , empid , criteria , remarks , notes , status)
		VALUES('$start_date' , '$end_date' , '$companyid' , '$empid' , '$criteria' , '$remarks' , '$notes' , '$status')";


		$query = $db->query($sql);

		if($query)
		{
			Flash::set('Employee Evaluated');
		}else
		{
			Flash::set(mysqli_error($db) , 'warning');
		}
	}

	function evaluationExists($date_start , $date_end , $criteria , $empid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employee_evaluations where date_start = '$date_start' and date_end = '$date_end'
		and empid = '$empid' and  criteria  = '$criteria' ";

		$res  = fetchAll($db->query($sql));

		if(!empty($res))
			return true;
		return false;
	}

	function removeEvaluation($evalid)
	{
		$db = DB::getInstance();

		$sql = "DELETE from employee_evaluations where id = '$evalid'";

		Flash::set('Evaluation Removed');
		return $db->query($sql) ? true : false;
	}

	function updatePermit($companyid , $image)
	{
		$file = new File();

		$file->setFile($image)
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('logo')
		->upload();

		if(!empty($file->getErrors()))
		{
			Flash::set('Permit file not uploaded' , 'danger');
		}else
		{
			$db = DB::getInstance();

			$permit = $file->getFileUploadName();

			$sql = "UPDATE companies set permit = '$permit' where id = '$companyid'";

			if($db->query($sql)){
				Flash::set('Company permit updated');
			}else{
				Flash::set(mysqli_error($db) , 'danger');
			}
		}
	}

	function updateContract($companyid , $image){
		$file = new File();

		$file->setFile($image)
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('logo')
		->upload();

		if(!empty($file->getErrors()))
		{
			Flash::set($file->getErrors() , 'danger');
		}else
		{
			$db = DB::getInstance();

			$contract = $file->getFileUploadName();

			$sql = "UPDATE companies set contract = '$contract' where id = '$companyid'";

			if($db->query($sql)){
				Flash::set('Contract permit updated');
			}else{
				Flash::set(mysqli_error($db) , 'danger');
			}
		}
	}
	function updateCompany($company)
	{
		extract($company);

		$db = DB::getInstance();
		$company = Session::get('company');

		if($company['password'] != $password){
			Flash::set("Password verification does not match your current passsword , changes did not applied" , 'danger');
			return;
		}

		$description = filter_var($description , FILTER_SANITIZE_STRING);

		$sql = "UPDATE companies set name='$name', description = '$description',
		email = '$email' , phone = '$phone' where id = '$companyid'";

		if(!$query = $db->query($sql))
		{
			Flash::set(mysqli_error($db) , 'danger');
		}else{
			Flash::set('Company general details updated!');
		}
	}
	/*including contacts*/
	function updateGeneral($genInfo)
	{

		$userPassword = Session::get('user')['password'];

		extract($genInfo);

		$db = DB::getInstance();

		// if($userPassword != $password) {
		// 	Flash::set("Cannot update Password does not match" , "danger");
		// }

		$description = filter_var($description , FILTER_SANITIZE_STRING);

		$sql = "UPDATE companies set name='$name', description = '$description',
		email = '$email' , phone = '$phone' , contact_person = '$contact_person' ,
		contact_number = '$contact_number'

		where id = '$companyid'";

		if(!$query = $db->query($sql))
		{
			Flash::set(mysqli_error($db) , 'danger');
		}else{
			Flash::set('Company general details updated!');
		}
	}
	function updateCompanyUsername($companyid , $username)
	{
		$username = str_replace(" ", "", $username);
		if(!isCompanyUsernameExists($username)){
			$db = DB::getInstance();
			$sql = "UPDATE companies set username = '$username' where id = '$companyid'";

			if(!$query = $db->query($sql))
			{
				Flash::set(mysqli_error($db) , 'danger');
			}else{
				Flash::set('Username Updated');
			}
		}else
		{
			Flash::set('Username already exists' , 'danger');
		}

	}

	function isCompanyUsernameExists($username)
	{
		$db = DB::getInstance();

		$sql = "SELECT username from companies where username = '$username'";

		if(!empty(fetchSingle($db->query($sql)))){
			return true;
		}else{
			return false;
		}
	}

	function updateCompanyPassword($companyid , $password , $new_password = null)
	{
		/*THIS MEAANS USER IS THE ADMIN*/
		if($new_password == null)
		{
			$db = DB::getInstance();
			$sql = "UPDATE companies set password = '$password' where id = '$companyid'";

			if(!$query = $db->query($sql))
			{
				Flash::set(mysqli_error($db) , 'danger');
			}else{
				Flash::set('Username Updated');
			}

		}else{
			$company = Session::get('company');

			if($company['password'] == $new_password){
				Flash::set("Pick a new password" , "danger");
				return;
			}

			if($company['password'] != $password)
			{
				Flash::set("Incorrect password confirmation" , "danger") ;
				return;
			}

			$db = DB::getInstance();
			$sql = "UPDATE companies set password = '$new_password' where id = '$companyid'";

			if(!$query = $db->query($sql))
			{
				Flash::set(mysqli_error($db) , 'danger');
			}else{

				$company['password'] = $new_password;

				Session::set('company' , $company);
				Flash::set('Username Updated');
			}
		}
		
	}

	function updateCompanyContact($contact)
	{
		extract($contact);

		$db = DB::getInstance();

		$sql = "UPDATE companies
			set contact_person = '$contact_person' , contact_number = '$contact_number'
			where id = '$companyid' ";
		if(!$query = $db->query($sql))
		{
			Flash::set(mysqli_error($db) , 'danger');
		}else{
			Flash::set('Company Contact Updated');
		}
	}
	function updateLogo($companyid , $files = null)
	{
		$db = DB::getInstance();

		$file = new File();

		$file->setFile($files)
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('logo')
		->upload();

		if(!empty($file->getErrors()))
		{
			Flash::set(implode(',' , $file->getErrors()) , 'danger');
		}else{
			$logoName = $file->getFileUploadName();

			$sql = "UPDATE companies set logo = '$logoName' where id = '$companyid'";

			if(!$query = $db->query($sql)){
				Flash::set(mysqli_error($db) , 'danger');
			}else{
				Flash::set('Logo updated!');
			}
		}
	}

	function updateBanner($companyid , $files = null)
	{
		$db = DB::getInstance();

		$file = new File();

		$file->setFile($files)
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('logo')
		->upload();

		if(!empty($file->getErrors()))
		{
			Flash::set(implode(',' , $file->getErrors()) , 'danger');
		}else{
			$logoName = $file->getFileUploadName();

			$sql = "UPDATE companies set banner = '$logoName' where id = '$companyid'";

			if(!$query = $db->query($sql)){
				Flash::set(mysqli_error($db) , 'danger');
			}else{
				Flash::set('Banner updated!');
			}
		}
	}

	function uploadProfile($userid)
	{
		$db = DB::getInstance();

		$file = new File();

		$file->setFile($_FILES['profile'])
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('profile')
		->upload();

		if(!empty($file->getErrors()))
		{
			Flash::set(implode(',' , $file->getErrors()) , 'warning');
		}else
		{
			$profileName = $file->getFileUploadName();

			$sql = "UPDATE user_informations set profile = '$profileName' where userid = '$userid'";

			$query = $db->query($sql);

			if($query)
			{
				Flash::set('Uploaded');
				return true;
			}else{
				Flash::set('Something went wrong!' , 'danger');
				return false;
			}
		}
	}


	/*examination*/


	function examCreate($examInfo)
	{
		extract($examInfo);

		$db = DB::getInstance();

		$sql = "INSERT INTO exams(name,description,duration)
		VALUES('$name' , '$desc' , '$duration')";

		if($db->query($sql))
		{

			Flash::set("Exam {$name} has been created" , 'success' , 'examcreate');

			$examid = insertId($db);

			redirect('exam_qa_create.php?id='.$examid);
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function examQCACreate($info)
	{
		$table_name = 'exam_question_choices_answer';

		extract($info);

		$question_img = fileUploader($_FILES['question_img']);
		$image_1 = fileUploader($_FILES['image_1']);
		$image_2 = fileUploader($_FILES['image_2']);
		$image_3 = fileUploader($_FILES['image_3']);
		$image_4 = fileUploader($_FILES['image_4']);


		$orderNumber = examGetLastQuestion($examid);

		if($orderNumber == 0) {
			$orderNumber = 1;
		}

		if(examQCACExists($examid , $question))
		{
			Flash::set('Question Already exists' , 'danger');
			FormSave();
			return;
		}

		$db = DB::getInstance();

		$sql = "INSERT INTO $table_name(examid , question, question_img , choice_1,choice_2,choice_3,choice_4,
		image_1 , image_2 , image_3 , image_4 , answer,orderNumber) 

		VALUES('$examid' , '$question' , '$question_img',  '$choice_1' , '$choice_2' ,'$choice_3' ,'$choice_4',
		'$image_1' , '$image_2' , '$image_3' , '$image_4' , '$answer' ,'$orderNumber')";

		$result = db_insert($table_name , [
			'examid'       => $examid,
			'question'     => $question,
			'question_img' => $question_img,
			'choice_1'     => $choice_1,
			'choice_2'     => $choice_2,
			'choice_3'     => $choice_3,
			'choice_4'     => $choice_4,
			'image_1'      => $image_1,
			'image_2'      => $image_2,
			'image_3'      => $image_3,
			'image_4'      => $image_4,
			'answer'       => $answer,
			'orderNumber'  =>  $orderNumber
		]);

		if($result) {
			Flash::set(' Q and A added');
			return true;
		}else{
			return false;
		}
	}

	function fileUploader($passFile)
	{
		$file = new File();

		$file->setFile($passFile)
		->setPrefix('logo')
		->setDIR(BASEROOT.DS.'public/assets/')
		->upload();


		if(!empty($file->getErrors())){
			return '';
		}else{
			return $file->getFileUploadName();
		}
	}

	function examQCACExists($examid , $question)
	{
		$table_name = 'exam_question_choices_answer';
		$db = DB::getInstance();

		$sql = "SELECT * FROM $table_name where question = '$question' and examid = '$examid'";

		$query = $db->query($sql);

		if($query->num_rows)
			return true;
		return false;
	}

	/*PASS PREVIOUS ORDERNUMBER GET TO BE SWITCHED ID , GET TO SWTICHG*/
	function updateOrderNumber($oldOrder, $toBeSwitchedId , $toSwitchId)
	{
		$db = DB::getInstance();
		$table_name = 'exam_question_choices_answer';


		$sql1 = "UPDATE $table_name set orderNumber = (SELECT orderNumber from $table_name where id = '$toSwitchId')
		where id = '$toBeSwitchedId'";


		$sql2 = "UPDATE $table_name set orderNumber = '$oldOrder' where id = '$toSwitchId'";

		if($db->query($sql1) && $db->query($sql2))
		{
			Flash::set('Question switched' , 'success');
		}
	}
	function examQCAUpdate($info)
	{
		$table_name = 'exam_question_choices_answer';

		// filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		extract($info);

		$db = DB::getInstance();


		$question = filter_var($question , FILTER_SANITIZE_STRING);

		$update = db_update($table_name , [
			'question' => $question,
			'choice_1' => $choice_1,
			'choice_2' => $choice_2,
			'choice_3' => $choice_3,
			'choice_4' => $choice_4,
			'answer'   => $answer
		] , " id = '{$examqaid}' ");

		if($update) {
			Flash::set('Question and Answer Updated');
			return true;
		}else{
			return false;
		}
	}

	function examQCImageUpdate($examqaid , $field , $fileUpload)
	{
		$table_name = 'exam_question_choices_answer';

		$db = DB::getInstance();

		$file = new File();
		$file->setFile($fileUpload)
		->setDIR(BASEROOT.DS.'public/assets/')
		->setPrefix('qaimg')
		->upload();

		if(empty($file->getErrors())){

			$imageName = $file->getFileUploadName();

			$sql = "UPDATE $table_name set $field = '$imageName'
			where id = '$examqaid'";

			if($query = $db->query($sql)){
				Flash::set('Image Updated');
			}else
			{
				Flash::set(mysqli_error($db) , 'danager');
			}
		}else
		{
			$sql = "UPDATE $table_name set $field = ''
			where id = '$examqaid'";

			if($query = $db->query($sql)){
				Flash::set('Image Updated');
			}else
			{
				Flash::set(mysqli_error($db) , 'danager');
			}
		}

	}

	function examGetLastQuestion($examid)
	{
		$table_name = 'exam_question_choices_answer';
		$db = DB::getInstance();

		$sql = "SELECT (ifnull(ordernumber , 0) + 1) as ordernumber from $table_name eqca
		where examid = '$examid' order by id desc limit 1";

		$query = $db->query($sql);

		$res = fetchSingle($query);

		if($res)
			return $res['ordernumber'];
		return 0;
	}


	function examJobAttach($jobid , $examid , $examNumber = 1)
	{
		$db = DB::getInstance();

		$sql = "INSERT INTO jobs_exam(jobid , examid , examnumber)
		VALUES('$jobid' , '$examid' , '$examNumber')";

		if($db->query($sql))
		{
			Flash::set('Job Exam Attached');
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}


	function removeJobExam($jobExamId)
	{
		$db = DB::getInstance();

		$sql = "DELETE FROM jobs_exam where id = '$jobExamId'";


		if($db->query($sql)){
			Flash::set('Job exam removed');
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}
	/*REPORT*/


	function reportGenerateApplicants($report)
	{

		extract($report);

		$db = DB::getInstance();

		if($type == 'accepted')
		{
			$sql = "SELECT CONCAT(firstname , ' ' , lastname) as name ,
			ui.phone as mobile , ui.email as email , concat(jobs.title) as jobname , comp.name as companyname ,
			ja.date_applied as date , ja.label as label , ja.status as status, status_label

			from job_applications as ja
			left join jobs
			on ja.jobid = jobs.id

			left join user_informations as ui
			on ui.userid = ja.userid

			left join companies as comp
			on comp.id = jobs.companyid


			where ja.date_applied
			between CAST('$start' as DATE) and CAST('$end' as DATE) and
			ja.status_label != 'pending'
			order by comp.name asc";
		}else
		{
			$sql = "SELECT CONCAT(firstname , ' ' , lastname) as name ,
			ui.phone as mobile , ui.email as email , concat(jobs.title) as jobname , comp.name as companyname ,
			ja.date_applied as date , ja.label as label , status_label

			from job_applications as ja
			left join jobs
			on ja.jobid = jobs.id

			left join user_informations as ui
			on ui.userid = ja.userid

			left join companies as comp
			on comp.id = jobs.companyid


			where ja.date_applied between CAST('$start' as DATE) and CAST('$end' as DATE)
			order by comp.name asc";
		}



		$query = $db->query($sql);

		return fetchAll($query);
	}


	/*MAILERS*/
	function mailAppointmentSchedule($message , $reciever , $applicantName = null){

		$mailer  = MailMakerNative::getInstance();

		$body = mailTemplate($message , $applicantName);

		$mailer->setSubject(SCHEDULE_APPOINTMENT)
		->setBody($body)
		->setReciever($reciever)
		->useHTMLHeader();

		try{
			$mailer->send();
		}catch(Exception $e)
		{
			die(var_dump($e->getMessage()));
		}

	}


	function mailUserAuth($message , $reciever)
	{
		$mailer  = MailMakerNative::getInstance();

		$body = mailTemplate($message);

		$mailer->setSubject(SCHEDULE_APPOINTMENT)
		->setBody($body)
		->setReciever($reciever)
		->useHTMLHeader();

		try{
			$mailer->send();
		}catch(Exception $e)
		{
			die(var_dump($e->getMessage()));
		}
	}



	/*search*/


	function searchJobKeyword($keyword)
	{
		$db = DB::getInstance();
		$keyword = filter_var($keyword , FILTER_SANITIZE_STRING);

		if(isKeywordTag($keyword))
		{
			//get all jobs
			$joblist = getJobList();
			$hastag = substr($keyword, 1);

			$jobHasTag = array();

			foreach($joblist as $job) {

				$jobTags = explode( ',', strtolower($job['categories']));

				if(in_array(strtolower($hastag) ,  $jobTags)){
					array_push($jobHasTag, $job['id']);
				}
			}

			if(!empty($jobHasTag))
				return 	getJobList(" WHERE jobs.id in (".implode(',' , $jobHasTag).") and jobs.status = 'posted'");
			return 0;
		}else{
			$sql = "SELECT jobs.* ,
			companies.name as comp_name , logo FROM jobs

			LEFT JOIN companies on
			jobs.companyid = companies.id

			where 
			title like '%$keyword%' or

			sub_title like '%$keyword%' or

			position like '%$keyword%' or

			companies.name like '%$keyword%' or

			categories like '%$keyword%' and jobs.status = 'posted'";

			Flash::set("Filter applied keyword '{$keyword}'");
			return fetchAll($db->query($sql));
		}
	}

	function isKeywordTag($keyword){
		if(substr($keyword , 0 , 1) == '#')
			return true;
		return false;
	}


	function jobAdvanceSearch($params)
	{

		$keysToSearch = array();

		if(empty($params))
		{
			Flash::set('No Result found,');

			return array();
		}
		else
		{

			foreach($params as $key => $param)
			{
				if(!empty($param) && $key != 'advancesearch')
				{
					$keysToSearch[$key] =$param;
				}
			}

			Flash::set("Filtering on " . implode(',' , array_keys($params)));
			if(!empty($keysToSearch))
			{

				$sql = "SELECT jobs.* , companies.logo,
				companies.name as comp_name
				FROM jobs

				LEFT JOIN companies on
				jobs.companyid = companies.id ";

				$counter = 0;

				foreach($keysToSearch as $key => $value)
				{

					$counter++;
					if($counter > 1) {
						$sql .= " or jobs.{$key} = '{$value}'";
					}else
					{
						$sql .= " WHERE jobs.{$key} = '{$value}'";
					}
				}
				$sql .= " and jobs.status = 'posted'";

				$db = DB::getInstance();

				$query = $db->query($sql);

				// die(mysqli_error($db));

				return fetchAll($query);
			}else{
				return 0;
			}
		}

	}

	function hasApplied($userid , $jobid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM job_applications where userid  = '$userid' and jobid= '$jobid'";

		$query = $db->query($sql);

		return fetchSingle($query);
	}


	/*UPDATE PROFILE*/

	function updateUserPhone($phone)
	{
		$db = DB::getInstance();

		$user = Session::get('user');

		$sql = "UPDATE user_informations set phone = '$phone' where id = '{$user['id']}'";

		$query = $db->query($sql);

		if($query){
			Flash::set('Updated!');
		}else
		{
			Flash::set(mysqli_error($db));
		}
	}

	function updateUserPassword($password)
	{
		$db = DB::getInstance();

		$userid = Session::get('user')['id'];
		if(strlen($password) < 4){
			Flash::set('Password must contain atleast 4 characters' , 'danger');
			return;
		}
		else
		{
			$sql = "UPDATE users set password = '$password' where id = '$userid'";
			if($db->query($sql)){
				Flash::set('User password Updated');
				return true;
			}else
			{
				Flash::set(mysqli_error($db));
			}
		}
	}

	function updateUsername($username)
	{
		$userid = Session::get('user')['id'];
		$db = DB::getInstance();

		if(strlen($username) < 5) {

			Flash::set('Username must contain atleast 5 characters' , 'danger');
		}
		else{
			$sql = "UPDATE users set username = '$username' where id = '$userid'";
			if($db->query($sql))
			{

				authUpdate([
					'username' => $username
				]);

				Flash::set('User username Updated');
				return true;
			}else
			{
				Flash::set(mysqli_error($db));
			}
		}
	}


	function updateUserEmail($email)
	{
		$db = DB::getInstance();

		$user = Session::get('user');

		$sql = "UPDATE user_informations set email = '$email' where id = '{$user['id']}'";

		$query = $db->query($sql);

		if($query){
			Flash::set('Updated!');
		}else
		{
			Flash::set(mysqli_error($db));
		}
	}

	function updateUserAddress($address)
	{
		$db = DB::getInstance();

		$user = Session::get('user');

		$sql = "UPDATE user_informations set address = '$address' where id = '{$user['id']}'";

		$query = $db->query($sql);

		if($query){
			Flash::set('Updated!');
		}else
		{
			Flash::set(mysqli_error($db));
		}
	}


	function updateEducation($education)
	{
		extract($education);
		$db = DB::getInstance();

		$user = Session::get('user');

		$sql = "UPDATE applicant_educations set highest_attainment = '$highest_attainment' ,
		year = '$school_year' , school = '$school' where userid = '{$user['id']}'";

		if($db->query($sql)){
			Flash::set('Edu updated');
		}else{
			Flash::set('Something went wrong');
		}
	}

	function updateUserSkills($skills)
	{
		$userid = Session::get('user')['id'];
		$db = DB::getInstance();

		if(!empty($skills))
		{
			removeSkills();

			$counter = 0;
			$sql = "INSERT INTO applicant_skills(userid , category) VALUES";

			foreach($skills as $key => $skill) {
				if($counter < $key)
				{
					$sql .= ' , ';
				}
				$sql .="('$userid' , '$skill')";
			}

			if($query = $db->query($sql)){
				Flash::set('skills updated');
			}
		}
	}

	function removeSkills()
	{
		$db = DB::getInstance();

		$userid = Session::get('user')['id'];

		$sql = "DELETE FROM applicant_skills where userid = '$userid'";

		if($db->query($sql))
			return true;
		return false;
	}


	function createNewSkill($category , $description)
	{
		$db = DB::getInstance();

		$sql = "INSERT INTO job_categories(category , description)
		VALUES('$category' , '$description')";

		if($db->query($sql)){

			$user = Session::get('user');

			$categoryid = insertId($db);

			$sql = "INSERT INTO applicant_skills(userid , category)
			VALUES('{$user['id']}' , '$categoryid')";

			if($db->query($sql)){
				Flash::set('New Skill Added');
			}else
			{
				Flash::set('Something went wrong');
			}
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function updateWorkHistory($work)
	{
		extract($work);
		
		$userid = Session::get('user')['id'];

		$db = DB::getInstance();

		$sql = "UPDATE work_experiences set field = '$field' ,
		position = '$position' , role_description = '$role_description' ,
		date = '$date' , year = '$year'
		where id = '$workid'";

		if($db->query($sql)){
			Flash::set('Work experiences updated.');
		}else{
			Flash::set(mysqli_error($db) , 'warning');
		}


	}


	function createBusinessNature($nature)
	{
		$db = DB::getInstance();
		$sql = "INSERT INTO business_natures(nature) VALUES('$nature')";

		if($db->query($sql)){
			Flash::set('business added');
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
			return false;
		}
	}

	function createJobPosition($position)
	{
		$db = DB::getInstance();
		$sql = "INSERT INTO job_positions(position) VALUES('$position')";

		if($db->query($sql)){
			Flash::set('position added');
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
			return false;
		}
	}


	function createEvaluation($evaluationList)
	{

		$db = DB::getInstance();

		$others = unsealInput($evaluationList['others']);

		// die(var_dump($others));

		list($qualWork , $qualWorkScore) = unsealInput($evaluationList['qualOfWork']);
		$qualOfWorkComment = $evaluationList['qualOfWorkComment'];

		list($initiative , $initiativeScore) = unsealInput($evaluationList['initiative']);
		$initiativeComment = $evaluationList['initiativeComment'];

		list($adapCoop , $adapCoopScore) = unsealInput($evaluationList['adapAndCoop']);
		$adapAndCoopComment = $evaluationList['adapAndCoopComment'];

		list($constConsious , $constConsiousScore) = unsealInput($evaluationList['constConsious']);
		$constConsiousComment = $evaluationList['constConsiousComment'];

		list($attendanceAndFunctionality , $attendanceAndFunctionalityScore) = unsealInput($evaluationList['attendanceAndFunctionality']);
		$attendanceAndFunctionalityComment = $evaluationList['attendanceAndFunctionalityComment'];

		$sql = "INSERT INTO employee_evaluations
		(season , companyid , empid , criteria , remarks , notes) VALUES";

		$sql .= "('{$others['season']}' , '{$others['companyid']}' , '{$others['empid']}' ,
		'{$qualWork}' , '{$qualWorkScore}' , '{$qualOfWorkComment}') , ";

		$sql .= "('{$others['season']}' , '{$others['companyid']}' , '{$others['empid']}' ,
		'{$initiative}' , '{$initiativeScore}' , '{$initiativeComment}') ,";

		$sql .= "('{$others['season']}' , '{$others['companyid']}' , '{$others['empid']}' ,
		'{$adapCoop}' , '{$adapCoopScore}' , '{$adapAndCoopComment}') ,";

		$sql .= "('{$others['season']}' , '{$others['companyid']}' , '{$others['empid']}' ,
		'{$constConsious}' , '{$constConsiousScore}' , '{$constConsiousComment}') , ";

		$sql .= "('{$others['season']}' , '{$others['companyid']}' , '{$others['empid']}' ,
		'{$attendanceAndFunctionality}' , '{$attendanceAndFunctionalityScore}' , '{$attendanceAndFunctionalityComment}')";

		if($db->query($sql)){
			Flash::set('Evaluation has been posted');

			redirect("employee_view.php?empid={$others['empid']}");
		}else{
			echo die(mysqli_error($db));
		}

	}

	function applyTermination($termination)
	{
		$db = DB::getInstance();

		extract($termination);



		if($reason == 'others')
		{
			if(empty($reason_other)){
				Flash::set("Reason cannot be empty" , 'danger');
				return;
			}
			$reason = filter_var($reason_other , FILTER_SANITIZE_STRING);
		}

		$sql = "UPDATE employees set status = 'inactive' , notes = '$reason'
		where id = '$empid'";

		if($db->query($sql)){
			Flash::set('Employee termination succeeded');
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}


	function createWorkField($workField)
	{
		$db = DB::getInstance();

		$sql = "INSERT INTO job_field_list(field) values('$workField')";

		if($db->query($sql)){
			return true;
		}
		return false;
	}

	function updateApplicationLabelStatus($applicationid , $status){

		$db = DB::getInstance();

		$sql = "UPDATE job_applications  set status_label = '$status' where id = '$applicationid' ";

		$query = $db->query($sql);

		if($query){
			Flash::set("Job application updated");
			return true;
		}else{
			Flash::set("Error", 'danger');
			return false;
		}
	}

	function empRegularization($empid){

		$db = DB::getInstance();

		$sql = "UPDATE employees set emp_type = 'regular' where id = '$empid'";

		if($db->query($sql)){
			Flash::set("Employee has been set to regular employee");
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}


	function  insertExamResult($result)
	{
		$db = DB::getInstance();

		extract($result);

		$sql = "INSERT INTO exam_results(examinationid , correct , incorrect , score , remarks)
		VALUES('$examinationid' , '$correct' , '$incorrect' , '$score' , '$remarks')";

		$query = $db->query($sql);

		if($query){
			Flash::set("Exam result has been inserted");

			return insertId($db);

		}else{
			Flash::set(mysqli_error($db) , 'danger');

			return 0;
		}
	}

	function createEduCategory($name)
	{
		$db = DB::getInstance();

		$sql = "INSERT INTO education_categories(category)
		VALUES('$name')";

		if($db->query($sql)){
			Flash::set("Category Created");
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
			return false;
		}
	}

	function addEducation($eduInfo)
	{
		$db = DB::getInstance();

		$userid = Session::get('user')['id'];
		extract($eduInfo);
		$description = filter_var($description , FILTER_SANITIZE_STRING);


		if(isset($eduInfo['others']))
		{
			$category = $other_category;
			$addCategory = createEduCategory($other_category);

			if(!$addCategory) {
				return false;
			}
		}


		$sql = "INSERT INTO applicant_other_educations(userid , category , school , month , year , course , description)
		VALUES('$userid' , '$category' , '$school' , '$month' , '$year' , '$course' , '$description')";

		if($db->query($sql)){
			Flash::set("Education Added");
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function updateOtherEducation($eduInfo)
	{
		$db = DB::getInstance();

		$userid = Session::get('user')['id'];

		extract($eduInfo);
		
		if(empty($other_category) && empty($category))
		{
			Flash::set("Category must not be empty" , 'danger');
			return false;
		}
		

		$description = filter_var($description , FILTER_SANITIZE_STRING);

		if(isset($eduInfo['others']))
		{
			$category = $other_category;

			$addCategory = createEduCategory($other_category);

			if(!$addCategory) {
				return false;
			}
		}

		$sql = "UPDATE applicant_other_educations
		set userid = '$userid' , category = '$category' , school = '$school' , month = '$month' ,
		course = '$course' , description = '$description' where id = '$eduid'";

		if($db->query($sql)){
			Flash::set("Education Updated");
			return true;
		}else{
			Flash::set(mysqli_error($db) , 'danger');
		}
	}

	function updateWorkExperience($workInfo)
	{
		$db = DB::getInstance();

		if( empty($workInfo['field']) || empty($workInfo['position']) || empty($workInfo['role_description']))
		{
			Flash::set("All fields are required");
			return false;
		}
		return db_update('work_experiences' , [
			'field' => $workInfo['field'],
			'position' => $workInfo['position'],
			'role_description' => $workInfo['role_description'],
			'date' => $workInfo['date'],
			'year' => $workInfo['year']
		] , " id = '{$workInfo['workid']}' ");
	}


	function _mail($reciever , $subject , $body)
	{
		$mailer  = MailMakerNative::getInstance();

		$mailer->setSubject($subject)
		->setBody($body)
		->setReciever($reciever)
		->useHTMLHeader();

		try{
			$mailer->send();
		}catch(Exception $e)
		{
			die(var_dump($e->getMessage()));
		}
	}



	function account_update($fieldsAndValues , $id)
	{
		return db_update('users' , $fieldsAndValues , " id = '{$id}' ");
	}


	function account_info_update($fieldsAndValues , $id)
	{
		return db_update('user_informations' , $fieldsAndValues , " userid = '{$id}' ");
	}

	function registration_confirmation_udpate($fieldsAndValues , $id)
	{
		return db_update('registration_confirmation_tokens' , $fieldsAndValues , "id = '{$id}'");
	}