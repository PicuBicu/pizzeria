<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "models/FoodModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
require_once "helpers/alert.php";

$location = "location: menu.php";

try {
    if (isset($_GET["foodId"])) {
        $foodModel = new FoodModel($pdo);
        $foodId = filter_input(INPUT_GET, 'foodId', FILTER_SANITIZE_NUMBER_INT);

        if (!$foodId) {
            goToLocationWithWarning($location, PRODUCT_NOT_FOUND);
        }

        $foodDetails = $foodModel->getProductWithDetailsById($foodId);

        if (!$foodDetails) {
            goToLocationWithWarning($location, PRODUCT_NOT_FOUND);
        }

        require_once "views/food-context.php";
    } else {
        goToLocationWithWarning($location, PRODUCT_NOT_FOUND);
    }
} catch (PDOException $exp) {
    require_once "footer.php";
    goToLocationWithError($location, DATABASE_EXCEPTION);
}

require_once "footer.php";
