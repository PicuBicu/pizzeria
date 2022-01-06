<?php

require_once "../config.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../helpers/alert-types.php";
require_once "../models/FoodModel.php";
require_once "../models/IngredientModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

function parseIgredients(string $ingredients)
{
    return explode(", ", $ingredients);
}

require_once "common/header.php";
include "../helpers/alert.php";

try {
    if (isset($_GET["action"])) {
        $ingredientModel = new IngredientModel($pdo);
        $foodModel = new FoodModel($pdo);
        if ($_GET["action"] === "add") {
            $ingredientsList = $ingredientModel->getAllIngredients();
            if ($ingredientsList) {
                require_once "views/food-add-form.php";
            }
        } else if ($_GET["action"] === "update" && isset($_GET["foodId"])) {
            $food = $foodModel->getProductWithDetailsById($_GET["foodId"]);
            $ingredientsList = $ingredientModel->getAllIngredients();
            $fromDatabase = parseIgredients($food["ingredients"]);
            if ($food && $ingredientsList) {
                require_once "views/food-update-form.php";
            }
        }
    } else {
        $foodModel = new FoodModel($pdo);
        $foodList = $foodModel->getAllProductsWithDetails();
        if ($foodList) {
            require_once "views/food-table.php";
        } else {
            setAlertInfo(PRODUCT_FETCH_ERROR, DANGER);
            include "../helpers/alert.php";
        }
    }
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    include "../helpers/alert.php";
}

require_once "../footer.php";
