<?php

require_once "helpers/utils.php";
require_once "config.php";
require_once "helpers/messages.php";
require_once "helpers/alert-types.php";
require_once "models/OrderModel.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";

try {
    $clientId = $_SESSION["clientId"];
} catch (PDOException $exp) {
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    include "helpers/alert.php";
}
require_once "footer.php";
