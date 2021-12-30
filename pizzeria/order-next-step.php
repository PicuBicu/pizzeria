<?php

require_once "config.php";

session_start();
// Zakładamy ze adres jest wiec listujemy wszystkie dostępne
$sql = "SELECT * FROM client_address WHERE client_id = :clientId";
try {
    if ($stmt = $pdo->prepare($sql)) {
        $clientId = $_SESSION["clientId"];
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
    }
} catch (PDOException $exp) {
    echo "TODO: address";
}
?>
<?php require_once "header.php" ?>
<?php require_once "helpers/alert.php" ?>

<form action="order-summary.php" method="post">
    <label for="addressId">Wybierz adres dostawy: </label>
    <select name="addressId" class="form-control mb-4">
        <?php while ($row = $stmt->fetch()) : ?>
            <option value=<?= $row["id"] ?>><?= $row["street"] . " " . $row["house_number"] . " " . $row["city"] ?></option>
        <?php endwhile; ?>
    </select>
    <label for="informationForCourier">Informacje dla kuriera</label>
    <textarea class="form-control" name="informationForCourier" placeholder="Max 255 znaków"></textarea>
    <button type="submit" class="btn btn-primary">Złóż zamówienie</button>
</form>

<?php require_once "footer.php"; ?>