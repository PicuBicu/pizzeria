<?php

require_once "../config.php";
require_once "../helpers/messages.php";
require_once "../helpers/utils.php";
require_once "../models/BasketModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

$location = "location: ../orders.php";

if (isset($_GET["foodSizeId"])) {

    $foodSizeId = filter_input(INPUT_GET, "foodSizeId", FILTER_SANITIZE_NUMBER_INT);
    $clientId = $_SESSION["clientId"];

    if (!$foodSizeId) {
        goToLocationWithError($location, BASKET_DELETE_PRODUCT_ERROR);
    }

    $basketModel = new BasketModel($pdo);

    if ($basketModel->deleteFromBasket($clientId, $foodSizeId)) {
        $_SESSION["basketCount"] = $_SESSION["basketCount"] - 1 <= 0 ? 0 : $_SESSION["basketCount"] -  1;
        goToLocationWithSuccess($location, BASKET_DELETE_PRODUCT_SUCCESS);
    }
}
goToLocationWithError($location, BASKET_DELETE_PRODUCT_ERROR);
