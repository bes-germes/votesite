<?php

// require_once("settings.php");

class auth_ssh
{
    function login($login, $pwd, $source)
    {
        $lg = pg_escape_string($login);
        
        $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
            or die('Не удалось подключиться к БД: ' . pg_last_error());


        // $result = pg_query("SELECT * FROM student WHERE first_name='$lg'") or die('Ошибка запроса: ' . pg_last_error());
        // $found = pg_fetch_assoc($result);
     
        $result = pg_query($db, "SELECT * FROM student WHERE first_name='$lg'");
        $found = pg_fetch_assoc($result);

        $result = pg_query($db, 'SELECT role FROM public."user" WHERE id='.$found['id']);
        $found_role = pg_fetch_assoc($result);

        if($found && $found_role) {
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $found_role['role'];
            $_SESSION['hash'] = $found['id'];
            return $found_role['role'];
        }

        return false;
    }
    
//----------------------------------------------------------------------------------------------

    function logout()
    {
        $_SESSION['login'] = '';
        $_SESSION['role'] = 0;
        $_SESSION['hash'] = '';
        $_SESSION['username'] = '';
    }
    
//----------------------------------------------------------------------------------------------
    
    function loggedIn($hash = "") {
        if (array_key_exists('login', $_SESSION)) {
            return $_SESSION['login'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------

function isTeacher($hash = '') {
    if (array_key_exists('role', $_SESSION)) {
        return ($_SESSION['role'] == 2);
    }
    else
        return false;
}

//----------------------------------------------------------------------------------------------
    
    function isAdmin($hash = '')
    {
        if (array_key_exists('role', $_SESSION))
        {
            return ($_SESSION['role'] == 1);
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function isAdminOrTeacher($hash = '') {
        if (array_key_exists('role', $_SESSION)) {
            return (($_SESSION['role'] == 1) || ($_SESSION['role'] == 2));
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function getUserId($hash = '')
    {
        if (array_key_exists('hash', $_SESSION))
        {
            return $_SESSION['hash'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function getUserLogin($hash = '')
    {
        if (array_key_exists('login', $_SESSION))
        {
            return $_SESSION['login'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
}