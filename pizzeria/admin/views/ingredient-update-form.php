<form action="controllers/ingredient_update.php?id=<?= $_GET["ingredientId"] ?>" method="post">
    <label for="name" class="mt-2">Nazwa składnika:</label>
    <input class="form-control" required name="name" placeholder="<?= $ingredientName ?>" />
    <button type="submit" class="btn btn-primary mt-2">Zmień nazwę</button>
</form>