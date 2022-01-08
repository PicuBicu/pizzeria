<?php if ($orderList && $orderStatusesList) : ?>
    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col">Ulica</th>
                <th scope="col">Numer domu</th>
                <th scope="col">Miasto</th>
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
                        <?= $row["street"] ?>
                    </td>
                    <td>
                        <?= $row["house_number"] ?>
                    </td>
                    <td>
                        <?= $row["city"] ?>
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