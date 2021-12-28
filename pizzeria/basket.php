<?php

require_once "config.php";

if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
}

try {
    $sql = "SELECT food_size.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients FROM basket, food_size, food AS f, 
    (SELECT food_id, price FROM food_size WHERE name='mała') AS m, 
    (SELECT food_id, price FROM food_size WHERE name='średnia') AS s, 
    (SELECT food_id, price FROM food_size WHERE name='duża') AS d, 
    (SELECT f.id AS x, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') AS ingredients 
    FROM food AS f, ingredients AS i, storage AS s 
    WHERE s.food_id = f.id 
    AND s.ingredient_id = i.id 
    GROUP by f.id) AS skl 
    WHERE f.id = m.food_id 
    AND f.id = s.food_id 
    AND f.id = d.food_id 
    AND f.id = skl.x 
    AND food_size.food_id = f.id 
    AND basket.client_id = :clientId 
    AND basket.food_size_id = food_size.id";
?>
    <?php if ($stmt = $pdo->prepare($sql)) {
        $clientId = $_SESSION["clientId"];
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        if ($stmt->execute()) :
    ?>
            <h3>Zamówienie</h3>
            <form action="order.php" method="post">
                <ol class="list-group list-group-numbered">
                    <?php if ($stmt->rowCount() > 0) : ?>
                        <?php while ($row = $stmt->fetch()) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><?php echo $row["name"] ?></div>
                                    <div><?php echo $row["ingredients"] ?></div>
                                </div>
                                <label class="form-label" for="quantity">Ilość: </label>
                                <input class="form-control" type="number" id="quantity" name="quantity[]" min="1" max="5" value="1">

                                <button type="button" class="btn btn-danger"><a href="delete_from_basket.php?foodSizeId=<?php echo $row["id"] ?>">Usuń</a></button>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ol>
            </form>
    <?php endif;
        unset($stmt);
    } ?>
<?php
    unset($pdo);
} catch (PDOException $exp) {
    echo $exp->getMessage();
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
?>