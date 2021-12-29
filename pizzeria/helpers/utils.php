<?php

function setAlertInfo($message, $type)
{
    $_SESSION["alertMessage"] = $message;
    $_SESSION["alertType"] = $type;
}

function redirectIfUserIsNotLoggedIn()
{
    if (!isset($_SESSION["loggedin"])) {
        header("location: login.php");
        return true;
    }
    return false;
}

function redirectIfUserIsLoggedIn()
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: menu.php");
        return true;
    }
    return false;
}
