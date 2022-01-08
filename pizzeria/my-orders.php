<?php

require_once "config.php";
require_once "models/IngredientModel.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "models/OrderModel.php";
require_once "models/BasketModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
include "helpers/alert.php";

$location = "location: my-orders.php";

try {
    $orderModel = new OrderModel($pdo);
    $basketModel = new BasketModel($pdo);
    $clientId = $_SESSION["clientId"];
    if (isset($_GET["orderId"])) {
        $orderId = filter_input(INPUT_GET, "orderId", FILTER_SANITIZE_NUMBER_INT);
        $orderItem = $orderModel->getClientOrderById($clientId, $orderId);
        $basketList = $basketModel->getBasketByOrderId($orderId);
        if (!$orderId || !$orderItem || !$basketList) {
            goToLocationWithWarning($location, ORDER_NOT_FOUND);
        } else {
            require_once "views/order-item.php";
        }
    } else {
        $orderList = $orderModel->getAllClientOrders($clientId);
        $orderStatusesList = $orderModel->getAllStatuses();
        require_once "views/orders-table.php";
    }
} catch (PDOException $exp) {
    goToLocationWithError($location, DATABASE_EXCEPTION);
}

require_once "footer.php";
