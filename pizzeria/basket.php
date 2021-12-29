<?php

require_once "config.php";
require_once "helpers/utils.php";
require_once "helpers/messages.php";

if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

try {
    $sql = "SELECT food_size.id, food_size.price, basket.quantity, f.name, skl.ingredients 
    FROM basket, food_size, food AS f, 
    ( SELECT f.id AS X, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') 
    AS ingredients 
    FROM food AS f, ingredients AS i, STORAGE AS s 
    WHERE s.food_id = f.id 
    AND s.ingredient_id = i.id 
    GROUP BY f.id ) AS skl 
    WHERE f.id = skl.x 
    AND food_size.food_id = f.id 
    AND basket.client_id = :clientId 
    AND basket.food_size_id = food_size.id;
    ";
    if ($stmt = $pdo->prepare($sql)) {
        $clientId = $_SESSION["clientId"];
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        if ($stmt->execute()) :
?>
            <h3>Zamówienie</h3>
            <form action="order.php" method="post">
                <?php if ($stmt->rowCount() > 0) : ?>
                    <table class="table rounded">
                        <thead>
                            <tr>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Cena jedn. w zł</th>
                                <th scope="col">Cena * ilość zł</th>
                                <th scope="col">Ilość</th>
                                <th scope="col">Przelicz</th>
                                <th scope="col">Usuń</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch()) : ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo $row["name"] ?></div>
                                        <div><?php echo $row["ingredients"] ?></div>
                                    </td>
                                    <td class="price">
                                        <?php echo $row["price"] ?>
                                    </td>
                                    <td class="fullPrice">
                                        <?php echo $row["price"] * $row["quantity"] ?>
                                    </td>
                                    <td>
                                        <input class="form-control quantity" style="width:min-content" type="number" name="quantity[]" min="1" max="5" value="<?php echo $row["quantity"] ?>">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary calculateButton">Przelicz</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger"><a href="delete_from_basket.php?foodSizeId=<?php echo $row["id"] ?>">Usuń</a></button>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <script>
                        const buttons = [...document.querySelectorAll(".calculateButton")];
                        const fullPrice = document.querySelectorAll(".fullPrice");
                        const price = document.querySelectorAll(".price");
                        const quantity = document.querySelectorAll(".quantity");
                        buttons.forEach((button, index) => button.addEventListener("click", (e) => {
                            fullPrice[index].textContent = (price[index].textContent * 1) * quantity[index].value;
                            e.preventDefault();
                        }));
                    </script>
                    <button type="submit">Złóż zamówienie</button>
                <?php else : ?>
                    <p>W koszyku nie ma jeszcze żadnych produktów</p>
                <?php endif; ?>
            </form>
<?php endif;
        unset($stmt);
    } else {
        setAlertInfo(CANNOT_PROCESS_USERS_BASKET, "warning");
    }
    unset($pdo);
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
?>