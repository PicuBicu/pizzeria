<form action="controllers/order_make.php" method="post">
    <label for="addressId" class="mt-2">Wybierz adres dostawy:</label>
    <select name="addressId" class="form-control">
        <?php foreach ($addressesList as $row) : ?>
            <option value="<?= $row["id"] ?>"><?= "Ulica: " . $row["street"] . " Numer domu: " . $row["house_number"] . " Miasto: " . $row["city"] ?></option>
        <?php endforeach; ?>
    </select>
    <?php require_once "views/contact-data-select-form.php" ?>
    <label for="informationForCourier" class="mt-2">Informacje dla kuriera:</label>
    <textarea class="form-control mb-2" name="informationForCourier" placeholder="Max 255 znaków"></textarea>
    <label for="informationForCourier" class="mt-2">Czy przesłać potwierdzenie na maila?</label>
    <input type="checkbox" name="confirmation" class="form-checkbox mb-2" /><br />
    <button type="submit" class="btn btn-primary" name="makeOrder">Złóż zamówienie</button>
    <button type="submit" class="btn btn-primary" name="cancelOrder">Anuluj zamówienie</button>
</form>