<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "models/BasketModel.php";
require_once "models/FoodModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

if (
    isset($_GET["foodId"]) &&
    isset($_POST["quantity"]) &&
    isset($_POST["size"])
) {

    $quantity = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT);

    if ($quantity > 5 || $quantity < 1) {
        setAlertInfo(QUANTITY_OUT_OF_RANGE, WARNING);
        header("location: food-details.php?foodId=$foodId");
        exit();
    }

    $size = filter_input(INPUT_POST, "size", FILTER_SANITIZE_STRING);
    $foodId = filter_input(INPUT_GET, "foodId", FILTER_SANITIZE_NUMBER_INT);
    $clientId = $_SESSION["clientId"];

    $basketModel = new BasketModel($pdo);

    if ($basketModel->checkIfProductIsInBasket($clientId, $foodId, $size)) {
        setAlertInfo(PRODUCT_ALREADY_IN_BASKET, WARNING);
        header("location: food-details.php?foodId=$foodId");
        exit();
    }

    $foodModel = new FoodModel($pdo);
    $foodSizeId = $foodModel->getFoodSizeIdByFoodId($foodId, $size);
    if (!$foodSizeId) {
        setAlertInfo(ADD_TO_BASKET_ERROR, "danger");
        header("location: menu.php#foodId=$foodId");
        exit();
    }

    if ($basketModel->addNewProductToBasket($foodSizeId, $clientId, $quantity)) {
        setAlertInfo(ADD_TO_BASKET_SUCCESS, SUCCESS);
        header("location: menu.php#foodId=$foodId");
        exit();
    }
}

setAlertInfo(ADD_TO_BASKET_ERROR, "danger");
header("location: menu.php#foodId=$foodId");
exit();
