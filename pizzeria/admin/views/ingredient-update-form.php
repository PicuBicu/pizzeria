<form action="controllers/ingredient_update.php?id=<?= $_GET["ingredientId"] ?>" method="post">
    <div class="col-4">
        <label for="name" class="mt-2">Nazwa składnika:</label>
        <input class="form-control" required name="name" placeholder="<?= $ingredientName ?>" />
    </div>
    <button type="submit" class="btn btn-primary mt-2">Zmień nazwę</button>
</form>