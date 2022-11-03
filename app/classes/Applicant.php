<?php 	

	class Applicant
	{
		
		public function __construct($userid)
		{
			$this->db = DB::getInstance();
			$this->userid = $userid;

			return $this;
		}

		public function getId()
		{
			return $this->userid;
		}
		public function getPersonal()
		{
			$sql = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM user_informations where userid = '{$this->userid}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getEducation()
		{
			$sql = "SELECT * FROM applicant_educations where userid = '{$this->userid}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}
		public function getUser()
		{
			$sql = "SELECT * FROM users where id = '{$this->userid}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getWorkExperience()
		{
			$sql = "SELECT * FROM work_experiences where userid = '{$this->userid}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getSkills()
		{
			$sql = "SELECT apskill.* , apskill.category as categoryid , jc.category as category , jc.description as description 
			FROM applicant_skills apskill 

			left join job_categories as jc
			on jc.id = apskill.category
			
			where userid = '{$this->userid}'";

			$query = $this->db->query($sql);

			return fetchAll($query);
		}
	}