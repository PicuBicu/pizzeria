<div class="d-flex flex-row justify-content-center align-items-center">
    <form action="controllers/login_client.php" method="post">
        <div class="d-flex flex-row justify-content-center align-items-center">
            <h2>Logowanie</h2>
        </div>
        <div class="d-flex flex-row justify-content-center align-items-center">
            <p>Proszę wypełnić te pola by się zalogować</p>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email:</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Hasło:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Zaloguj się">
        </div>
        <p>Chcesz się zarejestrować?
            <a href="register.php">Zarejestruj się</a>
        </p>
    </form>
</div>