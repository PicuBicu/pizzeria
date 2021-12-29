<?php
require_once "config.php";
require_once "helpers/messages.php";
require_once "helpers/utils.php";

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
        if ($stmt->execute()) {
?>
            <div class="row g-4">
                <?php while ($row = $stmt->fetch()) : ?>
                    <div class="col" id=<?php echo $row["id"] ?>>
                        <a href="food.php?foodId=<?php echo $row["id"] ?>">
                            <div class="card" style="min-height: 285px;">
                                <img src="/img/<?php echo $row["name"] ?>.jpg" class="card-img-top" style="height: 125px; width: 200px" alt=<?php echo $row["name"] ?>>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row["name"] ?></h5>
                                    <p class="card-text"><?php echo $row["ingredients"] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endwhile; ?>
            </div>
<?php
        }
        unset($stmt);
    }
} catch (PDOException $exp) {
    // TODO: pizzas pdo error
    echo "TODO pizzas";
}
?>