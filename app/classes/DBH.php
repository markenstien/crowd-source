<?php 	

	class DBH
	{

		public static $instance = null;

		public function __construct(){

			$this->db = DB::getInstance();
		}

		public static function getInstance()
		{
			if( is_null(self::$instance) )
				self::$instance = new DBH();

			return self::$instance;
		}


		public function store($values , $tableName)
		{
			$this->db->query(
				"INSERT INTO "
			);

			$fields = array_keys($values);

			$values = array_values($values);

			$cleansedValues = [] ;
			$retunData = [];

			foreach($values as $key => $val) {

				$cleansedValues[] = strEscape($val , FILTER_SANITIZE_STRING);

			}

			foreach($fields as $key => $field) {

				$retunData[$field] = $cleansedValues[$key]; 
			}

			$sql = "INSERT INTO $tableName(".implode(",", $fields).")
				VALUES('".implode("','", $cleansedValues)."')";
			
			return $this->db->query($sql);
		}


		private final function select($tableName , $fields = '*' , $condition = null, $orderby= null , $limit = null , $offset = null)
		{
			if(is_array($fields))
			{
				$sql = "SELECT  ".implode(',',$fields)." from $tableName";
			}else{
				$sql = "SELECT $fields from $tableName";
			}

			if(! is_null($condition)) {

				$sql .= " WHERE $condition ";
			}

			if(!is_null($orderby)) {
				$sql .= " ORDER BY $orderby";
			}

			if(!is_null($limit) && is_null($offset)) {
				$sql .= " LIMIT $limit";
			}

			if(!is_null($offset) && is_null($limit))
			{
				$sql .= " offset $offset";
			}

			if(!is_null($offset) && !is_null($limit))
			{
				$sql .= " LIMIT $offset , $limit";
			}

			return $sql;
		}

		public function get_results($tableName , $fields = '*' , $condition = null, 
			$orderby= null , $limit = null , $offset = null)
		{
			$sql = $this->select($tableName , $fields , $condition , $orderby , $limit , $offset);
			return fetchAll($this->db->query($sql));
		}
	}