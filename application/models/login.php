<?php

function isLogin()
{
    $username = Cookie::get('username');
    $password = Cookie::get('password');

    if (!isset($username[1]) && !isset($password[1])) {
        return false;
    }

    $query = Database::query("select * from users where username='$username' AND password='$password'");

    $numRows = Database::num_rows($query);

    if ((int)$numRows == 0) return false;

    return true;
}

function isUser($username, $password)
{
    $password = md5($password);

    $query = Database::query("select userid from users where username='$username' AND password='$password'");

    $numRows = Database::num_rows($query);

    if ((int)$numRows == 1) {
//        Create cookie store login info,expires is 1 day
        Cookie::make('username', $username, time() + 84600);

        Cookie::make('password', $password, time() + 84600);

        return true;
    }

    return false;

}

?>