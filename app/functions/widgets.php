<?php 	
	
	function spaceUp( $size = '50px')
	{
		print <<<EOF
			<div style="margin-top: $size;"></div>
		EOF;
	}
	function wSystemBanner()
	{
		$image = URL.DS.'public/banner.jpg';
		
		print <<<EOF
			<div style='margin-top:30px'>
				<img src="{$image}" style="width:100%">
			</div>
		EOF;
	}


	function wCard( $attributes = [] )
	{
		$card = <<<EOF
			<div class='card'>
		EOF;

		ob_start();
	}

	function wCardEnd()
	{
		ob_end_clean();	
	}


	/*
	*attricbutes
	*src , alt , class ,
	*/
	function wCircularImage( $srcParam = [] ,  $attributes = [] )
	{

		$defaultPath = URL.DS.'public/assets/';

		$src = DEFAULT_PROFILE_IMAGE_PATH;

		$class = 'mr-3 rounded-circle';

		if( empty($srcParam) ){
			$src = DEFAULT_PROFILE_IMAGE_PATH.DS.'/'.DEFAULT_PROFILE_IMAGE_NAME;
		}else{

			if(empty($srcParam['name']))
				return '';

			if( isset($srcParam['path']) )
				$src = $srcParam['path'];
			$src .= '/'.$srcParam['name'];
		}

		if( isset($attributes['class'])) 
			$class = $defaultClass.' '.$attributes['class'];

		$attr = keypair_to_str( $attributes , '=' , ' ' , '"');
		
		// print <<<EOF
		// 	<img class="{$class}" src="{$src}" {$attr} style="width:70px; height:70px;">
		// EOF;
	}