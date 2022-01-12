<form action="controllers/contact_data_add.php" method="post">
    <h2>Wprowadź dane kontaktowe</h2>
    <div class="col-4">
        <label for="email" class="mt-2">Email:</label>
        <input type="text" name="email" class="form-control" />
    </div>
    <div class="col-4">
        <label for="phoneNumber" class="mt-2">Numer telefonu:</label>
        <input type="text" name="phoneNumber" class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary mt-2">Zapisz dane kontaktowe</button>
</form>