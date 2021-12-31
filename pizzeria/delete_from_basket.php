<?php

require_once "config.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "helpers/utils.php";
require_once "models/BasketModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

if (isset($_GET["foodSizeId"])) {
    $foodSizeId = filter_input(INPUT_GET, "foodSizeId", FILTER_SANITIZE_NUMBER_INT);
    $clientId = $_SESSION["clientId"];
    $basketModel = new BasketModel($pdo);
    if ($basketModel->deleteFromBasket($clientId, $foodSizeId)) {
        setAlertInfo(DELETE_FROM_BASKET_SUCCESS, SUCCESS);
        header("location: orders.php");
        exit();
    }
}
setAlertInfo(DELETE_FROM_BASKET_ERROR, DANGER);
header("location: orders.php");
exit();
