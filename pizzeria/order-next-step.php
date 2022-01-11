<?php

require_once "config.php";
require_once "helpers/alert-types.php";
require_once "helpers/messages.php";
require_once "helpers/utils.php";
require_once "models/AddressModel.php";
require_once "models/BasketModel.php";
require_once "models/ClientModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: orders.php";

try {
    require_once "header.php";
    $blocked = true;
    $basketModel = new BasketModel($pdo);
    $clientId = $_SESSION["clientId"];
    $foodList = $basketModel->getProductsFromBasket($clientId);

    if (!$foodList) {
        goToLocationWithWarning($location, BASKET_EMPTY);
    }

    require_once "views/basket-table.php";
    $addressModel = new AddressModel($pdo);
    $clientModel = new ClientModel($pdo);
    $addressesList = $addressModel->getClientAddresses($clientId);
    $contactDataList = $clientModel->getAllClientData($clientId);

    if (!$addressesList) {
        goToLocationWithWarning($location, ADDRESS_UNABLE_TO_SELECT);
    }

    if (!$contactDataList) {
        goToIndexWithError($location, CONTACT_DATA_UNABLE_TO_SELECT);
    }

    require_once "views/address-select-form.php";
    require_once "footer.php";
} catch (PDOException $exp) {
    goToLocationWithError($location, DATABASE_EXCEPTION);
}
