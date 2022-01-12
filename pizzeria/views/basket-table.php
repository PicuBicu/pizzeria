<?php if (!$blocked) : ?>
    <form action="controllers/basket_save.php" method="post">
        <h3>Koszyk</h3>

    <?php endif; ?>
    <table class="table rounded">

        <thead>
            <tr>
                <th scope="col">Nazwa</th>
                <th scope="col">Rozmiar</th>
                <th scope="col">Cena jedn. w zł</th>
                <th scope="col">Cena * ilość zł</th>
                <th scope="col">Ilość</th>
                <?php if (!$blocked) : ?>
                    <th scope="col">Przelicz</th>
                    <th scope="col">Usuń</th>
                <?php endif; ?>
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
                    <?php if (!$blocked) : ?>
                        <td>
                            <input class="form-control quantity" style="width:min-content" type="number" name="quantity[]" min="1" max="5" value="<?= $row["quantity"] ?>">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary calculateButton">Przelicz</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger"><a href="controllers/basket_delete.php?foodSizeId=<?= $row["id"] ?>">Usuń</a></button>
                        </td>
                    <?php else : ?>
                        <td>
                            <?= $row["quantity"] ?>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td>Suma</td>
                <td class="sum"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <script>
        function calcNewSum(arr) {
            return arr.reduce((sum, val) => sum + (val.textContent * 1), 0);
        }
        const sumHandler = document.querySelector(".sum");
        const buttons = [...document.querySelectorAll(".calculateButton")];
        const fullPrice = document.querySelectorAll(".fullPrice");
        const price = document.querySelectorAll(".price");
        const quantity = document.querySelectorAll(".quantity");

        sumHandler.textContent = calcNewSum([...fullPrice]);

        buttons.forEach((button, index) => button.addEventListener("click", (e) => {
            const val = (price[index].textContent * 1) * quantity[index].value;
            fullPrice[index].textContent = val;
            sumHandler.textContent = calcNewSum([...fullPrice]);
            e.preventDefault();
        }));
    </script>
    <?php if (!$blocked) : ?>
        <button type="submit" name="saveBasket" class="btn btn-primary mb-2">Zapisz koszyk</button>
    </form>
<?php endif; ?>