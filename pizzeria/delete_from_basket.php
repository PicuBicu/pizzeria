<?php

require_once "config.php";

session_start();

if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: login.php");
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
                header("location: orders.php");
            } else {
                echo "Coś poszło nie tak ... Spróbuj ponownie później";
            }
        } else {
            echo "Coś poszło nie tak ... Spróbuj ponownie później";
        }
        unset($stmt);
    } else {
        echo "Coś poszło nie tak ... Spróbuj ponownie później";
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
