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

function goToLocation($location, $message, $alertType)
{
    setAlertInfo($message, $alertType);
    header($location);
    exit();
}

function goToLocationWithError($location, $message)
{
    goToLocation($location, $message, DANGER);
}

function goToLocationWithWarning($location, $message)
{
    goToLocation($location, $message, WARNING);
}

function goToLocationWithSuccess($location, $message)
{
    goToLocation($location, $message, SUCCESS);
}

function validateAddressField($field)
{
    if (isset($field) && strlen(trim($field)) < 255) {
        return true;
    }
    return false;
}
