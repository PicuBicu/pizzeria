<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/style.css" />
    <title>Pizzeria</title>
</head>

<body>
    <div class="container">

        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

            <a href="menu.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                <img height="50px" width="50px" role="img" aria-label="Bootstrap" src="/img/pizza.png" />
                <h1 class="display-6 display-primary my-2" style="color:#fff">Pizzeria</h1>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-secondary">Pizze</a></li>
                <li><a href="ingredients.php" class="nav-link px-2 link-dark">Składniki</a></li>
                <li><a href="orders.php" class="nav-link px-2 link-dark">Zamówienia</a></li>
            </ul>

            <div class="col-md-3 text-end">

                <?php if (isset($_SESSION)) : ?>
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                        <button type="button" class="btn btn-primary"><a href="logout.php">Wyloguj się</a></button>
                    <?php else : ?>
                        <button type="button" class="btn btn-outline-primary me-2"><a href="login.php">Zaloguj się</a></button>
                        <button type="button" class="btn btn-primary"><a href="register.php">Zarejestruj się</a></button>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </header>
        <main style="min-height:700px;">