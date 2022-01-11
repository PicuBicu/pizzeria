<?php

require_once "../config.php";
require_once "../models/IngredientModel.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../models/OrderModel.php";
require_once "../models/BasketModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

require_once "common/header.php";
include "../helpers/alert.php";

try {
    $orderModel = new OrderModel($pdo);
    $basketModel = new BasketModel($pdo);
    if (isset($_GET["orderId"])) {

        $orderId = filter_input(INPUT_GET, "orderId", FILTER_SANITIZE_NUMBER_INT);

        if (!$orderId) {
            goToLocationWithWarning("location: orders.php", ORDER_NOT_FOUND);
        }

        $orderItem = $orderModel->getOrderById($orderId);
        $basketList = $basketModel->getBasketByOrderId($orderId);

        if (!$orderItem || !$basketList) {
            goToLocationWithWarning("location: orders.php", ORDER_NOT_FOUND);
        }

        require_once "views/order-item.php";
    } else {
        $orderList = $orderModel->getAllOrders();
        $orderStatusesList = $orderModel->getAllStatuses();
        if ($orderList && $orderStatusesList) {
            require_once "views/orders-table.php";
        }
    }
} catch (PDOException $exp) {
    goToLocationWithError("location: orders.php", DATABASE_EXCEPTION);
}

require_once "../footer.php";
