<?php
	
	session_start();

	function autoload($classname) 
	{   
		 if(file_exists(APPROOT.DS.'helpers/'.$classname.'.php'))
		 {
		 	require_once APPROOT.DS.'helpers/'.$classname.'.php';
		 }else if(file_exists(APPROOT.DS.'classes/'.$classname.'.php')) 
		 {
		 	require_once APPROOT.DS.'classes/'.$classname.'.php';
		 }
	}
	spl_autoload_register('autoload');


	//load all functions

	require_once APPROOT.DS.'functions'.DS.'debug_helper.php';
	require_once APPROOT.DS.'functions'.DS.'widgets.php';
	require_once APPROOT.DS.'functions'.DS.'html_helper.php';
	require_once APPROOT.DS.'functions'.DS.'number_helper.php';
	require_once APPROOT.DS.'functions'.DS.'random_helper.php';
	require_once APPROOT.DS.'functions'.DS.'string_helper.php';
	require_once APPROOT.DS.'functions'.DS.'url_helper.php';
	require_once APPROOT.DS.'functions'.DS.'actions.php';
	require_once APPROOT.DS.'functions'.DS.'functions.php';
	require_once APPROOT.DS.'functions'.DS.'date_helper.php';
	require_once APPROOT.DS.'functions'.DS.'uncommon.php';
	require_once APPROOT.DS.'functions'.DS.'helpers.php';
	require_once APPROOT.DS.'functions'.DS.'template.php';

	require_once APPROOT.DS.'functions'.DS.'core/array_helper.php';
	require_once APPROOT.DS.'functions'.DS.'core/form_helper.php';
	require_once APPROOT.DS.'functions'.DS.'core/database.php';
	require_once APPROOT.DS.'functions'.DS.'auth.php';
	require_once APPROOT.DS.'functions'.DS.'uploader.php';

	//database connection
	$con = DB::getInstance();