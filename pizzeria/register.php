<?php

require_once "config.php";

define("ONLY_LETTERS", "/^[a-zA-Z]+$/");

function validateMail($email, &$errors)
{
    if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email jest nieprawidłowy";
        return false;
    }
    return true;
}

function validateField($field, $fieldData, $regex, &$errors)
{
    if (empty(trim($field))) {
        $errors[$fieldData] = "Podaj " . $fieldData;
        return false;
    } else if (!preg_match($regex, trim($field))) {
        $errors[$fieldData] = $fieldData . " może zawierać jedynie litery";
        return false;
    }
    return true;
}

function validatePassword($password, &$errors)
{
    if (empty(trim($password))) {
        $errors["password"] = "Podaj hasło";
        return false;
    } elseif (strlen(trim($password)) < 6) {
        $errors["password"] = "Hasło musi zawierać conajmniej 6 znaków";
        return false;
    }
    return true;
}

function validateConfirmPassword($confirmPassword, $password, &$errors)
{
    if (empty(trim($confirmPassword))) {
        $errors["confirmPassword"] = "Wpisz ponownie hasło";
        return false;
    } else {
        $confirmPassword = trim($confirmPassword);
        if (empty($errors["password"]) && ($password != $confirmPassword)) {
            $errors["confirmPassword"] = "Mail lub hasło jest nieprawidłowe";
            return false;
        }
    }
    return true;
}

$errors = array();
$firstName = "";
$lastName = "";
$password = "";
$email = "";
$confirmPassword = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $confirmPassword = $_POST["confirmPassword"];
        if (
            validateField($firstName, "firstName", ONLY_LETTERS, $errors)
            && validateMail($email, $errors)
            && validateField($lastName, "lastName", ONLY_LETTERS, $errors)
        ) {
            $sql = "SELECT id FROM client WHERE email=:email";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":email", $paramEmail, PDO::PARAM_STR);
                $paramEmail = trim($email);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $errors["exists"] = "Ten adres email jest już zarezerwowany";
                    }
                } else {
                    echo "Coś poszło nie tak ... Spróbuj później";
                }
                unset($stmt);
            }
        }
        if (!validatePassword($password, $errors)) {
        }

        if (!validateConfirmPassword($confirmPassword, $password, $errors)) {
        }

        if (count($errors) == 0) {

            $sql = "INSERT INTO client(first_name, last_name, email, password) VALUES(:firstName, :lastName, :email, :password)";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":firstName", $paramFirstName, PDO::PARAM_STR);
                $stmt->bindParam(":lastName", $paramLastName, PDO::PARAM_STR);
                $stmt->bindParam(":email", $paramEmail, PDO::PARAM_STR);
                $stmt->bindParam(":password", $paramPassword, PDO::PARAM_STR);

                $paramPassword = password_hash(trim($password), PASSWORD_DEFAULT, ["cost" => 12]);
                $paramEmail = trim($email);
                $paramFirstName = trim($firstName);
                $paramLastName = trim($lastName);

                if ($stmt->execute()) {
                    header("location: login.php");
                } else {
                    echo "Coś poszło nie tak ... Spróbuj później";
                }
                unset($stmt);
            }
        }

        unset($pdo);
    }
} catch (PDOException $exp) {
    echo "Coś poszło nie tak ... Spróbuj ponownie później";
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Pizzeria / Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex flex-row justify-content-center align-items-center">
        <h2>Zarejestruj się</h2>
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center">
        <p>Wypełnij dane aby założyć konto</p>
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center">

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="mb-3">
                <label for="firstName">Imię:</label>
                <input type="text" name="firstName" class="form-control <?php echo (!empty($errors["firstName"])) ? "is-invalid" : ""; ?>" value="<?php echo $firstName; ?>">
                <span class="invalid-feedback"><?php echo $errors["firstName"]; ?></span>
            </div>

            <div class="mb-3">
                <label for="lastName">Nazwisko:</label>
                <input type="text" name="lastName" class="form-control <?php echo (!empty($errors["lastName"])) ? "is-invalid" : ""; ?>" value="<?php echo $lastName; ?>">
                <span class="invalid-feedback"><?php echo $errors["lastName"]; ?></span>
            </div>

            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($errors["email"])) ? "is-invalid" : ""; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $errors["email"]; ?></span>
            </div>
            <div class="mb-3">
                <label for="password">Hasło:</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($errors["password"])) ? "is-invalid" : ""; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $errors["password"]; ?></span>
            </div>
            <div class="mb-3">
                <label for="confirmPassword">Potwierdź hasło:</label>
                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($errors["confirmPassword"])) ? "is-invalid" : ""; ?>" value="<?php echo $confirmPassword; ?>">
                <span class="invalid-feedback"><?php echo $errors["confirmPassword"]; ?></span>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Zarejestruj się">
            </div>
            <?php
            if (isset($errors["exists"])) {
                echo $errors["exists"];
            }
            ?>
            <p>Masz już konto? <a href="login.php">Zaloguj się</a>.</p>
        </form>
    </div>
</body>

</html>