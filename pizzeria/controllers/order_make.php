<?php

require_once "../config.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../models/OrderModel.php";
require_once "../models/BasketModel.php";
require_once "../models/ClientModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

if (
    isset($_POST["addressId"]) &&
    isset($_POST["contactDataId"]) &&
    isset($_POST["makeOrder"])
) {
    $contactDataId = filter_input(INPUT_POST, "contactDataId", FILTER_SANITIZE_NUMBER_INT);
    $addressId = filter_input(INPUT_POST, "addressId", FILTER_SANITIZE_NUMBER_INT);
    $informationForCourier = filter_input(INPUT_POST, "informationForCourier", FILTER_SANITIZE_STRING);
    $clientId = $_SESSION["clientId"];

    if (!$informationForCourier) {
        $informationForCourier = "";
    }

    if (!$addressId && !$contactDataId || strlen($informationForCourier) > 255) {
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $orderModel = new OrderModel($pdo);
    $pdo->beginTransaction();

    if (!$orderModel->addNewOrder($clientId, $addressId, $contactDataId, $informationForCourier)) {
        $pdo->rollBack();
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $orderId = $pdo->lastInsertId();
    $basketModel = new BasketModel($pdo);
    $foodList = $basketModel->getProductsFromBasket($clientId);

    if (!$basketModel->setOrderIdInBasket($clientId, $orderId)) {
        $pdo->rollBack();
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $pdo->commit();
    $_SESSION["basketCount"] = 0;

    $clientModel = new ClientModel($pdo);
    $chosenMail = $clientModel->getEmailByClientId($clientId, $contactDataId)["email"];
    if (isset($_POST["confirmation"]) && $_POST["confirmation"] === "on") {
        $blocked = true;
        if ($foodList && sendMailTo($chosenMail, $foodList, $orderId)) {
            goToLocationWithSuccess($location, EMAIL_SEND_SUCCESS);
        } else {
            goToIndexWithError($location, EMAIL_SEND_ERROR);
        }
    }
    goToLocationWithSuccess($location, ORDER_SAVE_SUCCESS);
} else if (
    isset($_POST["cancelOrder"])
) {
    goToLocationWithSuccess($location, ORDER_HAS_BEEN_CANCELLED);
}
goToLocationWithError($location, ORDER_SAVE_ERROR);
