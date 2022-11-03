<?php
/*CONFIGURATIONS*/
date_default_timezone_set('Asia/manila');	
define('DS' ,  DIRECTORY_SEPARATOR);
define('SITENAME' , 'Job Recruitment with HRIS');
define('APPROOT' , dirname(dirname(__FILE__)));
define('BASEROOT' , dirname(dirname(dirname(__FILE__))));
define('VIEWS' , APPROOT.DS.'templates');

define('APP_NAME' , 'Recruitment');

const MAILER_AUTH = [
	'username' => 'main@recruitment.host',
	'password' => 'uc7R8TtBgdEWBRd',
	'host'     => 'recruitment.host',
	'name'     => 'Recruitment',
	'replyTo'  => 'main@recruitment.host',
	'replyToName' => 'Recruitment'
];

define('SCHEDULE_APPOINTMENT' , 'APPOINTMENT SCHEDULE');


require_once 'env.php';
require_once 'constants.php';

