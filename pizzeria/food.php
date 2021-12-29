<?php

require_once "helpers/utils.php";

session_start();
if (redirectIfUserIsNotLoggedIn()) {
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Pizzeria / Pizza</title>
</head>

<body>
    <div class="container">
        <?php
        require_once "header.php";
        require_once "helpers/alert.php";
        require_once "single-pizza.php";
        require_once "footer.php";
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.js"></script>
</body>

</html>