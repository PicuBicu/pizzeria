<?php
session_start();

require_once "helpers/alert-types.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";
require_once "header.php";
setAlertInfo(PAGE_NOT_FOUND, WARNING);
require_once "helpers/alert.php";
require_once "footer.php";
