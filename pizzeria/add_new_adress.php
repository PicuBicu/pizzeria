<?php

require_once "config.php";

echo print_r($_POST);

function validateField($field)
{
    if (isset($field) && strlen(trim($field)) < 255) {
        return true;
    }
    return false;
}

if (
    validateField($_POST["street"]) &&
    validateField($_POST["houseNumber"]) &&
    validateField($_POST["city"])
) {
    $street = trim($_POST["street"]);
    $houseNumber = trim($_POST["houseNumber"]);
    $city = trim($_POST["city"]);

    $sql = "INSERT INTO client_address (client_id, street, house_number, city) VALUES (:clientId, :street, :houseNumber, :city)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":street", $street, PDO::PARAM_STR);
        $stmt->bindParam(":houseNumber", $houseNumber, PDO::PARAM_STR);
        $stmt->bindParam(":city", $city, PDO::PARAM_STR);
        $stmt->bindParam(":clientId", $_SESSION["clientId"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            setAlertInfo(ADDRESS_SAVE_SUCCESS, "success");
        }
    }
}
if (isset($_SESSION["alertMessage"])) {
    setAlertInfo(ADDRESS_SAVE_ERROR, "danger");
}
header("location: orders.php");
exit();
