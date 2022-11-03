<?php 	

	class Work
	{
		public function __construct($workid)
		{
			$this->workid = $workid;
			$this->db = DB::getInstance();

		}

		public function getDetails()
		{
			$sql = "SELECT emp.id as employeeid , empcode, date_started , job_title ,
			position , salary , salary_type , emp.status as employment_status , company.id as companyid,
			company.name as company_name , concat(ui.firstname , ' ' , ui.lastname) as fullname , ui.userid as userid 

			from employees as emp

			left join user_informations as ui
			on emp.userid = ui.userid

			left join companies as company
			on company.id = emp.companyid

			where emp.id = '$this->workid'";

			return fetchSingle($this->db->query($sql));
		}

		public function getStanding()
		{
			$sql = "SELECT personal_performance , performance_quality,
			punctuality , notes from employee_evaluations where empid = '$this->workid'";


			return fetchAll($this->db->query($sql));
		}
	}