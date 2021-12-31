<?php

require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";

// Not logged in user will be redirected to login page
session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

// Header with meta section
require_once "header.php";
require_once "helpers/alert.php";

// Display alert message when it's set in session
try {
    require_once "config.php";
    require_once "models/FoodModel.php";

    if (isset($_GET["foodId"])) {
        $foodModel = new FoodModel($pdo);
        $foodId = filter_input(INPUT_GET, 'foodId', FILTER_SANITIZE_NUMBER_INT);
        $foodDetails = $foodModel->getProductWithDetailsById($foodId);
        if (!$foodDetails) {
            // Display alert when query will return false
            setAlertInfo(CANNOT_FIND_PRODUCT, WARNING);
            header("location: menu.php#foodId=$foodId");
        } else {
            // Display product by id
            require_once "views/food-context.php";
        }
    } else {
        setAlertInfo(CANNOT_FIND_PRODUCT, WARNING);
        header("location: menu.php");
    }
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    header("location: menu.php");
}

// Footer with scripts section
require_once "footer.php";
