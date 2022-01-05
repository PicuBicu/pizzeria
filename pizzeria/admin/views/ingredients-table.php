<button class="btn btn-primary mb-2">
    <a href="ingredients.php?action=add">Dodaj składnik</a>
</button>
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
                    <button type="button" class="btn btn-primary">
                        <a href="controllers/ingredient_update.php?ingredientId=<?= $row["id"] ?>">Aktualizuj</a>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>