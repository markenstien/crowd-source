<?php

    function isEqual($subject , $toMatch)
    {
        $subject = strtolower(trim($subject));

        if(is_array($toMatch))
        return in_array($subject , array_map('strtolower', $toMatch));
        return $subject === strtolower(trim($toMatch));
    }

    
    function is_email($string)
    {
        if(strlen($string) < 5)
            return FALSE;
        if(is_numeric($string[0]))
            return FALSE;
        if( strpos($string , '@') < 1)
            return FALSE;
        return TRUE;
    }
    
    function is_phone($number)
    {
        //check if phone number
        if(!strlen($number) > 0)
        {
            return FALSE;
        }
        if($number[0] === '+')
        {
            if(strlen($number) < 11)
                return FALSE;
        }else{
            if(! is_numeric($number))
                return FALSE;
        }

        return TRUE;
    }

    function rmvBlankStr($string)
    {
        return cleanStr(str_replace(' ' , '' ,$string) , 'string');
    }

    function cleanStrArray($fields = array())
    {
        $cleansed = array();
        foreach($fields as $key=>$value)
        {
            $cleansed[$key] = cleanStr($value);
        }
        return $cleansed;
    }
    function cleanStr($string , $input = 'string')
    {
        $string = trim($string);

        $string = strip_tags($string);

        $regEx = '/[^a-zA-Z0-9@.]/';
        $string = preg_replace($regEx , "" , $string);

        switch(strtolower($input))
        {
            case 'string':
                $string = filter_var($string , FILTER_SANITIZE_STRING);
            break;

            case 'email':
                $string = filter_var($string , FILTER_SANITIZE_EMAIL);
            break;

            case 'url':
            $string = filter_var($string , FILTER_SANITIZE_URL);
            break;

            default:
            $string = filter_var($string , FILTER_SANITIZE_STRING);
        }

        return stripTag($string);
    }


    function stripTag($string)
    {
        $str = strtolower($string);
        $find_to_replace = array('<script> </script>' , '<script>');
        $str = str_replace($find_to_replace , ' ' , $string);

        return $str;
    }

    function strEscape($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    function crop_string($string , $length = 20)
    {
        if(strlen($string) > $length)
        {
            return substr($string, 0 , $length) . ' ...';
        }return $string;
    }