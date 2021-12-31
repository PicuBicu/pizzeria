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
            setAlertInfo(CANNOT_FIND_PRODUCT, WARNING);
            header("location: menu.php#foodId=$foodId");
        } else {
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

require_once "footer.php";
