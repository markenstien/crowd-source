<?php 	

	class Summary
	{

		public function __construct()
		{
			$this->db = DB::getInstance();
		}

		public function company()
		{
			$sql = "SELECT count(id) as total from companies";
			return $this->extractTotal(fetchSingle($this->db->query($sql)));
		}

		public function jobPost()
		{
			$sql = "SELECT count(id) as total from jobs where status = 'posted'";
			return $this->extractTotal(fetchSingle($this->db->query($sql)));
		}

		public function user()
		{
			$sql = "SELECT count(id) as total from users";
			return $this->extractTotal(fetchSingle($this->db->query($sql)));
		}

		private function extractTotal($result)
		{
			if(!empty($result)){
				return $result['total'];
			}
			return 0;
		}
	}