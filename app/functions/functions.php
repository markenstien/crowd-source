<?php
	####GLOBAL####
	function insertId($db)
	{
		return mysqli_insert_id($db);
	}

	function fetchAll($query)
	{
		$returnResult = array(); // array variable
		try{
			while($row = $query->fetch_assoc()) // use fetch_assoc here
			{
				$returnResult[] = $row; // assign each value to array
			}
		return $returnResult;	
		}catch(Exception $e) 
		{
			die(var_dump($e));
		}
	}

	function fetchSingle($query)
	{
		try{
			return mysqli_fetch_assoc($query);
		}catch(Exception $e) {
			die(var_dump($e));
		}
	}
	#########################


	function getNotifications($id = 0)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM notifications where meta_id = '{$id}' ";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function getJob($jobid)
	{
		$db = DB::getInstance();

		$sql = "SELECT jobs.* , companies.id as companyid , companies.name as comp_name

		FROM jobs
		left join companies
		on jobs.companyid = companies.id

		where jobs.id = '$jobid'";

		$query = $db->query($sql);

		return fetchSingle($query);
	}

	function getJobList($params = null)
	{
		$db = DB::getInstance();
		$sql = "SELECT jobs.* , companies.name as comp_name  , logo
		FROM jobs
		LEFT JOIN companies
		on jobs.companyid = companies.id
		$params";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function getRelatedJobList()
	{
		if(Session::check('user'))
		{
			$application = new Applicant(Session::get('user')['id']);

			$skills = $application->getSkills();

			if(!empty($skills))
			{
				$applicantSkills = array();

				foreach($skills as $skill) {
					$applicantSkills[] = $skill['category'];
				}

				$db = DB::getInstance();

				$sql = "SELECT job.* , companies.name as comp_name , logo
				FROM jobs as job

				LEFT JOIN companies
				on job.companyid = companies.id
				where job.categories REGEXP '".str_replace(',', '|', implode(',', $applicantSkills))."'
				";

				return fetchAll($db->query($sql));
			}
		}else
		{
			return '';
		}

	}


	function getCategory($categoryid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM job_categories where id  ='$categoryid'";

		return fetchSingle($db->query($sql));
	}


	function getCategoryList($params = null)
	{
		$db = DB::getInstance();
		$sql = "SELECT * FROM job_categories $params";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function getUnSelectedCategory($jobid)
	{
		$db  = DB::getInstance();

		$sql = "SELECT * FROM job_categories
				where id not in(SELECT categoryid from job_post_categories where jobid = 1)";

		return fetchAll($db->query($sql));
	}
	function getJobPostCategory($jobid)
	{
		$db = DB::getInstance();

		$sql = "SELECT jc.categoryid as id , cat.category as category , cat.description as description
		from job_post_categories as jc
		left join job_categories as cat
		on jc.categoryid = cat.id

		where jobid = '$jobid'";

		$query = $db->query($sql);

		return fetchAll($query);

	}


	function getUser($userid)
	{
		$db = DB::getInstance();

		$sql = "SELECT u.id as id ,  username , password , type , status , created_at ,
		firstname , lastname , CONCAT(firstname , ' ' , lastname) as fullname ,
		gender , birthday , phone , email , address , profile , done_setup

		FROM users as u

		left join user_informations as ui
		on u.id = ui.userid

		where u.id = '$userid'";

		return fetchSingle($db->query($sql));
	}

	function getUsers( $params = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT u.id as id ,  username , password , type , status , created_at ,
		firstname , lastname , CONCAT(firstname , ' ' , lastname) as fullname ,
		gender , birthday , phone , email , address , profile , done_setup

		FROM users as u

		left join user_informations as ui
		on u.id = ui.userid 

		{$params}
		";

		return fetchAll($db->query($sql));
	}


	function getUserLastId()
	{
		$db = DB::getInstance();

		$sql = "SELECT ifnull(max(id) , 0) as max_id FROM users";

		return fetchSingle($db->query($sql))['max_id'] ?? 0; 
	}

	function getUserApplications($userid)
	{
		$db = DB::getInstance();
		$sql = "SELECT job_applications.* , name as company_name , jobs.title as title
		FROM job_applications
		left join jobs on jobs.id = job_applications.jobid

		left join companies on jobs.companyid = companies.id

		where job_applications.userid = '$userid' order by job_applications.id desc";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function getUserFiles($userid , $type = 'picture')
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM user_files where userid = '$userid' and type = '$type'";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function getUserFile($fileId)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM user_files where id = '$fileId'";

		$query = $db->query($sql);

		return fetchSingle($query);
	}
	function getCompanyList($params = null)
	{
		$db = DB::getInstance();

		return fetchAll($db->query("SELECT * FROM companies $params"));
	}

	function getCompanyInfo($companyid)
	{
		$db = DB::getInstance();

		$query = $db->query("SELECT * FROM companies where id = '$companyid'");

		return fetchSingle($query);
	}


	function getApplicantList($params = null)
	{
		$db = DB::getInstance();

		$query = $db->query(
			"SELECT ui.userid as userid , concat(firstname , ' ' , lastname) as fullname ,
			comp.id as compid , comp.name as comp_name ,
			job.id as jobid, job.position as position ,
			ja.id as jaid , ja.date_applied as date , ja.status as status , ja.label as label ,
			status_label

			FROM job_applications as ja

			left join jobs as job on
			ja.jobid = job.id

			left join companies as comp on
			job.companyid = comp.id

			left join user_informations as ui
			on ja.userid = ui.userid
			$params"
		);

		return fetchAll($query);
	}

	function getApplication($applicationid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM job_applications where id = '$applicationid'";

		return fetchSingle($db->query($sql));
	}

	// function getApplicationExam($applicationid)
	// {
	// 	$userid = Session::get('user')['id'];

	// 	$db = DB::getInstance();

	// 	$sql = "SELECT * FROM application_examinations where applicationid = '$applicationid' and userid = '$userid'";

	// 	return fetchSingle($db->query($sql));
	// }

	function getJobApplicantAppointment($jaid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM applicant_appointments where applicationid = '$jaid'";

		return fetchSingle($db->query($sql));
	}

	function getJobApplicantAppointmentFinal($jaid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM applicant_appointments where applicationid = '$jaid' and appointment_for ='company'";

		return fetchSingle($db->query($sql));
	}
	/*SA EXAM*/
	function getExamByParam($param)
	{
		$db = DB::getInstance();

		$sql = "SELECT * from application_examinations $param";

		return fetchSingle($db->query($sql));
	}
	/*require customers actions*/
// 	require_once 'customer/functions.php';


	function getAppointmentList($params = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT aa.id as schedid , aa.dateset , aa.timeset , aa.status as status ,
		ui.userid as userid , concat( ui.firstname , ' ' , ui.lastname) as fullname ,
		job.title as job_title , job.position as job_position
		from applicant_appointments as aa

		left join jobs as job
		on aa.jobid = job.id

		left join job_applications as ja
		on ja.id = aa.applicationid

		left join user_informations as ui
		on aa.userid = ui.id
		$params ";

		return fetchAll($db->query($sql));
	}

	function getAppointment($appointmentid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM applicant_appointments where id = '$appointmentid'";

		return fetchSingle($db->query($sql));
	}
	/*EMPLOYEE SPECIFIC FUNCITONS*/

	function createdEmployeeCode($companyid)
	{
		$date = date('mY');
		$reference = random_number(3);
		return $companyid . '-' . $date . '-' . $reference. '-'. getEmployeeLastId()['lastid'] ?? 0;
	}

	function getEmployeeLastId()
	{
		$db   = DB::getInstance();
		$sql = "SELECT ifnull(max(id) , 0) as lastid from employees";

		return fetchSingle($db->query($sql));
	}


	function getEmployee($employeeid)
	{
		$db = DB::getInstance();


		$sql = "SELECT ui.userid as userid, ui.firstname as firstname ,
		ui.lastname as lastname , concat(ui.firstname  , ' ' , ui.lastname) as fullname ,
		emp.id as empid , emp.companyid as companyid , emp.empcode as empcode , emp_type,
		 emp.job_title as job_title , emp.position as job_position ,
		 emp.status as status , emp.notes as notes , employment_status ,
		emp.salary as salary , emp.salary_type as salary_type , date_started ,
		emp.status as emp_status , emp.id as empid

		from employees as emp
		left join user_informations as ui
		on ui.userid = emp.userid where emp.id = '$employeeid'";

		return fetchSingle($db->query($sql));
	}

	function getEmployees()
	{
		$db = DB::getInstance();


		$sql = "SELECT ui.userid as userid, ui.firstname as firstname ,
		ui.lastname as lastname , concat(ui.firstname  , ' ' , ui.lastname) as fullname ,
		emp.id as empid , emp.companyid as companyid , emp.empcode as empcode , emp_type,
		 emp.job_title as job_title , emp.position as job_position ,
		 emp.status as status , emp.notes as notes , employment_status ,
		emp.salary as salary , emp.salary_type as salary_type , date_started ,
		emp.status as emp_status , emp.id as empid

		from employees as emp
		left join user_informations as ui
		on ui.userid = emp.userid";

		return fetchAll($db->query($sql));
	}

	function getEmployeeByCode($empcode)
	{
		$sql = "SELECT * FROM employees where empcode = '$empcode'";
	}
	function getEmployeeByUserId($userid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employees where userid = '$userid'";

		return fetchSingle($db->query($sql));
	}
	function getEmployeeList($params = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT ui.firstname as firstname ,
		ui.lastname as lastname , concat(ui.firstname  , ' ' , ui.lastname) as fullname ,
		emp.empcode as empcode , emp.job_title as job_title , emp.position as job_position , emp_type,
		emp.salary as salary , emp.salary_type as salary_type ,
		emp.status as emp_status , emp.id as empid , emp.notes as empnote

		from employees as emp
		left join user_informations as ui
		on ui.userid = emp.userid  $params
		";

		return fetchAll($db->query($sql));
	}

	function getEmployeeEvaluations($empid , $params = null)
	{
		$db = DB::getInstance();

		if($params == null)
		{
			$sql = "SELECT * FROM employee_evaluations where empid = '$empid'";

			return fetchAll($db->query($sql));
		}else
		{
			$sql = "SELECT * FROM employee_evaluations $params";

			return fetchAll($db->query($sql));
		}
	}

	function getCompanyEvaluations($companyid)
	{
		$db = DB::getInstance();

		$query = $db->query(
			"SELECT * FROM employee_evaluations
				WHERE companyid = '$companyid'  "
		);

		$evaluations = fetchAll($query);
		$evals = [];
		
		foreach($evaluations as $key => $row) 
		{
			$row['employee'] = getEmployee($row['empid']);
			array_push($evals , $row);
			
		}
		return $evals;
	}

	function evaluationGroup( $empid , $season = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT season  , sum(remarks) as remarks , avg(remarks) as average
		from employee_evaluations
		where empid = '$empid' group by season";

		$query = $db->query($sql);

		return fetchAll($query);
	}

	function hasSchedule($applicationid)
	{
		$db = DB::getInstance();
		$sql = "SELECT id from applicant_appointments where applicationid = '$applicationid'";

		return fetchSingle($db->query($sql));
	}

	function getSchedule($applicationid)
	{
		$db = DB::getInstance();
		$sql = "SELECT * from applicant_appointments where applicationid = '$applicationid'";

		return fetchAll($db->query($sql));
	}


	function getEmpRanking()
	{
		$db = DB::getInstance();

		$sql = "SELECT concat(firstname , ' ' , lastname) as fullname ,
		empcode, sum(personal_performance) as personal_performance ,
		sum(performance_quality) as performance_quality ,
		sum(punctuality) as punctuality
		from employee_evaluations as ee

		left join employees as e
		on e.id = ee.empid

		left join user_informations as ui
		on ui.userid = e.userid

		where companyid = 1

		group by empid order by sum(personal_performance) + sum(performance_quality) +
		sum(punctuality) desc";
	}

	/*exam*/

	function getExam($examid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * ,
		(SELECT count(id) from exam_question_choices_answer where examid = '$examid') as questiontotal
		FROM exams where id = '$examid'";

		$query = $db->query($sql);

		// die(mysqli_error($db));

		return fetchSingle($db->query($sql));
	}

	function getExamList()
	{
		$db = DB::getInstance();

		$sql = "SELECT * , (SELECT count(id) from exam_question_choices_answer where examid = exams.id) as questiontotal FROM exams order by name asc";

		return fetchAll($db->query($sql));
	}

	function getExaminationlist()
	{
		$db = DB::getInstance();

		$sql = "SELECT res.id as resultid , correct , incorrect , score , remarks , 
		exams.name as examname , concat(firstname , ' ' , lastname) as examineename 
		FROM exam_results as res 
		left join application_examinations as ae 
		on ae.id = res.examinationid 
		left join exams on exams.id = ae.examid 
		left join user_informations on user_informations.userid = ae.userid
		order by res.id desc";

		$query = $db->query($sql);

		// die(mysqli_error($db));

		return fetchAll($db->query($sql));
	}

	function getExamQAList($examid)
	{
		$db = DB::getInstance();
		$table_name = 'exam_question_choices_answer';

		$sql = "SELECT * FROM $table_name where examid = '$examid' order by orderNumber asc";

		return fetchAll($db->query($sql));
	}

	function getExamQAListByParam($param , $fetchType = 'all' )
	{
		$db = DB::getInstance();
		$table_name = 'exam_question_choices_answer';

		$sql = "SELECT * FROM $table_name $param";

		if($fetchType == 'all'){
			return fetchAll($db->query($sql));
		}else{
			return fetchSingle($db->query($sql));
		}

	}
	function getExamQA($qaid)
	{
		$db = DB::getInstance();
		$table_name = 'exam_question_choices_answer';

		$sql = "SELECT * FROM $table_name where id = '$qaid'";

		return fetchSingle($db->query($sql));
	}
	

	function examQAtoAlphabet($answer)
	{
		switch(strtolower($answer))
		{
			case 'choice_1':
				return 'A';
			break;
			case 'choice_2':
				return 'B';
			break;
			case 'choice_3':
				return 'C';
			break;
			case 'choice_4':
				return 'D';
			break;
		}
	}

	function getExamination($examinationid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM application_examinations where id = '$examinationid'";

		return fetchSingle($db->query($sql));
	}
	/*EXAM NUMBER MAX IS 3*/
	function getJobExam($jobid , $examnumber = 1)
	{
		$db = DB::getInstance();

		$sql = "SELECT jobs_exam.*, exams.name as name , duration , (SELECT count(id) from exam_question_choices_answer where examid = exams.id) as questiontotal
		FROM jobs_exam

		left join exams
		on jobs_exam.examid = exams.id
		where jobid ='$jobid' and examnumber = '$examnumber'";

		$query = $db->query($sql);

		return fetchSingle($query);
	}


	function hasExam($jobid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM jobs_exam where jobid = '$jobid' and status = 'active' order by id desc limit 1";

		return fetchSingle($db->query($sql));
	}
	function readMessage($notifid)
	{
		$db = DB::getInstance();

		$sql = "UPDATE notifications set status = 'read' where id = '$notifid'";

		if($db->query($sql))
		{
			Flash::set('Message Updated');
		}
	}

	function getBusinessNatures($params = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM business_natures $params";


		return fetchAll($db->query($sql));
	}

	function getJobPositions($params = null)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM job_positions $params";


		return fetchAll($db->query($sql));
	}

	function getApplicationExam($applicationid , $examid = null){
		$db = DB::getInstance();

		if($examid == null) {
			$sql = "SELECT * FROM application_examinations where applicationid = '$applicationid'";
		}else{
			$sql = "SELECT * FROM application_examinations where applicationid = '$applicationid' and examid = '$examid'";
		}


		return fetchSingle($db->query($sql));
	}


	function leftOffNumber($examinationid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM exam_answers where examinationid = '$examinationid'
			order by id desc limit 1";

		return fetchSingle($db->query($sql));
	}


	function isPreviousEmployer($companyid , $userid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employees where companyid = '$companyid' and userid = '$userid'";

		return fetchSingle($db->query($sql));
	}

	function isEmployed($userid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employees where userid = '$userid' and status = 'active' order by id desc limit 1";

		$res = fetchSingle($db->query($sql));

		if(!empty($res))
			return true;
		return false;
	}

	function getCurrentEmployer()
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employees where userid = '$userid' and status = 'active' order by id desc  limit 1";

		return fetchSingle($db->query($sql));
	}

	function latestEmployer()
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM employees where userid = '$userid' order by id desc limit 1";

		return fetchSingle($db->query($sql));
	}
	function totalEmployed($jobid)
	{
		$db = DB::getInstance();

		$sql = "SELECT count(id) as total from job_applications where jobid = '$jobid' and status_label = 'complete'";

		$res = fetchSingle($db->query($sql));

		if($res){
			return $res['total'];
		}return 0;
	}

	/*this will check if the user already tooked the exam*/
	function hasTookExam($applicationid , $examid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM application_examinations where applicationid = '$applicationid' and examid = '$examid'";

		return fetchSingle($db->query($sql));
	}

	function getResult($examinationid)
	{
		$db  = DB::getInstance();

		$sql = "SELECT * FROM exam_results where examinationid = '$examinationid'";

		return fetchSingle($db->query($sql));
	}

	// function getExamination($examinationid)
	// {
	// 	$sql = "SELECT * FROM application_examinations where id = '$examinationid'";
	// }

	function getExaminationLastQuestion($examinationid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM exam_answers where examinationid = '$examinationid' order by id desc limit 1";

		$res = fetchSingle($db->query($sql));

		if($res)
			return $res['questionid'];
		return 0;
	}

	function getExamResult($param)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM exam_results $param";

		return fetchSingle($db->query($sql));
	}

	/***/

	function getJobFields($params = '')
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM job_field_list $params";

		return fetchAll($db->query($sql));
	}

	function getWorkExperiences($userid)
	{
		$db = DB::getInstance();
		$sql = "SELECT * FROM work_experiences where userid = '$userid'";

		return fetchAll($db->query($sql));
	}

	function getWorkExperience($workid) {
		$db = DB::getInstance();
		$sql = "SELECT * FROM work_experiences where id = '$workid'";

		return fetchSingle($db->query($sql));
	}

	function getEducationCategories($params = '')
	{
		if($params == '') {
			$params = " order by category asc";
		}
		$db = DB::getInstance();

		$sql = "SELECT * FROM education_categories $params";

		return fetchAll($db->query($sql));
	}

	function getApplicantEducations($userid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM applicant_other_educations where userid = '$userid'";

		return fetchAll($db->query($sql));
	}

	function getOtherEdu($eduid)
	{
		$db = DB::getInstance();

		$sql = "SELECT * FROM applicant_other_educations where id = '$eduid'";

		return fetchSingle($db->query($sql));
	}



	function getCompanyNotifications($companyId , $limit = null)
	{
		$db = DBH::getInstance();

		$param = [
			'notifications_companies',
			'*',
			null,
			'id desc',
			$limit
		];
		return $db->get_results( ...$param );
	}


	function createRegistrationConfirmation($userId , $email , $fullname = null)
	{
		$db = DB::getInstance();

		$token = charGen(25);

		$db->query(
			"INSERT INTO registration_confirmation_tokens(user_id , token)
				VALUES('$userId' , '$token')"
		);

		$isValid = insertId($db);

		if($isValid) {
			//send confirmation link
			$link = URL.DS.'app/client/confirm_registration.php?token='.$token;
			
			$message = mailTemplate("Thank you for your registration , <br/> 
				Click the link below to verify your account and start getting your dream job!<br/>
				<a href='{$link}'> {$link} </a>" , $fullname);
				
			$emailSent = _mail($email , 'Thank you for Joining us' , $message);

			return true;
		}else{
			Flash::set("Create registration failed!" , 'danger' , '_error');
			return false;
		}
	}

	function getRegistrationConfirmation($token)
	{
		$db = DB::getInstance();

		$query = $db->query(
			"SELECT * FROM registration_confirmation_tokens
				where token = '$token'"
		);

		return fetchSingle($query);
	} 

	/**/

	function getAdminDashboard()
	{
		$companyList = getCompanyList();

		$jobList = getJobList();

		$userList = getUsers();

		$employeeList = getEmployees();

		return [
			'companies' => [
				'total' => count($companyList),
				'last'  => ceil(count($companyList) / random_number(1))
			],

			'jobs' => [
				'total' => count($jobList),
				'last'  => ceil(count($jobList) / random_number(1))
			],

			'users' => [
				'total' => count($userList),
				'last'  => ceil(count($userList) / random_number(1))
			],

			'employment' => [
				'total' => count($employeeList),
				'last'  => ceil(count($employeeList) / random_number(1))
			]
		];
	}