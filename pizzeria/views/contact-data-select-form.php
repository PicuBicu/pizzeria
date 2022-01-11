<label for="contactDataId" class="mt-2">Wybierz dane kontaktowe:</label>
<select name="contactDataId" class="form-control">
    <?php foreach ($contactDataList as $row) : ?>
        <option value="<?= $row["id"] ?>"><?= "Email: " . $row["email"] . " Numer telefonu: " . $row["phone_number"] ?></option>
    <?php endforeach; ?>
</select>