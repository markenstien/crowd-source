<?php 	

	function anchor($link , $text = null, $title = null , $extras = null)
	{
		$domain = getLink().'/'.$link;

		$link  = '<a href ="'.$domain.'"';
		$link .= ' title = "' .$title .'"';

		if($extras != null)
		{
			if(is_array($extras))
			{
				foreach($extras as $extra)
				{
					$link .= parseExtras($extra);
				}
			}else
			{
				$link .= parseExtras($extras);
			}
		}
		

		$link .= '>'.$text;
		$link .= '</a>';

		echo $link;
	}

	//css , id , target , attribute
	//second parameter is for attributes only
	function parseExtras($extra)
	{
		$first = $extra[0];

		if(is_array($extra))
		{
			$data = '';

			foreach($extra as $key=>$attr)
			{
				if(is_array($attr))
				{
					foreach($attr as $key=>$arAttr)
					{
						$data .= ' data-'.$key.'="'.$arAttr.'" ';
					}
				}
				else{
					$data .= ' data-'.$key.'="'.$attr.'" ';
				}
			}

			return $data;
		}
		switch($first)
		{
			//id
			case '#':
				return ' id = "'.substr($extra, 1 , strlen($extra)).'"';
			break;
			//css
			case '.';
				return ' class = "'.substr($extra, 1 , strlen($extra)).'"';
			break;
			//target
			case '_';
				return ' target = "'.substr($extra, 1 , strlen($extra)).'"';
			break;
			default:

			return '';
		}
	}

	function getLink()
	{
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
	}
	

	function limitText($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }

	function pageHeader($page_title)
	{
		echo '<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">'.$page_title.'</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">'.$page_title.'</h1>
			</div>
		</div>';
	}



	function stockHelper($type)
	{
		if(strtolower($type) == 'stock addition')
		{
			echo'<label class="text-success">' . $type .'</label>';
		}else
		{
			echo'<label class="text-danger">' . $type .'</label>';
		}
		
	}