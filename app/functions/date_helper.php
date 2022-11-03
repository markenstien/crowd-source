<?php
	

	function yearNow()
	{
		return date('Y');
	}
	function getDateDifference($start , $end)
	{
		if(!empty($start)){
			$date1=date_create($start);
		}

		if(!empty($end)){
			$date2=date_create($end);
		}

		if(isset($start) && isset($end)){
			$diff = date_diff($date1,$date2);

			return $diff->format("%R%a days");
		}else{
			return 'N/A';
		}


	}

	function dateNow()
	{
		return date('Y-m-d');
	}

	function generateUpcomingDate($days,$start = null)
	{
		if($start == null)
		{
			$start = dateNow();
		}

		return date('Y-m-d' , strtotime('+'.$days.'days' , strtotime(str_replace('/', '-', $start))));
	}

	function generatePreviousDate($days,$start = null)
	{
		if($start == null)
		{
			$start = dateNow();
		}

		return date('Y-m-d' , strtotime('-'.$days.'days' , strtotime(str_replace('/', '-', $start))));
	}

	function generateYear($years = 10)
	{
		$curYear = (int) Date('Y');

		$previous =(int)$curYear - 10;

		$next =(int)$curYear + 10;

		$years = array();

		//last 10 years
		for($i = $previous ; $i < $curYear ; $i++)
		{
			$years[$i] = $i;
		}

		return $years;
	}

	function getMonthByNumber($monthNumber)
	{
		$dates = getDates();

		$monthNumber--;
		
		foreach( $dates as $key => $date) {

			if( isEqual($key , $monthNumber))
				return $dates[$monthNumber];
		}
	}
	function getDates($type = 'short' , $date = null)
	{

		$returnDate = "";
		switch(strtolower($type))
		{
			case 'short':
				$shortDate = ['jan' , 'feb' , 'mar' , 'apr' , 'may' ,'jun' , 'jul' , 'aug' , 'sept' , 'oct' , 'nov','dec'];
				if(is_null($date)) {
					$returnDate = $shortDate;
				}else{
					$returnDate = $shortDate[$date - 1];
				}
			break;


			case 'long':
				$longDate = ['january' , 'february' , 'march' , 'april','may','june','july','august' ,'semptember' , 'october' , 'november' , 'december'];
				if(is_null($date)) {
					$returnDate = $longDate;
				}else{
					$returnDate = $longDate[$date - 1];
				}
			break;
			case 'numeric':
				$numeric = array();
				for($i = 1 ; $i <= 12; $i++)
				{
					$numeric[$i] = $i;
				}
				if(is_null($date)) {
					$returnDate = $numeric;
				}else{
					$returnDate = $date;
				}
			break;

			default:
				$short = ['jan' , 'feb' , 'march' , 'apr' , 'may' ,'jun' , 'jul' , 'aug' , 'sept' , 'oct' , 'nov','dec'];
				if(is_null($date)) {
					$returnDate = $short;
				}else{
					$returnDate = $short[$date - 1];
				}
		}

		return $returnDate;
	}
	/*

$start_date = new DateTime('2007-09-01 04:10:58');
$since_start = $start_date->diff(new DateTime('2012-09-11 10:25:00'));
echo $since_start->days.' days total<br>';
echo $since_start->y.' years<br>';
echo $since_start->m.' months<br>';
echo $since_start->d.' days<br>';
echo $since_start->h.' hours<br>';
echo $since_start->i.' minutes<br>';
echo $since_start->s.' seconds<br>';
	*/
