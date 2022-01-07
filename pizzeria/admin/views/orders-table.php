<table class="table rounded">
    <thead>
        <tr>
            <th scope="col">Id.</th>
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
                    <?= $row["id"] ?>
                </td>
                <td>
                    <?= $row["street"] ?>
                </td>
                <td>
                    <?= $row["house_number"] ?>
                </td>
                <td>
                    <?= $row["city"] ?>
                </td>

                </td>
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