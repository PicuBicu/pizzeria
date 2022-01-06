<?php

require_once "../config.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/AddressModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

if (
    validateAddressField($_POST["street"]) &&
    validateAddressField($_POST["houseNumber"]) &&
    validateAddressField($_POST["city"])
) {
    $street = filter_input(INPUT_POST, "street", FILTER_SANITIZE_STRING);
    $houseNumber = filter_input(INPUT_POST, "houseNumber", FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);

    if (!$street || !$houseNumber || !$city) {
        goToLocationWithError($location, ADDRESS_SAVE_ERROR);
    }

    $clientId = $_SESSION["clientId"];
    $addressModel = new AddressModel($pdo);

    if ($addressModel->addNewAddress($clientId, $street, $houseNumber, $city)) {
        goToLocationWithSuccess($location, ADDRESS_SAVE_SUCCESS);
    }
}
goToLocationWithError($location, ADDRESS_SAVE_ERROR);
