<?php
	class DB
	{
		static $instance = null;

		private function __construct(){}//Cannot be instanciated


		public static function getInstance()
		{
			if(self::$instance == null)
			{
				self::$instance = mysqli_connect(DBHOST  , DBUSER , DBPASS , DBNAME);
			}

			return self::$instance;
		}
	}