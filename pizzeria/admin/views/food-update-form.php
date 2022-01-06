<form action="controllers/product_update.php?foodId=<?= $_GET["foodId"] ?>" method="post" enctype="multipart/form-data">
    <label for="name" class="mt-2">Nazwa produktu:</label>
    <input class="form-control" name="name" value="<?= $food["name"] ?>" placeholder="<?= $food["name"] ?>" />
    <label for="small" class="mt-2">Cena za rozmiar mały:</label>
    <input class="form-control" required type="number" name="small" value="<?= $food["mała"] ?>" placeholder="<?= $food["mała"] ?>" />
    <label for="average" class="mt-2">Cena za rozmiar średni:</label>
    <input class="form-control" required type="number" name="average" value="<?= $food["średnia"] ?>" placeholder="<?= $food["średnia"] ?>" />
    <label for="big" class="mt-2">Cena za rozmiar duży:</label>
    <input class="form-control" required type="number" name="big" value="<?= $food["duża"] ?>" placeholder="<?= $food["duża"] ?>" />
    <label for="photo" class="mt-2">Dodaj obrazek</label>
    <input class="form-control" type="file" name="uploadFile" />
    <div class=" mt-2">
        <?php foreach ($ingredientsList as $row) : ?>
            <div>
                <input type="checkbox" class="form-check-input" name="ingredients[]" <?= in_array($row["name"], $fromDatabase) ? "checked" : "" ?> value="<?= $row["id"] ?>" />
                <label for="ingredients"><?= $row["name"] ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Aktualizuj produkt</button>
</form>