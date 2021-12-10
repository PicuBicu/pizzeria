<?php

require_once "config.php";

session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: login.php");
}

try {
    if (isset($_GET["foodId"])) {
        $foodId = $_GET["foodId"];
        $clientId = $_SESSION["clientId"];

        $sql = "SELECT * FROM basket WHERE client_id = :clientId AND food_id = :foodId";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                if ($stmt->fetch()) {
                    if ($stmt->rowCount() > 0) {
                        header("location: components/menu.php#$foodId");
                        exit();
                    }
                } else {
                    header("location: components/menu.php#$foodId");
                }
            }
        }

        $sql = "INSERT INTO basket(client_id, food_id) VALUES(:clientId, :foodId)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                // header("location: components/menu.php#$foodId");
            } else {
                echo "Coś poszło nie tak ... Spróbuj ponownie później";
            }
        }
        unset($stmt);
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
