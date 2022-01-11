<?php if ($orderList) : ?>
    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col">Adres</th>
                <th scope="col">Dane<br />kontaktowe</th>
                <th scope="col">Informacje dla kuriera</th>
                <th scope="col">Data</th>
                <th scope="col">Status</th>
                <th scope="col">Szczegóły</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderList as $row) : ?>
                <tr>
                    <td>
                        ul.<?= $row["street"] . " " . $row["house_number"] . " " . $row["city"] ?>
                    </td>
                    <td>
                        <?= $row["email"] ?><br />
                        <?= $row["phone_number"] ?>
                    </td>
                    <td>
                        <?= $row["information_for_courier"] ?>
                    </td>
                    <td>
                        <?= $row["order_date"] ?>
                    </td>
                    <td>
                        <?= $row["name"] ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary">
                            <a href="my-orders.php?orderId=<?= $row["id"] ?>">Wyświetl</a>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h3 class="no-data">Brak zamówień do wyświetlenia</h3>
<?php endif; ?>