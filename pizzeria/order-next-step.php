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

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Pizzeria / Zamówienia</title>
</head>

<body>
    <div class="container">

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

        <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="../js/bootstrap.js"></script>
</body>

</html>