<?php

    function pre($var)
    {
        echo '<pre>';
            var_dump($var);
        echo '</pre>';
    }


    function dump($data)
    {
    	pre($data);
    	die();
    }

    function dd($data)
    {
        pre($data);
        die();
    }