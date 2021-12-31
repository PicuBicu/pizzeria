<?php

require_once "config.php";
require_once "helpers/alert-types.php";
require_once "helpers/messages.php";
require_once "helpers/utils.php";
require_once "models/AddressModel.php";
require_once "models/BasketModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

try {
    require_once "header.php";
    $blocked = true;
    $basketModel = new BasketModel($pdo);
    $clientId = $_SESSION["clientId"];
    $foodList = $basketModel->getProductsFromBasket($clientId);
    if (!$foodList) {
        setAlertInfo(EMPTY_BASKET, WARNING);
        header("location: orders.php");
        exit();
    }
    require_once "views/basket.php";

    $addressModel = new AddressModel($pdo);
    $addressesList = $addressModel->getClientAddresses($clientId);
    if (!$addressesList) {
        setAlertInfo(NO_ADDRESS_TO_SELECT, WARNING);
        header("location: orders.php");
        exit();
    }
    require_once "views/address-select-form.php";
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    header("location: orders.php");
    exit();
}

require_once "footer.php";
