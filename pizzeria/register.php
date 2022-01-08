<?php

require_once "config.php";

session_start();

if (redirectIfUserIsLoggedIn()) {
    exit();
}

try {
    require_once "header.php";
    require_once "helpers/alert.php";
    require_once "views/register-form.php";
    require_once "footer.php";
} catch (PDOException $exp) {
    goToLocationWithError("location: register.php", DATABASE_EXCEPTION);
}
