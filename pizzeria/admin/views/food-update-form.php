<form action="controllers/food-update-form.php" method="post">
    <label for="name" class="mt-2">Nazwa produktu:</label>
    <input class="form-control" required name="name" value="" />
    <label for="small" class="mt-2">Cena za rozmiar mały:</label>
    <input class="form-control" required name="small" value="" />
    <label for="average" class="mt-2">Cena za rozmiar średni:</label>
    <input class="form-control" required name="average" value="" />
    <label for="big" class="mt-2">Cena za rozmiar duży:</label>
    <input class="form-control" required name="big" value="" />
    <label for="photo" class="mt-2">Dodaj obrazek</label>
    <input class="form-control" type="file" required name="photo" />
    <div class="mt-2">
        <?php foreach ($ingredientsList as $row) : ?>
            <label for="ingredients"><?= $row["name"] ?></label>
            <input type="checkbox" class="form-check-input" name="ingredients[]" value="<?= $row["id"] ?>" />
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Dodaj produkt</button>
</form>