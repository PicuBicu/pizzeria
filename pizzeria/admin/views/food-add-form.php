<form action="controllers/product_add.php" method="post" enctype="multipart/form-data">
    <div class="col-4">
        <label for="name" class="mt-2">Nazwa produktu:</label>
        <input class="form-control" required name="name" />
    </div>
    <div class="col-4">
        <label for="small" class="mt-2">Cena za rozmiar mały:</label>
        <input class="form-control" type="number" required name="small" />
    </div>
    <div class="col-4">
        <label for="average" class="mt-2">Cena za rozmiar średni:</label>
        <input class="form-control" type="number" required name="average" />
    </div>
    <div class="col-4">
        <label for="big" class="mt-2">Cena za rozmiar duży:</label>
        <input class="form-control" type="number" required name="big" />
    </div>
    <div class="col-4">
        <label for="photo" class="mt-2">Dodaj obrazek</label>
        <input class="form-control" type="file" required name="uploadFile" value="" />
    </div>
    <div class=" mt-2">
        <?php foreach ($ingredientsList as $row) : ?>
            <input type="checkbox" class="form-check-input" name="ingredients[]" value="<?= $row["id"] ?>" />
            <label for="ingredients"><?= $row["name"] ?></label>
            <div class="hr"></div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Dodaj produkt</button>
</form>