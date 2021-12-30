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

// Display alert message when it's set in session
require_once "helpers/alert.php";
try {
    require_once "config.php";
    require_once "models/FoodModel.php";
    $foodModel = new FoodModel($pdo);
    $result = $foodModel->getAllProductsWithDetails();
    if (!$result) {
        // Display alert when query will return false
        setAlertInfo(PRODUCT_FETCH_ERROR, DANGER);
        require_once "helpers/alert.php";
    } else {
        // Display all products from database
        require_once "views/food.php";
    }
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    require_once "helpers/alert.php";
}

// Footer with scripts section
require_once "footer.php";
