<div class="d-flex flex-row justify-content-center align-items-center">
    <form action="controllers/register_client.php" method="post">
        <div class="d-flex flex-row justify-content-center align-items-center">
            <h2>Zarejestruj się</h2>
        </div>
        <div class="mb-3">
            <label for="firstName">Imię:</label>
            <input type="text" name="firstName" class="form-control">
        </div>
        <div class="mb-3">
            <label for="lastName">Nazwisko:</label>
            <input type="text" name="lastName" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="phoneNumber">Numer telefonu:</label>
            <input type="text" name="phoneNumber" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password">Hasło:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="confirmPassword">Potwierdź hasło:</label>
            <input type="password" name="confirmPassword" class="form-control">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Zarejestruj się">
        </div>
        <p>Masz już konto? <a href="login.php">Zaloguj się</a>.</p>
    </form>
</div>