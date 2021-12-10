<?php

require_once "../config.php";

if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
}

try {

    $sql = "SELECT f.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients
    FROM basket, food AS f,
    (SELECT food_id, price FROM food_size WHERE name='mała') AS m, 
    (SELECT food_id, price FROM food_size WHERE name='średnia') AS s,
    (SELECT food_id, price FROM food_size WHERE name='duża') AS d,
    (SELECT f.id AS x, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') 
    AS ingredients FROM food AS f, ingredients AS i, storage AS s 
    WHERE s.food_id = f.id AND s.ingredient_id = i.id 
    GROUP by f.id) AS skl
    WHERE f.id = m.food_id
    AND f.id = s.food_id
    AND f.id = d.food_id
    AND f.id = skl.x
    AND basket.food_id = f.id
    AND basket.client_id = :clientId";
    if ($stmt = $pdo->prepare($sql)) {
        $clientId = $_SESSION["clientId"];
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo
            "<h3>Zamówienie</h3>
            <form action='order.php' method='post'>
            </form>
            <ol class='list-group list-group-numbered'>";
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $small = $row['mała'];
                    $medium = $row['średnia'];
                    $large = $row['duża'];
                    $ingredients = $row["ingredients"];
                    echo
                    "<li class='list-group-item d-flex justify-content-between align-items-start'>
                        <div class='ms-2 me-auto'>
                            <div class='fw-bold'>$name</div>
                            <div>$ingredients</div>
                        </div>";
                    echo
                    "<label for='quantity'>Ilość: </label>
                    <input class='form-label' type='number' id='quantity' name='quantity[]' min='1' max='5' value='1'>";
                    echo
                    "<div class='col-xs-2'>
                        <select class='form-select form-select-sm mb-12' name='size[]'>
                            <option value='mała'>Mała - $small zł</option>
                            <option selected value='średnia'>Średnia - $medium zł</option>
                            <option value='duża'>Duża - $large zł</option>;
                        <select>
                    </div>
                    <button type='button' class='btn btn-danger'><a href='../delete_from_basket.php?foodId=$id'>Usuń</a></button>
                    </li>";
                }
                echo "</ol>";
            } else {
                echo "<p>Brak wybranych produktów<p>";
            }
        }
        unset($stmt);
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
