<?php

require_once "helpers/utils.php";
require_once "config.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

require_once "header.php";
require_once "helpers/alert.php";
?>
<!-- TODO podsumowanie zamówienia tabela nie do zmienienia oraz informacje o wybranym adresie oraz informacji dla kuriera -->
<a href="make_order.php?addressId=<?= $_POST["addressId"] ?>&informationForCourier=<?= $_POST["informationForCourier"] ?>"><button>
        Złóż zamówienie
    </button></a>
<button>
    <a href="orders.php">Anuluj</a>
</button>

<?php require_once "footer.php"; ?>