<?php 	

	class Profile
	{

		public function __construct($userid = null)
		{
			$this->db = DB::getInstance();

			if($userid == null){
				$this->user = Session::get('user');
			}else
			{
				$this->user = getUser($userid);
			}
			
		}

		public function getId()
		{
			return $this->user['id'];
		}
		public function getPersonal()
		{
			$sql = "SELECT * FROM user_informations where userid = '{$this->user['id']}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getEducation()
		{
			$sql = "SELECT * FROM applicant_educations where userid = '{$this->user['id']}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}
		public function getUser()
		{
			$sql = "SELECT * FROM users where id = '{$this->user['id']}'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getWorkExperience()
		{
			$sql = "SELECT * FROM work_experiences where userid = '{$this->user['id']}' and field != 'n/a'";

			$query = $this->db->query($sql);

			return fetchSingle($query);
		}

		public function getSkills()
		{
			$sql = "SELECT apskill.* , jc.category as category , jc.description as description 
			FROM applicant_skills apskill 

			left join job_categories as jc
			on jc.id = apskill.category
			
			where userid = '{$this->user['id']}'";

			$query = $this->db->query($sql);

			return fetchAll($query);
		}
	}

?>