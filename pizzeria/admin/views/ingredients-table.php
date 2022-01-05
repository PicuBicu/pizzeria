<button class="btn btn-primary mb-2" href="controllers/ingredient_add.php">Dodaj składnik</button>
<form action="save_basket.php" method="post">

    <table class="table rounded">
        <thead>
            <tr>
                <th scope="col" class="text-start">Nazwa</th>
                <th scope="col" class="text-end">Aktualizuj</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ingredientsList as $row) : ?>
                <tr>
                    <td class="text-start">
                        <?= $row["name"] ?>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-primary"><a href="controllers/ingredient_update.php?foodId=<?= $row["id"] ?>">Aktualizuj</a></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>