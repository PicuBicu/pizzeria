<?php

require_once "../../config.php";
require_once "../../helpers/messages.php";
require_once "../../helpers/alert-types.php";
require_once "../../helpers/utils.php";
require_once "../../models/IngredientModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

function goToIngredientsWithError()
{
    setAlertInfo(INGREDIENT_UPDATE_ERROR, DANGER);
    header("location: ../ingredients.php");
    exit();
}

function goToIngredientsWithSuccess()
{
    setAlertInfo(INGREDIENT_UPDATE_SUCCESS, SUCCESS);
    header("location: ../ingredients.php");
    exit();
}

if (
    isset($_GET["id"])
    && isset($_POST["name"])
) {
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

    if (!$name || !$id) {
        goToIngredientsWithError();
    }

    $ingredientModel = new IngredientModel($pdo);
    if ($ingredientModel->updateIgredientById($id, $name)) {
        goToIngredientsWithSuccess();
    }
}

goToIndexWithError();
