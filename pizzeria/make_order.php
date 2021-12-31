<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "models/OrderModel.php";
require_once "models/BasketModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

if (isset($_POST["addressId"]) && isset($_POST["makeOrder"])) {

    $addressId = filter_input(INPUT_POST, "addressId", FILTER_SANITIZE_STRING);
    $informationForCourier = filter_input(INPUT_POST, "informationForCourier", FILTER_SANITIZE_STRING);
    $clientId = $_SESSION["clientId"];

    $orderModel = new OrderModel($pdo);
    if (!$orderModel->addNewOrder($clientId, $addressId, $informationForCourier)) {
        setAlertInfo(ORDER_SAVE_ERROR, DANGER);
        header("location: orders.php");
        exit();
    }

    $orderId = $pdo->lastInsertId();
    $basketModel = new BasketModel($pdo);
    if (!$basketModel->setOrderIdInBasket($clientId, $orderId)) {
        $orderModel->deleteOrderById($clientId, $orderId);
        setAlertInfo(ORDER_SAVE_ERROR, DANGER);
        header("location: orders.php");
        exit();
    }

    setAlertInfo(ORDER_SAVE_SUCCESS, SUCCESS);
    header("location: orders.php");
    exit();
} else if (isset($_POST["cancelOrder"])) {
    setAlertInfo(ORDER_HAS_BEEN_CANCELLED, SUCCESS);
    header("location: orders.php");
    exit();
}
setAlertInfo(ORDER_SAVE_ERROR, DANGER);
header("location: orders.php");
exit();
