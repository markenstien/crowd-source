<?php 	

	class Company
	{
		public function __construct($companyid)
		{
			$this->db = DB::getInstance();

			$this->id = $companyid;
		}

		public function getTotalApplicants()
		{
			$sql = "SELECT count(ja.id) as total from 
			job_applications as ja 
			left join jobs as job 
			on job.id = ja.jobid 
			where companyid = '$this->id'";

			$row = fetchSingle($this->db->query($sql));

			if(!empty($row))
				return $row['total'];
			return 0;
		}

		public function getTotalEmployees()
		{
			$sql = "SELECT count(id) as total from employees where companyid = '$this->id'";
			$row = fetchSingle($this->db->query($sql));

			if(!empty($row))
				return $row['total'];
			return 0;
		}

		public function getTotalJobPosts()
		{
			$sql = "SELECT count(id) as total from jobs where companyid = '$this->id'";
			$row = fetchSingle($this->db->query($sql));

			if(!empty($row))
				return $row['total'];
			return 0;
		}
	}