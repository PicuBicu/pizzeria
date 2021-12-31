<?php

require_once "config.php";

// Sprawdzanie czy istnieje jakiś adres dostawy, który można wykorzystać
$sql = "SELECT * FROM client_address WHERE client_id = :clientId";
try {
    if ($stmt = $pdo->prepare($sql)) {
        $clientId = $_SESSION["clientId"];
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
    }
} catch (PDOException $exp) {
    echo "TODO: address";
}
?>

<!-- Jeżeli nie ma żadnego adresu to dodajemy formularz do podania adresu -->
<?php if ($stmt->rowCount() == 0) : ?>
    <h2>Wprowadź adres do dostawy</h2>
    <form action="add_new_adress.php" method="post">
        <label for="street">Ulica:</label>
        <input type="text" name="street" class="form-control" />
        <label for="houseNumber">Numer domu:</label>
        <input type="text" name="houseNumber" class="form-control" />
        <label for="city">Miejscowość:</label>
        <input type="text" name="city" class="form-control" />
        <button type="submit">Zapisz adres</button>
    </form>
<?php else : ?>
    <button type="submit" class="btn btn-primary"><a href="order-next-step.php">Złóż zamówienie</a></button>
<?php endif; ?>