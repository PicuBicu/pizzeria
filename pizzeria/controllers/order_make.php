<?php

require_once "../config.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../models/OrderModel.php";
require_once "../models/BasketModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

if (
    isset($_POST["addressId"]) &&
    isset($_POST["makeOrder"])
) {
    $addressId = filter_input(INPUT_POST, "addressId", FILTER_SANITIZE_NUMBER_INT);
    $informationForCourier = filter_input(INPUT_POST, "informationForCourier", FILTER_SANITIZE_STRING);
    $clientId = $_SESSION["clientId"];

    if (!$informationForCourier) {
        $informationForCourier = "";
    }

    if (!$addressId || strlen($informationForCourier) > 255) {
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $orderModel = new OrderModel($pdo);
    $pdo->beginTransaction();

    if (!$orderModel->addNewOrder($clientId, $addressId, $informationForCourier)) {
        $pdo->rollBack();
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $orderId = $pdo->lastInsertId();
    $basketModel = new BasketModel($pdo);

    if (!$basketModel->setOrderIdInBasket($clientId, $orderId)) {
        $pdo->rollBack();
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $pdo->commit();
    $_SESSION["basketCount"] = 0;
    goToLocationWithSuccess($location, ORDER_SAVE_SUCCESS);
} else if (
    isset($_POST["cancelOrder"])
) {
    goToLocationWithSuccess($location, ORDER_HAS_BEEN_CANCELLED);
}
goToLocationWithError($location, ORDER_SAVE_ERROR);
