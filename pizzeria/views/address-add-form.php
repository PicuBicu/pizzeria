<form action="controllers/address_add.php" method="post">
    <h2>Wprowadź adres dostawy</h2>
    <label for="street" class="mt-2">Ulica:</label>
    <input type="text" name="street" class="form-control" />
    <label for="houseNumber" class="mt-2">Numer domu:</label>
    <input type="text" name="houseNumber" class="form-control" />
    <label for="city" class="mt-2">Miejscowość:</label>
    <input type="text" name="city" class="form-control" />
    <button type="submit" class="btn btn-primary mt-2">Zapisz adres</button>
</form>