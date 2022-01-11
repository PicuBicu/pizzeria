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

    if (!$basketModel->setOrderIdInBasket($clientId, $orderId)) {
        $pdo->rollBack();
        goToLocationWithError($location, ORDER_SAVE_ERROR);
    }

    $pdo->commit();
    $_SESSION["basketCount"] = 0;

    $clientModel = new ClientModel($pdo);
    $chosenMail = $clientModel->getEmailByClientId($clientId, $contactDataId)["email"];
    if (isset($_POST["confirmation"]) && $_POST["confirmation"] === "on") {
        echo $chosenMail;
        $from  = "From: iomail2021@gmail.com \r\n";
        $from .= 'MIME-Version: 1.0' . "\r\n";
        $from .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $title = "Potwierdzenie zamówienia";
        $message = "<html>
        <head>
        </head>
        <body>
        <b>Potwierdzamy odebranie zamówienia o id $orderId</b><br/>
        </body>
        </html>";
        if (mail($chosenMail, $title, $message, $from)) {
            goToLocationWithSuccess($location, "Poprawnie wysłano e-mail");
        } else {
            goToIndexWithError($location, "Wystąpił nieoczekiwany błąd, spróbuj jeszcze raz...");
        }
    }
    goToLocationWithSuccess($location, ORDER_SAVE_SUCCESS);
} else if (
    isset($_POST["cancelOrder"])
) {
    goToLocationWithSuccess($location, ORDER_HAS_BEEN_CANCELLED);
}
goToLocationWithError($location, ORDER_SAVE_ERROR);
