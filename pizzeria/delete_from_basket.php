<?php

require_once 'config.php';

session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: login.php");
}

try {
    if ($_GET['foodId']) {
        $foodId = $_GET['foodId'];
        $clientId = $_SESSION['clientId'];
        $sql = 'DELETE FROM basket WHERE client_id = :clientId AND food_id = :foodId';
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
            $stmt->bindParam(':foodId', $foodId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                header('location: components/orders.php');
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
