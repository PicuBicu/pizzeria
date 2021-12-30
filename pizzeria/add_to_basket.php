<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

try {
    if (isset($_GET["foodId"]) && isset($_POST["quantity"]) && isset($_POST["size"])) {
        $quantity = $_POST["quantity"];
        $size = $_POST["size"];
        $foodId = $_GET["foodId"];
        $clientId = $_SESSION["clientId"];
        $foodSizeId = "";

        // Jeżeli podany produkt już jest w koszyku to użytkownik powróci do menu
        $sql = "SELECT basket.food_size_id AS id FROM basket, food_size 
            WHERE client_id = :clientId 
            AND food_size.id = basket.food_size_id
            AND food_size.food_id = :foodId
            AND food_size.name = :size
            AND basket.order_id = NULL";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            $stmt->bindParam(":size", $size, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($stmt->rowCount() > 0) {
                    setAlertInfo(PRODUCT_ALREADY_IN_BASKET, "warning");
                    header("location: menu.php#foodId=$foodId");
                    exit();
                }
            } else {
                setAlertInfo(ADD_TO_BASKET_ERROR, "danger");
                header("location: menu.php#foodId=$foodId");
                exit();
            }
        }

        // Szukanie id pizzy o danym rozmiarze
        $sql = "SELECT id AS food_size_id 
            FROM food_size 
            WHERE name = :size 
            AND food_id = :foodId";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            $stmt->bindParam(":size", $size, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($stmt->rowCount() < 0) {
                    setAlertInfo(CANNOT_FIND_PRODUKT, "warning");
                    header("location: menu.php#foodId=$foodId");
                    exit();
                } else {
                    $foodSizeId = $row["food_size_id"];
                }
            } else {
                setAlertInfo(ADD_TO_BASKET_ERROR, "danger");
                header("location: menu.php#foodId=$foodId");
                exit();
            }
        }

        // Wstawianie pizzy do koszyka
        $sql = "INSERT INTO basket (client_id, food_size_id, quantity) 
            VALUES(:clientId, :foodSizeId, :quantity)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":foodSizeId", $foodSizeId, PDO::PARAM_INT);
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            if ($stmt->execute()) {
                setAlertInfo(ADD_TO_BASKET_SUCCESS, "success");
                header("location: menu.php#foodId=$foodId");
                exit();
            }
        }
        unset($stmt);
    }
    setAlertInfo(ADD_TO_BASKET_ERROR, "danger");
    header("location: menu.php#foodId=$foodId");
    unset($pdo);
    exit();
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, "danger");
    header("location: menu.php#foodId=$foodId");
    exit();
}
