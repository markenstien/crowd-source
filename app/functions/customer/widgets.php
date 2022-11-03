<?php 	

	function wSystemBanner()
	{
		$image = URL.DS.'monster_thesis_banner.jpg';
		
		print <<<EOF
			<div style='margin-top:30px'>
				<img src="{$image}" style="width:100%">
			</div>
		EOF;
	}