<?php

require_once "helpers/messages.php";
require_once "helpers/utils.php";
require_once "helpers/alert-types.php";

define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "pizzeria");

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // TODO: header to special error page
    setAlertInfo(DATABASE_EXCEPTION, DANGER);
    exit();
}
