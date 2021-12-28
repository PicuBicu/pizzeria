<?php

session_start();

if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Pizzeria / Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="/../css/styles.css">
</head>

<body>
    <div class="container">
        <?php
        require_once "header.php";
        require_once "single-pizza.php";
        require_once "footer.php";
        ?>
    </div>
</body>

</html>