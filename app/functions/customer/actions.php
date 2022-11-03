<?php 	
	function createJobVacancy($job)
	{
		extract($job);

		$db = DB::getInstance();
		$date_posted = dateNow();
		//temporary id
		$sql = "INSERT INTO jobs(date_posted , title , sub_title , position , companyid , email ,
		phone , salary , salary_type, address , notes , status)
		VALUES('$date_posted' , '$title' , '$sub_title' , '$position' , '$companyid' , '$email',
		'$phone' , '$salary', '$salary_type', '$address' , '$notes','for posting')";

		$query = $db->query($sql);

		if($query)
		{
			$lastid = insertId($db);
			//insert job post category

			if(createJobPostCategories($categories , $lastid))
			{
				Flash::set('Job Created!');
				redirect('job_view.php?id='.$lastid);
			}else
			{
				Flash::set(mysqli_error($db), 'danger');
			}
			
		}else
		{
			Flash::set(mysqli_error($db) , 'danger');

			die();
		}
	}

