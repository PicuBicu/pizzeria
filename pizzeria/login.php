<?php

require_once "config.php";

session_start();

if (redirectIfUserIsLoggedIn()) {
    exit();
}

$email = "";
$password = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = array();

        if (empty(trim($_POST["email"]))) {
            $errors["email"] = "Email field is empty";
        } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Email is not valid";
        } else {
            $email = $_POST["email"];
        }

        if (empty(trim($_POST["password"]))) {
            $errors["password"] = "Password field is empty";
        } else {
            $password = $_POST["password"];
        }

        if (count($errors) == 0) {
            $sql = "SELECT * FROM client WHERE email = :email";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":email", $paramEmail, PDO::PARAM_STR);
                $paramEmail = trim($email);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() === 1) {
                        if ($row = $stmt->fetch()) {
                            $clientId = $row["id"];
                            $firstName = $row["first_name"];
                            $lastName = $row["last_name"];
                            $hashedPassword = $row["password"];

                            $password = trim($password);

                            if (password_verify($password, $hashedPassword)) {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["clientId"] = $clientId;
                                $_SESSION["firstName"] = $firstName;
                                $_SESSION["lastName"] = $lastName;
                                $_SESSION["email"] = trim($email);
                                header("location: menu.php");
                            } else {
                                $errors["password"] = "Email or password is not valid";
                            }
                        }
                    } else {
                        $errors["password"] = "Email or password is not valid";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
        unset($pdo);
    }
} catch (PDOException $exp) {
    // TODO: fatal error page
    echo "<div class='alert alert-danger'>Coś poszło nie tak ... Spróbuj ponownie później</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Pizzeria / Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex flex-row justify-content-center align-items-center">
        <h2>Logowanie</h2>
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center">
        <p>Proszę wypełnić te pola by się zalogować</p>
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label" for="email">Email:</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($errors["email"])) ? "is-invalid" : ""; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $errors["email"]; ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Hasło:</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($errors["password"])) ? "is-invalid" : ""; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $errors["password"]; ?></span>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Zaloguj się">
            </div>
            <?php
            if (isset($errors["exists"])) {
                echo $errors["exists"];
            }
            ?>
            <p>Chcesz się zarejestrować? <a href="register.php">Zarejestruj się</a>.</p>
        </form>
    </div>

</body>

</html>