<?php

require_once "../../config.php";
require_once "../../helpers/messages.php";
require_once "../../helpers/alert-types.php";
require_once "../../helpers/utils.php";
require_once "../../models/OrderModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

$location = "location: ../orders.php";

if (
    isset($_GET["orderId"]) &&
    isset($_POST["orderStatusId"])
) {

    $orderStatusId = filter_input(INPUT_POST, "orderStatusId", FILTER_SANITIZE_NUMBER_INT);
    $orderId = filter_input(INPUT_GET, "orderId", FILTER_SANITIZE_NUMBER_INT);

    if (!$orderStatusId || !$orderId) {
        goToLocationWithError($location, ORDER_STATUS_CHANGE_ERROR);
    }

    $orderModel = new OrderModel($pdo);

    if ($orderModel->updateOrderStatusId($orderId, $orderStatusId)) {
        goToLocationWithSuccess($location, ORDER_STATUS_CHANGE_SUCCESS);
    }
}
goToLocationWithError($location, ORDER_STATUS_CHANGE_ERROR);
