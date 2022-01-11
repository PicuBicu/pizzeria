<?php if ($orderItem && $basketList) : ?>
    <h3 class="header-title">Informacje o zamówieniu</h3>
    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col">Adres</th>
                <th scope="col">Dane<br />kontaktowe</th>
                <th scope="col">Status</th>
                <th scope="col">Informacje dla kuriera</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    ul.<?= $orderItem["street"] . " " . $orderItem["house_number"] . " " . $orderItem["city"] ?>
                </td>
                <td>
                    <?= $orderItem["email"] ?><br />
                    <?= $orderItem["phone_number"] ?>
                </td>
                <td>
                    <?= $orderItem["name"] ?>
                </td>
                <td>
                    <?= $orderItem["information_for_courier"] ?>
                </td>
            </tr>
        </tbody>
    </table>
    <h3 class="header-title">Produkty w zamówieniu</h3>
    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col">Nazwa</th>
                <th scope="col">Rozmiar</th>
                <th scope="col">Cena(zł)</th>
                <th scope="col">Ilość</th>
                <th scope="col">Składniki</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($basketList as $row) : ?>
                <tr>
                    <td>
                        <?= $row["name"] ?>
                    </td>
                    <td>
                        <?= $row["size_name"] ?>
                    </td>
                    <td>
                        <?= $row["price"] ?>
                    </td>
                    <td>
                        <?= $row["quantity"] ?>
                    </td>
                    <td>
                        <?= $row["ingredients"] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else :
    require_once "helpers/utils.php";
    require_once "helpers/messages.php";
    goToLocationWithWarning("location: my-orders.php", ORDER_NOT_FOUND);
?>
<?php endif; ?>