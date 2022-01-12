<?php if ($orderList && $orderStatusesList) : ?>
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
                        <form action="controllers/order_change_status.php?orderId=<?= $row["id"] ?>" method="post">
                            <div class="input-group">
                                <select class="form-select form-select" name="orderStatusId">
                                    <?php foreach ($orderStatusesList as $status) : ?>
                                        <option value="<?= $status["id"] ?>" <?= $row["name"] === $status["name"] ? "selected" : "" ?>><?= $status["name"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary">Zmień status</button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary">
                            <a href="orders.php?orderId=<?= $row["id"] ?>">Wyświetl</a>
                        </button>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h3 class="no-data">Brak zamówień do wyświetlenia</h3>
<?php endif; ?>