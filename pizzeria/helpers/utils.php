<?php

function setAlertInfo($message, $type)
{
    $_SESSION["alertMessage"] = $message;
    $_SESSION["alertType"] = $type;
}

function redirectIfUserIsNotLoggedIn()
{
    if (!isset($_SESSION["loggedin"])) {
        header("location: login.php");
        return true;
    }
    return false;
}

function redirectIfUserIsLoggedIn()
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        if (isset($_SESSION["role"]) && $_SESSION["role"] === "ADMIN") {
            header("location: admin/index.php");
        } else {
            header("location: menu.php");
        }
        return true;
    }
    return false;
}

function goToLocation($location, $message, $alertType)
{
    setAlertInfo($message, $alertType);
    header($location);
    exit();
}

function goToLocationWithError($location, $message)
{
    goToLocation($location, $message, DANGER);
}

function goToLocationWithWarning($location, $message)
{
    goToLocation($location, $message, WARNING);
}

function goToLocationWithSuccess($location, $message)
{
    goToLocation($location, $message, SUCCESS);
}

function validateAddressField($field)
{
    if (isset($field) && strlen(trim($field)) < 255) {
        return true;
    }
    return false;
}

function redirectIfNotEnoughPermisions()
{
    if (isset($_SESSION["role"]) && $_SESSION["role"] === "USER") {
        goToLocationWithWarning("location: ../menu.php", PERMISSION_DENIED);
    }
}

function checkPasswordStrenth($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

function sendMailTo(string $email, array $foodList, int $orderId)
{
    echo $email;
    $from  = "From: iomail2021@gmail.com \r\n";
    $from .= 'MIME-Version: 1.0' . "\r\n";
    $from .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $title = "Potwierdzenie zamówienia $orderId";
    $message = '
        <html>
        <head>
            <style>
                * {
                    padding: 20px;
                }
                table, td, th {
                    border: 5px solid;
                }
            </style>
        </head>
        <body>
        <table class="table rounded">
            <thead>
                <tr>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Rozmiar</th>
                    <th scope="col">Cena jedn. w zł</th>
                    <th scope="col">Cena * ilość zł</th>
                    <th scope="col">Ilość</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($foodList as $row) {
        $message .= '<tr>
                        <td>
                            <div class="fw-bold"> ' . $row["name"] . ' </div>
                            <div> ' . $row["ingredients"] . ' </div>
                        </td>
                        <td> ' . $row["size_name"] . ' </td>
                        <td> ' . $row["price"] . ' </td>
                        <td>' . $row["price"] * $row["quantity"] . '</td>
                        <td> ' . $row["quantity"] . '</td>
                    </tr>';
    }
    $message .= '</tbody>
            </table>';
    $message .= '<h2>Twoje zamówienie jest w trakcie realizacji</h2>';
    $message .= '</body>
            </html>';
    return mail($email, $title, $message, $from);
}
