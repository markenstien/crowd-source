<?php

	function export(?array $data_records , ?array $defined_headers , $file_name = null)
	{

		$is_set_header = false;
		$is_set_body   = false;
		$is_set_defined_headers = count($defined_headers) ?? 0;

		$content = '<table class="table">';
		foreach($data_records as $key=>$record)
		{
			$table_header = array_keys($record);
			if($is_set_header == false)
			{
				$content .= '<thead>';


				//default
				if($defined_headers == null)
				{
					foreach($table_header as $header)
					{
						$content .= '<th>' . $header . '</th>';
					}
				}else
				{
					foreach($defined_headers as $header)
					{
						$content .= '<th>' . $header . '</th>';
					}
				}
				
				$content .= '</thead>';

				$is_set_header = true;
			}

			if($is_set_body == false)
			{
				$content .= '<tbody>';
			}

			$content .= '<tr>';

			if($defined_headers != null)
			{
				$columns = array_keys($defined_headers);

				foreach($columns as $col)
				{
					$content .= '<td>'.$record[$col].'</td>';
				}
			}
			else
			{
				foreach($table_header as $header)
				{
					$content .= '<td>'.$record[$header].'</td>';
				}
			}
			$content .= '</tr>';
		}

		$content .='</table>';

		//set file name

		$random = 'Excell'.strtoupper(charGen());
		$file_name = $file_name ?? $random;
		header("Content-Type:application/xls");
		header("Content-Disposition: attachment; filename=$file_name.xls");

		echo $content;
	}
?>