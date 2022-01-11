<?php

require_once "../config.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/ClientModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

if (
    isset($_POST["phoneNumber"]) &&
    isset($_POST["email"])
) {
    $phoneNumber = filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    if (!$phoneNumber || !$email) {
        goToLocationWithError($location, CONTACT_DATA_SAVE_ERROR);
    }

    $clientId = $_SESSION["clientId"];
    $addressModel = new ClientModel($pdo);

    if ($addressModel->addContactData($clientId, $email, $phoneNumber)) {
        goToLocationWithSuccess($location, CONTACT_DATA_SAVE_SUCCESS);
    }
}
goToLocationWithError($location, CONTACT_DATA_SAVE_ERROR);
