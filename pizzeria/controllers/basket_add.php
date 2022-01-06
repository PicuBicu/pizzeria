<?php

require_once "../config.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../models/BasketModel.php";
require_once "../models/FoodModel.php";

session_start();

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$locationFoodDetails = "location: ../food-details.php?foodId=";
$locationMenu = "location: ../menu.php#foodId=";

if (
    isset($_GET["foodId"]) &&
    isset($_POST["quantity"]) &&
    isset($_POST["size"])
) {
    $quantity = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT);
    $size = filter_input(INPUT_POST, "size", FILTER_SANITIZE_STRING);
    $foodId = filter_input(INPUT_GET, "foodId", FILTER_SANITIZE_NUMBER_INT);
    $clientId = $_SESSION["clientId"];

    if (!$quantity || $quantity > 5 || $quantity < 1) {
        goToLocationWithWarning($locationFoodDetails . $foodId, ORDER_QUANTITY_OUT_OF_RANGE);
    }

    if (!$size || !$foodId || strlen($size) > 255) {
        goToLocationWithError($locationMenu . $foodId, BASKET_ADD_PRODUCT_ERROR);
    }

    $basketModel = new BasketModel($pdo);

    if ($basketModel->checkIfProductIsInBasket($clientId, $foodId, $size)) {
        goToLocationWithWarning($locationFoodDetails . $foodId, BASKET_ALREADY_HAS_THIS_PRODUCT);
    }

    $foodModel = new FoodModel($pdo);
    $foodSizeId = $foodModel->getFoodSizeIdByFoodId($foodId, $size);

    if (!$foodSizeId) {
        goToLocationWithError($locationMenu . $foodId, BASKET_ADD_PRODUCT_ERROR);
    }

    if ($basketModel->addNewProductToBasket($foodSizeId, $clientId, $quantity)) {
        $_SESSION["basketCount"] += 1;
        goToLocationWithSuccess($locationMenu . $foodId, BASKET_ADD_PRODUCT_SUCCESS);
    }
}
goToLocationWithError($locationMenu . $foodId, BASKET_ADD_PRODUCT_ERROR);
