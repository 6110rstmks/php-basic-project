<?php

namespace App;

class Token{

    /**
     * create CSRF Token
     * 
     */
    public static function create()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        // if (!isset($_SESSION['csrf_token']))
        {
        }
        return $token;
    }
    
    public static function validate()
    {
        if ($_SESSION['csrf_token'] !== filter_input(INPUT_POST, 'csrf_token'))
        {
            exit('INVALID post request');
        }
    }
}