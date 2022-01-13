<form action="controllers/order_make.php" method="post">
    <div class="col-6">
        <label for="addressId" class="mt-2">Wybierz adres dostawy:</label>
        <select name="addressId" class="form-control">
            <?php foreach ($addressesList as $row) : ?>
                <option value="<?= $row["id"] ?>"><?= "Ulica: " . $row["street"] . " Numer domu: " . $row["house_number"] . " Miasto: " . $row["city"] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-6">
        <?php require_once "views/contact-data-select-form.php" ?>
    </div>
    <div class="col-6">
        <label for="informationForCourier" class="mt-2">Informacje dla kuriera:</label>
        <textarea class="form-control mb-2" name="informationForCourier" placeholder="Max 255 znaków"></textarea>
    </div>
    <input type="checkbox" name="confirmation" class="form-check-input" />
    <label for="confirmation">Czy przesłać potwierdzenie na maila?</label>
    <div class="hr"></div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary" name="makeOrder">Złóż zamówienie</button>
        <button type="submit" class="btn btn-primary" name="cancelOrder">Anuluj zamówienie</button>
    </div>
</form>