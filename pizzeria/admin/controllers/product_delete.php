<?php

require_once "../../config.php";
require_once "../../helpers/messages.php";
require_once "../../helpers/alert-types.php";
require_once "../../helpers/utils.php";
require_once "../../models/FoodModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

if (isset($_GET["foodId"])) {

    $foodSizeId = filter_input(INPUT_GET, "foodId", FILTER_SANITIZE_NUMBER_INT);
    $clientId = $_SESSION["clientId"];
    $foodModel = new FoodModel($pdo);
    if ($foodModel->deleteProductById($foodSizeId)) {
        setAlertInfo(PRODUCT_DELETE_SUCCESS, SUCCESS);
        header("location: ../index.php");
        exit();
    }
}

setAlertInfo(PRODUCT_DELETE_ERROR, DANGER);
header("location: ../index.php");
exit();
