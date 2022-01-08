<?php

require_once "../config.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/ClientModel.php";

session_start();

if (redirectIfUserIsLoggedIn()) {
    exit();
}

$locationRegister = "location: ../register.php";
$errors = "";

$fields = [
    "firstName" => [FILTER_SANITIZE_STRING, "Nie podano poprawnego imienia\n"],
    "lastName" => [FILTER_SANITIZE_STRING, "Nie podano poprawnego nazwiska\n"],
    "email" => [FILTER_SANITIZE_EMAIL, "Nie podano poprawnego emaila\n"],
    "phoneNumber" => [FILTER_SANITIZE_NUMBER_INT, "Nie podano poprawnego numeru telefonu\n"],
    "password" => [FILTER_SANITIZE_STRING, "Nie podano poprawnego hasła\n"],
    "confirmPassword" => [FILTER_SANITIZE_ENCODED, "Nie potwierdzono hasła\n"]
];

foreach ($fields as $key => $value) {
    if (
        !isset($_POST[$key]) ||
        strlen(trim($_POST[$key])) == 0 ||
        !filter_input(INPUT_POST, $key, $value[0])
    ) {
        $errors = $errors . $value[1];
    }
}

if (!empty($errors)) {
    goToLocationWithError($locationRegister, nl2br($errors));
}

$firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$phoneNumber = filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_NUMBER_INT);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);

if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
    $errors = $errors . "Podany email jest nieprawidłowy\n";
}

if ($password !== $confirmPassword) {
    $errors = $errors . "Wprowadzone hasło oraz jego potwierdznie nie sa tożsame\n";
}

if (!checkPasswordStrenth($password)) {
    $errors = $errors . "Silne hasło powinno zawierać conajmniej (8 znaków, jedną litere dużą, jedną małą, jedną liczbę oraz znak specjalny)\n";
}

if (!empty($errors)) {
    goToLocationWithError($locationRegister, nl2br($errors));
}

try {
    // TRANSACTION
    $pdo->beginTransaction();

    $clientModel = new ClientModel($pdo);

    if ($clientModel->checkIfEmailIsAlreadyTaken($email)) {
        $errors = $errors . "Podany email już istnieje";
        goToLocationWithError($locationRegister, nl2br($errors));
    }

    if (!$clientModel->addNewClient($firstName, $lastName, $password)) {
        $pdo->rollBack();
        goToLocationWithError($locationRegister, "Nie udało się dodać klienta do bazy danych");
    }

    $clientId = $pdo->lastInsertId();

    if (!$clientModel->addContactData($clientId, $email, $phoneNumber)) {
        $pdo->rollBack();
        goToLocationWithError($locationRegister, "Nie udało się dodać klienta do bazy danych");
    }

    $pdo->commit();
    unset($pdo);

    goToLocationWithSuccess($locationRegister, "Zarejestrowano pomyślnie");
} catch (PDOException $exp) {
}
