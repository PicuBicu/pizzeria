<?php


require_once "helpers/utils.php";
require_once "config.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "models/BasketModel.php";
require_once "models/AddressModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
include "helpers/alert.php";

try {
    $clientId = $_SESSION["clientId"];
    $basketModel = new BasketModel($pdo);
    $foodList = $basketModel->getProductsFromBasket($clientId);
    $foodListLength = count($foodList);
    $blocked = false;
    if ($foodListLength > 0) {
        require_once "views/basket.php";
        $addressModel = new AddressModel($pdo);
        $clientAddressesNum = $addressModel->getClientAddressesNumber($clientId);
        if ($clientAddressesNum <= 0) {
            require_once "views/new-address-form.php";
        } else {
            require_once "views/proccess-order.php";
        }
    } else {
        setAlertInfo(EMPTY_BASKET, WARNING);
        include "helpers/alert.php";
    }
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    include "helpers/alert.php";
}
require_once "footer.php";
