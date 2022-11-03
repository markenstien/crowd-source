<?php   
    
    function sealInput($input){
        return base64_encode(serialize($input));
    }

    function unsealInput($input){
        return unserialize(base64_decode($input));
    }
    function jobCategories()
    {
        return [
            'programming' , 'webdevelopment' , 'software engineeer' , 'hr' , 'date-encoder' 
        ];
    }

    function salary_type_list()
    {
        return [
            'per hour','daily','weekly','monthly'
        ];
    }

    function jobFields()
    {
        return [
            'Law and Law Enforcement' , 'Hospitality, Tourism, and the Service Industry'  , 'Science' , 
            'Architecture and Civil Engineering' , 'Management, Business, and Finance'  , 'Trades and Transportation' , 
            'Arts and Communications' , ' Education and Social Services'  , 'Health Care and Allied Health' , 
            'Computers and Technology'
        ];
    }

    function educationaAttainments()
    {
        return [
            'Highschool Graduate' ,'College Level' , 'College Graduate' , 'Masters Degree'
        ];
    }

    function download($file , $dir)
    {
        if (file_exists($file)) {

            $realPath = $dir.DS.$file;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$file.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    function evaluationCriteriaList()
    {
        return [
            'jobKnowledge' => 'Job Knowledge',
            'qualOfWork'   => 'Quality of work',
            'dependability' => 'Dependability',
            'initiative'   => 'Initiative',
            'aptitude'     => 'Aptitude' ,
            'adapAndCoop'  => 'Adaptability and Cooperation',
            'grooAndPersonal' => 'Grooming or Personal Cleanliness',
            'constConsious'  => 'Cost Conciousness',
            'safeAndAware'   => 'Safety and Awareness',
            'attendanceAndFunctionality' => 'Attendance And Functionality'

        ];
    }


    function evaluationCriteriaScore($key = null)
    {
        $scores = [
            '5' => 'Outstanding',
            '4' => 'Excellent',
            '3' => 'Good',
            '2' => 'Fair',
            '1' => 'Bad',
            '0' => 'Fail'
        ];

        if($key != null){
            return $scores[$key];
        }
        return $scores;
    }

    function evaluationSeason()
    {
        return [
            '5th month' , '1st year' , '1st year and 5th month' , '2nd year' , '2nd year and 5th month',
            '3rd year','3rd year and 5th month','4th year' , '4th year and 5th month', 
            '5th year','5th year and 5th month','6th year' , '6th year and 5th month', 
            '7th year','7th year and 5th month','8th year' , '8th year and 5th month', 
            '9th year','9th year and 5th month','decade' , 'decade and 5th month'
        ];
    }
    function passFail($score , $minScoreToPass)
    {
        if($score >= $minScoreToPass)
            return 'Passed';
        return 'Failed';
    }

    function getPercentage($score , $max)
    {
        $placeHolder = $score / $max;

        return round($placeHolder * 100);
    }

    function mailTemplate($message , $reciever = null)
    {
        $url = URL.DS.'public';

        $appName = APP_NAME;


        if( ! is_null($reciever) )
            $reciever = " <p>  Dear , {$reciever} </p> ";

        $html = <<<EOF
        <!DOCTYPE html>
        <html>
        <head>
            <title></title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;1,200&display=swap" rel="stylesheet">
            <style type="text/css">
                #wrapper{
                    width: 700px;
                    margin: 0px auto;
                    font-family: 'Poppins', sans-serif;
                    font-weight: regular;
                    color: #000;
                    border: 1px solid #000;
                    padding: 10px;
                }
                #company_banner{
                    height: 200px;
                    background:#eee;
                }
                #company_banner img {
                    width: 100%;
                    height: 100%;
                }
                #content{
                    padding: 10px 30px;
                }
                #footer{
                    text-align: center;
                    margin-top: 50px;
                    color: #060930;
                    font-size: .60em;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div id="wrapper" style="width: 700px;margin: 0px auto;font-family: 'Poppins', sans-serif;font-weight: regular;color: #000;border: 1px solid #000;padding: 10px;">
                <div id="company_banner" style="height: 200px;background: #eee;">
                    <img src="{$url}/banner.jpg" style="width: 100%;height: 100%;">
                </div>
                <div id="content" style="padding: 10px 30px;">
                    {$reciever}
                    {$message}
                    <div id="footer" style="text-align: center;margin-top: 50px;color: #060930;font-size: .60em;font-weight: bold;">
                        <p>
                            Copy Right @<?php echo APP_NAME?> All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        EOF;

        return $html;
    }

    function convertImage($text , $url = null , $attributes = null)
    {

        $url = $url ?? URL.DS.'public/assets/';
        //search image separator;

        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $text = trim($text);
        
        if(!empty($text) && !isEqual($text , 'na'))
        {
            return "<img src='{$url}{$text}'  $attributes>";
        }
        return '';
    }

    function removeImage($text)
    {
        $imagePos = strpos($text , IMGSEPARATOR);

        if(!empty($imagePos)){
            return substr($text , 0 , $imagePos);
        }

        return $text;
        
    }


    /*restriction*/


    function allowUser($users = null , $location = null)
    {
        if($users != null)
        {
            $auth = Session::get('auth');

            if( in_array($auth , $users)){
                return true;
            }else{

                if($location != null){
                    return false;
                }else{
                    redirect($location);
                }
            }
        }
    }

    function dontAllowUser()
    {
        if(Session::check('auth')){
            return true;
        }
        return false;
    }

    function redirectTo()
    {
        $auth = Session::get('auth');

        if($auth == 'vendor'){
            redirect("../admin/profile.php");
        }elseif($auth == 'user'){
            redirect("../client/profile.php");
        }elseif($auth == 'company'){
            redirect("../customer/profile.php");
        }
    }


    function _vendor($path)
    {
        return URL.DS.'public/vendor/orbit/'.$path;
    }

     function _public($path)
    {
        return URL.DS.'public'.DS.$path;
    }

    function convertDotToDS($path)
    {
        return str_replace('.' , DS , $path);
    }


    function auth_type()
    {
        return Session::get('auth');
    }


    function appVersion()
    {
        $APP_NAME = APP_NAME;

        print <<<EOF
        <div class='alert alert-warning text-center'> 
            <div>
               <p class='text-dark'>
                {$APP_NAME} <span class='badge badge-danger'> ALHPA VERSION </span>
               </p>
               <div> <span class='badge badge-primary'> <strong> v1 </strong> </span> </div>
            </div>
        </div>
        EOF;
    }


    function jobApplicationStatus()
    {
        return [
            'pending', 'passed', 'failed' , 'cancelled' , 'denied'
        ];
    }
    // function auth()
    // {
    //  return Session::get('user');
    // }

    function generate_emails($number, $username_length) 
    {
        if (is_numeric($number) && $number != 0) 
        {
            if ($number > 1000) { //put hard limit on generate request
                $number = 1000; 
            }

            $generated_email_addresses = array(); 

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $char_count = strlen($characters); 
            $tld = array("com", "net", "biz" , 'pass' , 'xyz' , 'hub'); 

            for ($i=0; $i<$number; $i++)
            {
                $randomName = ''; 
                
                for($j=0; $j<$username_length; $j++){
                    $randomName .= $characters[rand(0, strlen($characters) -1)];
                }
                $k = array_rand($tld); 
                $extension = $tld[$k]; 
                $fullAddress = $randomName . "@" ."monsterthesis.".$extension; 
                $generated_emails[] = $fullAddress; 
            }

            return $generated_emails;
                
        }
            
    }