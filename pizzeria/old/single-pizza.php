<?php

require_once "config.php";

// Zwraca jedną pizze spełniająca warunek foodId = id podane w pathParam
$sql = "SELECT f.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients
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
            AND f.id = skl.x
            AND f.id = :foodId";

// Pobieranie konkretnej pizzy
try {
    if ($_GET["foodId"]) {
        $foodId = $_GET["foodId"];
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
            } else {
                echo "Coś poszło nie tak ... Spróbuj ponownie później";
            }
        } else {
            echo "Coś poszło nie tak ... Spróbuj ponownie później";
        }
        unset($stmt);
    } else {
        echo "Coś poszło nie tak ... Spróbuj ponownie później";
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}

?>

<!-- Formularz wyboru ilość oraz rozmiaru danej pizzy przekierowuje nas do add_to_basket.php-->
<div class="container">
    <div class="row">
        <div class="my-5">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-xl-5 text-center">
                        <img class="img-fluid" src="/img/<?php echo $row["name"] ?>.jpg" style="min-width:200px; min-height:200px" />
                    </div>
                    <div class="col-xl-7">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["name"] ?></h4>
                            <p class="card-text"><?php echo $row["ingredients"] ?></p>
                            <form action="add_to_basket.php?foodId=<?php echo $foodId ?>" method="post">
                                <div class="hstack gap-2 mb-2">
                                    <label class="form-label" for="size" style="width: 100px">Rozmiar: </label>
                                    <select class="form-select form-select" name="size" style="width: 125px">
                                        <option value="mała">Mała <?php echo $row["mała"] ?> zł</option>
                                        <option selected value="średnia">Średnia <?php echo $row["średnia"] ?> zł</option>
                                        <option value="duża">Duża <?php echo $row["duża"] ?> zł</option>
                                    </select>
                                </div>
                                <div class="hstack gap-2 mb-2">
                                    <label class="form-label" for="quantity" style="width: 100px">Ilość: </label>
                                    <input type="number" id="quantity" name="quantity" class="form-control mb-2" style="width: 125px" min="1" max="5" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Dodaj do koszyka</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>