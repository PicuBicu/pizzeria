<?php

require_once "../config.php";
require_once "../helpers/alert-types.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/AddressModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

function validateAddressField($field)
{
    if (isset($field) && strlen(trim($field)) < 255) {
        return true;
    }
    return false;
}

function goToOrdersWithError($location)
{
    setAlertInfo(ADDRESS_SAVE_ERROR, DANGER);
    header($location);
    exit();
}

if (
    validateAddressField($_POST["street"]) &&
    validateAddressField($_POST["houseNumber"]) &&
    validateAddressField($_POST["city"])
) {
    $street = filter_input(INPUT_POST, "street", FILTER_SANITIZE_STRING);
    $houseNumber = filter_input(INPUT_POST, "houseNumber", FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);

    if (!$street || !$houseNumber || !$city) {
        goToOrdersWithError($location);
    }

    $clientId = $_SESSION["clientId"];

    $addressModel = new AddressModel($pdo);
    if ($addressModel->addNewAddress($clientId, $street, $houseNumber, $city)) {
        setAlertInfo(ADDRESS_SAVE_SUCCESS, SUCCESS);
        header($location);
        exit();
    }
}
goToOrdersWithError($location);
