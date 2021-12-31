<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "models/BasketModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

if (isset($_POST["quantity"]) && isset($_POST["id"])) {
    $quantities = [];
    $clientId = $_SESSION["clientId"];
    $ids = [];

    foreach ($_POST["quantity"] as $row) {
        $quantities[] = filter_var($row, FILTER_SANITIZE_NUMBER_INT);
        if ($row > 5 || $row < 1) {
            setAlertInfo(QUANTITY_OUT_OF_RANGE, WARNING);
            header("location: orders.php");
            exit();
        }
    }

    foreach ($_POST["id"] as $row) {
        $ids[] = filter_var($row, FILTER_SANITIZE_NUMBER_INT);
    }

    $basketModel = new BasketModel($pdo);
    if (!$basketModel->updateBasket($clientId, $quantities, $ids)) {
        setAlertInfo(BASKET_SAVE_ERROR, DANGER);
        header("location: orders.php");
        exit();
    }

    setAlertInfo(BASKET_SAVE_SUCCESS, SUCCESS);
    header("location: orders.php");
    exit();
}
setAlertInfo(BASKET_SAVE_ERROR, DANGER);
header("location: orders.php");
exit();
