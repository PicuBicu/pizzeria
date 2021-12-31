<form action="make_order.php" method="post">
    <label for="addressId">Wybierz adres dostawy: </label>
    <select name="addressId" class="form-control mb-4">
        <?php foreach ($addressesList as $row) : ?>
            <option value="<?= $row["id"] ?>"><?= $row["street"] . " " . $row["house_number"] . " " . $row["city"] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="informationForCourier">Informacje dla kuriera</label>
    <textarea class="form-control mb-2" name="informationForCourier" placeholder="Max 255 znaków"></textarea>
    <button type="submit" class="btn btn-primary" name="makeOrder">Złóż zamówienie</button>
    <button type="submit" class="btn btn-primary" name="cancelOrder">Anuluj zamówienie</button>
</form>