<?php

require_once "../../config.php";
require_once "../../helpers/messages.php";
require_once "../../helpers/alert-types.php";
require_once "../../helpers/utils.php";
require_once "../../models/FoodModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

redirectIfNotEnoughPermisions();

function goToIndexWithError()
{
    setAlertInfo(PRODUCT_ADD_ERROR, DANGER);
    header("location: ../index.php");
    exit();
}

function goToIndexWithSuccess()
{
    setAlertInfo(PRODUCT_ADD_SUCCESS, SUCCESS);
    header("location: ../index.php");
    exit();
}

function parseIngredients(array $ingredients)
{
    $ingredientsParsed = [];
    $length = count($ingredients);
    for ($i = 0; $i < $length; $i++) {
        $data = filter_var($ingredients[$i], FILTER_SANITIZE_NUMBER_INT);
        if (!$data) {
            goToIndexWithError();
        }
        $ingredientsParsed[] = $data;
    }
    return $ingredientsParsed;
}

if (
    isset($_POST["name"]) &&
    isset($_POST["small"]) &&
    isset($_POST["average"]) &&
    isset($_POST["big"]) &&
    isset($_POST["ingredients"])
) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $small = filter_input(INPUT_POST, "small", FILTER_SANITIZE_NUMBER_INT);
    $average = filter_input(INPUT_POST, "average", FILTER_SANITIZE_NUMBER_INT);
    $big = filter_input(INPUT_POST, "big", FILTER_SANITIZE_NUMBER_INT);
    $ingredientsParsed = parseIngredients($_POST["ingredients"]);
    $uploadFile = filter_input(INPUT_POST, "uploadFile", FILTER_SANITIZE_STRING);

    if (!$name || !$small || !$average || !$big || count($ingredientsParsed) == 0) {
        goToIndexWithError();
    }

    // START OF TRANSACTION
    $pdo->beginTransaction();
    $foodModel = new FoodModel($pdo);
    if (!$foodModel->addProduct($name)) {
        $pdo->rollBack();
        goToIndexWithError();
    }

    $foodId = $pdo->lastInsertId();
    if (!$foodModel->addProductPrices($foodId, $small, $average, $big)) {
        $pdo->rollBack();
        goToIndexWithError();
    }

    if (!$foodModel->addProductIngredients($foodId, $ingredientsParsed)) {
        $pdo->rollBack();
        goToIndexWithError();
    }

    $location = '../../img/';
    $tempName = $_FILES['uploadFile']['tmp_name'];

    if (
        !empty($tempName)
        && $_FILES['uploadFile']['type'] == "image/jpeg"
        && $_FILES["uploadFile"]["size"] < 50000
        && move_uploaded_file($tempName, $location . $name . ".jpg")
    ) {
        $pdo->commit();
        goToIndexWithSuccess();
    }
}

// END OF TRANSACTION
$pdo->rollBack();
goToIndexWithError();
