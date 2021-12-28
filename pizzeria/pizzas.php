<?php
require_once "config.php";

$sql = "SELECT  f.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients
        FROM food AS f,
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
        AND f.id = skl.x";

try {
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) { ?>
            <div class="row">
                <?php while ($row = $stmt->fetch()) : ?>
                    <div class="col-sm-3" id=<?php echo $row["id"] ?>>
                        <div class="card" style="width: 18rem;">
                            <img src="/img/pizza.jpg" class="card-img-top" height="100px" width="100px" alt=<?php echo $row["name"] ?>>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["name"] ?></h5>
                                <p class="card-text"><?php echo $row["ingredients"] ?></p>
                                <a href="add_to_basket.php?foodId=<?php echo $row["id"] ?>" class="btn btn-primary">Dodaj do koszyka</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
<?php
        }
        unset($stmt);
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
