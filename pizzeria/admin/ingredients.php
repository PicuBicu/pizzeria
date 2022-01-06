<?php

require_once "../config.php";
require_once "../models/IngredientModel.php";
require_once "../helpers/utils.php";
require_once "../helpers/messages.php";
require_once "../helpers/alert-types.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

require_once "common/header.php";
include "../helpers/alert.php";

try {

    if (isset($_GET["action"])) {
        if ($_GET["action"] === "add") {
            require_once "views/ingredient-add-form.php";
        } else {
            if (isset($_GET["ingredientName"])) {
                $ingredientName = $_GET["ingredientName"];
                require_once "views/ingredient-update-form.php";
            }
        }
    } else {
        $ingredientModel = new IngredientModel($pdo);
        $ingredientsList = $ingredientModel->getAllIngredients();

        if ($ingredientsList) {
            require_once "views/ingredients-table.php";
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
