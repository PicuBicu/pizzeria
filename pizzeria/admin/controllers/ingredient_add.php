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

function goToIngredientsWithError()
{
    setAlertInfo(INGREDIENT_ADD_ERROR, DANGER);
    header("location: ../index.php");
    exit();
}

function goToIngredientsWithSuccess()
{
    setAlertInfo(INGREDIENT_ADD_SUCCESS, SUCCESS);
    header("location: ../index.php");
    exit();
}

if (
    isset($_POST["name"])
) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

    if (!$name) {
        goToIngredientsWithError();
    }

    $foodModel = new IngredientModel($pdo);
    if ($foodModel->addIngredient($name)) {
        goToIngredientsWithSuccess();
    }
}

goToIndexWithError();
