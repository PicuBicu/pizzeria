<?php

require_once "config.php";
require_once "helpers/alert-types.php";
require_once "helpers/messages.php";
require_once "helpers/utils.php";
require_once "models/ClientModel.php";

session_start();

if (redirectIfUserIsLoggedIn()) {
    exit();
}

$errors = "";

if (!isset($_POST["email"]) || strlen(trim($_POST["email"])) == 0) {
    $errors =  $errors . "Nie podano emaila\n";
}

if (!isset($_POST["password"]) || strlen(trim($_POST["password"])) == 0) {
    $errors =  $errors . "Nie podano hasła\n";
}

if (!empty($errors)) {
    setAlertInfo(nl2br($errors), DANGER);
    header("location: login.php");
    exit();
}

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

if (!$email) {
    $errors =  $errors . "Wprowadzony przez ciebie email nie spełnia warunków\n";
}

if (!empty($errors)) {
    setAlertInfo(nl2br($errors), DANGER);
    header("location: login.php");
    exit();
}

$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if (strlen($errors) == 0) {
    $clientModel = new ClientModel($pdo);
    $clientData = $clientModel->getClientByEmail($email);
    if (!$clientData) {
        $errors =  $errors . "Walidacja nie powiodła się, wprowadź poprawne dane\n";
        setAlertInfo(nl2br($errors), DANGER);
        header("location: login.php");
        exit();
    }
    if (password_verify($password, $clientData["password"])) {
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["clientId"] = $clientData["id"];
        $_SESSION["firstName"] = $clientData["first_name"];
        $_SESSION["lastName"] = $clientData["last_name"];
        $_SESSION["email"] = $clientData["email"];
        setAlertInfo(LOGGED_SUCCESSFULLY, SUCCESS);
        header("location: menu.php");
        exit();
    }
}

$errors =  $errors . "Walidacja nie powiodła się, wprowadź poprawne dane\n";
setAlertInfo(nl2br($errors), DANGER);
header("location: login.php");
exit();
