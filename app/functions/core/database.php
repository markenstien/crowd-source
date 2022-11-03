<?php 

	function db_update($tableName , $fieldsAndValues , $where = null)
	{
		$db = DB::getInstance();

		$fields = array_keys($fieldsAndValues);

		$values = array_values($fieldsAndValues);

		$cleansedValues = [] ;

		$retunData = [];

		foreach($values as $key => $val) {

			$cleansedValues[] = strEscape($val);

		}

		foreach($fields as $key => $field) {

			$retunData[$field] = $cleansedValues[$key]; 
		}

		$sql = " UPDATE $tableName set ";

		$count = 0;
		
		foreach($fields as $key => $field) {

			if($count < $key) {
				$sql .=',';
				$count++;
			}

			$sql .= " {$field} = '{$cleansedValues[$key]}' ";
		}

		if($where != null) {
			$sql .= " WHERE $where";
		}

		$updated = $db->query($sql);

		if(!$updated){
			die(mysqli_error($db));
		}
		return true;
	}




	function db_insert($tableName , $fieldsAndValues)
	{
		$db = DB::getInstance();

		$fields = array_keys($fieldsAndValues);

		$values = array_values($fieldsAndValues);

		$cleansedValues = [] ;
		$retunData = [];

		foreach($values as $key => $val) {
			$cleansedValues[] = strEscape($val );
		}

		foreach($fields as $key => $field) {
			$retunData[$field] = $cleansedValues[$key]; 
		}


		$sql = "INSERT INTO $tableName(".implode(",", $fields).")
			VALUES('".implode("','", $cleansedValues)."')";
		
		try{
			$db->query($sql);
			return insertId($db);
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}

	function db_single($tableName , $condition = null , $fields = '*' , $join = null)
	{
		$db = DB::getInstance();

		$where = '';

		if( ! is_null($condition) )
			$where .= " WHERE ".$condition;

		if( is_array($fields) )
			$fields = implode(',' , $fields);

		if ( ! is_null($join) ) {

		}

		return fetchSingle($db->query(" SELECT $fields FROM $tableName $where"));
	}

	function db_condition_like($filters)
	{
		$filterCondition = '';

		$counter = 0;

		$fields = array_keys($filters);
		foreach($fields as $key => $val)
		{
			if($counter < $key) {

				$filterCondition .= " AND ";
				$counter++;
			}

			$filterCondition .= " {$val} like '%{$filters[$val]}%'";
		}

		return $filterCondition;
	}

	function db_condition_equal($params)
	{
		$WHERE = '';

		$counter = 0;
		$increment = 0;

		foreach($params as $key => $row) 
		{
			if($counter < $increment){
				$WHERE .= ' AND ';
				$counter++;
			}

			$WHERE .= " $key = '{$row}'";

			$increment++;
		}

		return $WHERE;
	}

	function _errors()
	{
		global $_errors;

		return $_errors;
	}