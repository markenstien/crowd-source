<?php 	

	class Field 
	{
		public static function get($name , $type = 'post')
		{

			if(strtolower($type) == 'post')
			{
				if(isset($_POST[$name]))
				{
					return $_POST[$name];
				}else
				{
					return '';
				}
			}else
			{
				if(isset($_GET[$name]))
				{
					return $_GET[$name];
				}
				return '';
			}
		}
	}