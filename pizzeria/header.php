<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

    <a href="menu.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <img height="50px" width="50px" role="img" aria-label="Bootstrap" src="/img/pizza.png" />
        <h1 class="display-6 display-primary my-2" style="color:#fff">Pizzeria</h1>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="menu.php" class="nav-link px-2 link-secondary">Menu</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Dowóz</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">O nas</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Kontakt</a></li>
    </ul>

    <div class="col-md-3 text-end">

        <a class="basket" href="orders.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-basket2" viewBox="0 0 16 16">
                <path d="M4 10a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 1 1 2 0v2a1 1 0 0 1-2 0v-2z" />
                <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.623l-1.844 6.456a.75.75 0 0 1-.722.544H3.69a.75.75 0 0 1-.722-.544L1.123 8H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.163 8l1.714 6h8.246l1.714-6H2.163z" />
            </svg>
        </a>

        <?php if ($_SESSION["loggedin"]) : ?>
            <button type="button" class="btn btn-primary"><a href="logout.php">Wyloguj się</a></button>
        <?php else : ?>
            <button type="button" class="btn btn-outline-primary me-2"><a href="login.php">Zaloguj się</a></button>
            <button type="button" class="btn btn-primary"><a href="register.php">Zarejestruj się</a></button>
        <?php endif; ?>

    </div>
</header>