<?php

require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
require_once "helpers/alert.php";

try {
    require_once "config.php";
    require_once "models/FoodModel.php";

    if (isset($_GET["foodId"])) {
        $foodModel = new FoodModel($pdo);
        $foodId = filter_input(INPUT_GET, 'foodId', FILTER_SANITIZE_NUMBER_INT);
        $foodDetails = $foodModel->getProductWithDetailsById($foodId);
        if (!$foodDetails) {
            setAlertInfo(PRODUCT_NOT_FOUND, WARNING);
            header("location: menu.php#foodId=$foodId");
            exit();
        } else {
            require_once "views/food-context.php";
        }
    } else {
        setAlertInfo(PRODUCT_NOT_FOUND, WARNING);
        header("location: menu.php");
        exit();
    }
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    header("location: menu.php");
    exit();
}

require_once "footer.php";
