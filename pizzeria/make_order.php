<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}
try {
    if (isset($_GET["addressId"]) && isset($_GET["informationForCourier"])) {
        $sql = "INSERT INTO `order` (client_id, address_id, information_for_courier, order_status_id) 
        VALUES(:clientId, :addressId, :informationForCourier, 1)";


        // Tworzenie instacji zamowienia
        // TODO trim oraz filter_input
        $clientId = $_SESSION["clientId"];
        $addressId = $_GET["addressId"];
        $informationForCourier = $_GET["informationForCourier"];

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":informationForCourier", $informationForCourier, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            setAlertInfo(ORDER_SAVE_ERROR, "danger");
            header("location: orders.php");
            exit();
        }

        // Dodawanie itemkom z koszyka id zamówienia
        $orderId = $pdo->lastInsertId();
        echo $orderId;
        $sql = "UPDATE basket SET is_realised = true, order_id = :orderId 
                WHERE client_id = :clientId 
                AND is_realised = false";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            setAlertInfo(ORDER_SAVE_ERROR, "danger");
            header("location: orders.php");
            exit();
        }
    }
    setAlertInfo(ORDER_SAVE_SUCCESS, "success");
    header("location: orders.php");
    exit();
} catch (PDOException $exp) {
    echo $exp->getMessage();
}
