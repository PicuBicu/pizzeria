<?php

require_once "helpers/utils.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
require_once "helpers/alert.php";
require_once "basket.php";
require_once "address.php";
require_once "footer.php";
