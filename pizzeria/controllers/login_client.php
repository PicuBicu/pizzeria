<?php

require_once "../config.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/ClientModel.php";
require_once "../models/BasketModel.php";

session_start();

if (redirectIfUserIsLoggedIn()) {
    exit();
}

$locationLogin = "location: ../login.php";
$errors = "";

if (!isset($_POST["email"]) || strlen(trim($_POST["email"])) == 0) {
    $errors =  $errors . "Nie podano emaila\n";
}

if (!isset($_POST["password"]) || strlen(trim($_POST["password"])) == 0) {
    $errors =  $errors . "Nie podano hasła\n";
}

if (!empty($errors)) {
    goToLocationWithError($locationLogin, nl2br($errors));
}

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

if (!$email || strlen($email) > 255) {
    $errors =  $errors . "Wprowadzony przez ciebie email nie spełnia warunków\n";
    goToLocationWithError($locationLogin, nl2br($errors));
}

$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if (strlen($errors) == 0 && strlen($password) < 255) {

    $clientModel = new ClientModel($pdo);
    $clientData = $clientModel->getClientByEmail($email);

    if (!$clientData) {
        $errors =  $errors . "Walidacja nie powiodła się, wprowadź poprawne dane\n";
        setAlertInfo(nl2br($errors), DANGER);
        header($locationLogin);
        exit();
    }

    if (password_verify($password, $clientData["password"])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["clientId"] = $clientData["id"];
        $_SESSION["firstName"] = $clientData["first_name"];
        $_SESSION["lastName"] = $clientData["last_name"];
        $_SESSION["email"] = $clientData["email"];
        $_SESSION["role"] = $clientData["role"];
        $basketModel = new BasketModel($pdo);
        $_SESSION["basketCount"] = $basketModel->countItemsUserBasket($clientData["id"]);
        if ($_SESSION["role"] === "ADMIN") {
            goToLocationWithSuccess("location: ../admin/index.php", LOGIN_CLIENT_SUCCESS);
        } else {
            goToLocationWithSuccess("location: ../menu.php", LOGIN_CLIENT_SUCCESS);
        }


        goToLocationWithSuccess("location: ../menu.php", LOGIN_CLIENT_SUCCESS);
    }
}

$errors =  $errors . "Walidacja nie powiodła się, wprowadź poprawne dane\n";
goToLocationWithError($locationLogin, nl2br($errors));
