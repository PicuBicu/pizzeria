<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";

session_start();

try {
    // Aktualizacja koszyka
    if (isset($_POST["quantity"]) && isset($_POST["id"])) {
        $quantities = $_POST["quantity"];
        $ids = $_POST["id"];
        $clientId = $_SESSION["clientId"];
        $len = count($quantities);
        for ($i = 0; $i < $len; $i++) {
            $sql = "UPDATE basket 
                SET quantity = :quantity 
                WHERE food_size_id = :foodSizeId 
                AND client_id = :clientId";
            if ($stmt = $pdo->prepare($sql)) {
                echo $quantities[$i];
                $stmt->bindParam(":quantity", $quantities[$i], PDO::PARAM_INT);
                $stmt->bindParam(":foodSizeId", $ids[$i], PDO::PARAM_INT);
                $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    setAlertInfo(BASKET_SAVE_ERROR, "danger");
                }
            }
            unset($stmt);
        }
        if (!isset($_SESSION["alertMessage"])) {
            setAlertInfo(BASKET_SAVE_SUCCESS, "success");
        }
        header("location: orders.php");
        unset($pdo);
        exit();
    }
} catch (PDOException $exp) {
    // "TODO: make order"
    echo "TODO: make order";
    echo $exp->getMessage();
}
