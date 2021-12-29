<?php

require_once "config.php";
require_once "helpers/messages.php";
require_once "helpers/utils.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

try {
    if (isset($_GET["foodSizeId"])) {
        echo $_GET["foodSizeId"];
        $foodSizeId = $_GET["foodSizeId"];
        $clientId = $_SESSION["clientId"];
        $sql = "DELETE FROM basket WHERE basket.client_id = :clientId AND basket.food_size_id = :foodSizeId";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            $stmt->bindParam(":foodSizeId", $foodSizeId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                setAlertInfo(DELETE_FROM_BASKET_SUCCESS, "success");
                header("location: orders.php");
                exit();
            }
        }
        unset($stmt);
    }
    setAlertInfo(DELETE_FROM_BASKET_ERROR, "danger");
    header("location: orders.php");
    unset($pdo);
    exit();
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, "warning");
    header("location: orders.php");
    exit();
}
