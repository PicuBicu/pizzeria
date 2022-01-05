<button class="btn btn-primary mb-2"><a href="index.php?action=add">Dodaj produkt</a></button>

<table class="table rounded">
    <thead>
        <tr>
            <th scope="col">Zdjęcie</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Mała</th>
            <th scope="col">Średnia</th>
            <th scope="col">Duża</th>
            <th scope="col">Aktualizuj</th>
            <th scope="col">Usuń</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($foodList as $row) : ?>
            <tr>
                <td>
                    <img src="../../../img/<?= $row["name"] ?>.jpg" />
                </td>
                <td>
                    <div class="fw-bold"><?= $row["name"] ?></div>
                    <div><?= $row["ingredients"] ?></div>
                </td>
                <td>
                    <?= $row["mała"] ?>
                </td>
                <td>
                    <?= $row["średnia"] ?>
                </td>
                <td>
                    <?= $row["duża"] ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary"><a href="index.php?foodId=<?= $row["id"] ?>&action=update">Aktualizuj</a></button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger"><a href="controllers/product_delete.php?foodId=<?= $row["id"] ?>&action=delete">Usuń</a></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>