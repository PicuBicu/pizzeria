<form action="controllers/order_make.php" method="post">
    <label for="addressId" class="mt-2">Wybierz adres dostawy:</label>
    <select name="addressId" class="form-control">
        <?php foreach ($addressesList as $row) : ?>
            <option value="<?= $row["id"] ?>"><?= "Ulica: " . $row["street"] . " Numer domu: " . $row["house_number"] . " Miasto: " . $row["city"] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="informationForCourier" class="mt-2">Informacje dla kuriera:</label>
    <textarea class="form-control mb-2" name="informationForCourier" placeholder="Max 255 znaków"></textarea>
    <button type="submit" class="btn btn-primary" name="makeOrder">Złóż zamówienie</button>
    <button type="submit" class="btn btn-primary" name="cancelOrder">Anuluj zamówienie</button>
</form>