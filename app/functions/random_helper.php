<?php

	function random_gen($length = 12){

		$bytes = random_bytes($length);

		return substr(bin2hex($bytes), 0 , $length);
	}
	
	function reference($initial = 'REF')
	{
		$bytes = random_bytes(12);
		$initial = substr($initial , 0 ,3);

		return strtoupper($initial.substr(bin2hex($bytes) , 0 , 9));
	}


	function random_number($length = 12)
	{
		return substr(rand(1 , 1000000), 0 , $length);
	}
	

	function charGen($length = 6)
	{
		$bytes = random_bytes($length);

		return strtoupper(substr(bin2hex($bytes), 0 , $length));
	}

	function get_token_random_char($length = 12 , $params = false)
    {
        $bytes = random_bytes($length);

    		if($params)
    			return strtoupper(substr(bin2hex($bytes), 0 , $length));
    		return substr(bin2hex($bytes), 0 , $length);
    }