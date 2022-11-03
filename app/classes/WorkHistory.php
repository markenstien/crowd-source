<?php 	
	
	class WorkHistory
	{
		public function __construct($userid)
		{
			$this->userid = $userid;

			$this->db = DB::getInstance();
		}

		public function getWorkList()
		{
			$sql = "SELECT emp.id as employeeid , empcode, date_started , job_title ,
			position , salary , salary_type , emp.status as employment_status , emp.notes as empnotes,
			company.name as company_name , concat(ui.firstname , ' ' , ui.lastname) as fullname

			from employees as emp

			left join user_informations as ui
			on emp.userid = ui.userid

			left join companies as company
			on company.id = emp.companyid

			where emp.userid = '$this->userid' order by emp.id desc";

			$query = $this->db->query($sql);

			return fetchAll($this->db->query($sql));
		}

	}