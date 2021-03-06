<h2 class="no-data">Informacje o zamówieniu</h2>
<table class="table rounded">
    <thead>
        <tr>
            <th scope="col">Id.</th>
            <th scope="col">Ulica</th>
            <th scope="col">Numeru domu</th>
            <th scope="col">Miasto</th>
            <th scope="col">Status</th>
            <th scope="col">Informacje dla kuriera</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?= $orderItem["id"] ?>
            </td>
            <td>
                <?= $orderItem["street"] ?>
            </td>
            <td>
                <?= $orderItem["house_number"] ?>
            </td>
            <td>
                <?= $orderItem["city"] ?>
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
<h2 class="no-data">Produkty w zamówieniu</h2>
<table class="table rounded">
    <thead>
        <tr>
            <th scope="col">Id.</th>
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
                    <?= $row["id"] ?>
                </td>
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