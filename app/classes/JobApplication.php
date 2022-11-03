<?php

	class JobApplication
	{

		/*
		*@param jaid = job application id
		*
		*
		*
		*/
		public function __construct($jaid)
		{
			$this->db  = DB::getInstance();

			$this->jaid = $jaid;
		}


		public function getJobApplicationInfo()
		{
			$sql = "SELECT * FROM job_applications where id = '$this->jaid'";

			return fetchSingle($this->db->query($sql));
		}

		public function getApplicantInfo()
		{
			$userid = $this->getJobApplicationInfo()['userid'];

			return new Applicant($userid);
		}

		public function getJobInfo()
		{
			$jobid = $this->getJobApplicationInfo()['jobid'];

			return getJob($jobid);
		}


		public function getJobExam($jobid)
		{
			return getJobExam($jobid);
		}
		public function getCompany()
		{
			$companyid = $this->getJobInfo()['companyid'];

			return getCompanyInfo($companyid);
		}
	}
?>