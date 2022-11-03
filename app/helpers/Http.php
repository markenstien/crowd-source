<?php 	

	class Http
	{
		public function __construct()
		{

		}

		public static function getVars()
		{	
			$cleansed = array();

			foreach($_GET as $key=> $vars)
			{
				array_push($cleansed, [$key => trim($vars)]);
			} 

			return $cleansed;
		}
	}