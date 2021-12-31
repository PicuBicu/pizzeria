<h3>Koszyk</h3>
<form action="save_basket.php" method="post">
    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col">Nazwa</th>
                <th scope="col">Rozmiar</th>
                <th scope="col">Cena jedn. w zł</th>
                <th scope="col">Cena * ilość zł</th>
                <th scope="col">Ilość</th>
                <th scope="col">Przelicz</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foodList as $row) : ?>
                <tr>
                    <input class="form-control" type="text" style="visibility: hidden; display: none" name="id[]" value="<?= $row["id"] ?>">
                    <td>
                        <div class="fw-bold"><?= $row["name"] ?></div>
                        <div><?= $row["ingredients"] ?></div>
                    </td>
                    <td>
                        <?= $row["size_name"] ?>
                    </td>
                    <td class="price">
                        <?= $row["price"] ?>
                    </td>
                    <td class="fullPrice">
                        <?= $row["price"] * $row["quantity"] ?>
                    </td>
                    <td>
                        <?php if (!$blocked) : ?>
                            <input class="form-control quantity" style="width:min-content" type="number" name="quantity[]" min="1" max="5" value="<?= $row["quantity"] ?>">
                        <?php else : ?>
                            <?= $row["quantity"] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!$blocked) : ?>
                            <button type="button" class="btn btn-primary calculateButton">Przelicz</button>
                        <?php else : ?>
                            <?= "" ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!$blocked) : ?>
                            <button type="button" class="btn btn-danger"><a href="delete_from_basket.php?foodSizeId=<?= $row["id"] ?>">Usuń</a></button>
                        <?php else : ?>
                            <?= "" ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
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
    <button type="submit" name="saveBasket" class="btn btn-primary mb-2">Zapisz koszyk</button>
</form>