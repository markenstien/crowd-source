<?php 	


	// function redirect($location){

	// 	header("Location:".URL.DS.$location);
	// }

	function redirect($location)
	{
		header("Location:".$location);
	}

	function redirectRaw($location)
	{
		header("Location: {$location}");
	}

	function get_url($location = null){

		if($location == null) {

			return URL;
		}
		else{
			return URL.DS.$location;
		}
	}

	function err_404($message = null)
	{
		if($message != null)
		{
			Flash::set($message , 'warningn');
		}
		redirect('mapper/lost');
	}

	function err_restrict()
	{
		redirect('mapper/unauthorize');
	}
?>