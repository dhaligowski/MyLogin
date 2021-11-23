<?php

session_start();

if (isset($_SESSION['username'])) {
    session_unset();
    session_write_close();
    session_destroy();
    header('Location: index.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>

    <div class="header">
        <div class="error-message">
            <?php
            if (isset($_SESSION["errors"])) {
                $error = $_SESSION["errors"];
                echo  $error;
            } ?>
        </div>
        <form class="login-container" method="post" action="validateLogin.php">
            <h2>Login</h2>
            <div class="mb-3">
                <label for="email-input" class="form-label">Username</label>
                <input type="text" class="form-control" id="email-input" aria-describedby="emailHelp" placeholder="Username" name="username">

            </div>
            <div class="mb-3">
                <label for="password-input" class="form-label">Password</label>
                <input type="password" class="form-control" id="password-input" placeholder="Password" name="password">
            </div>
            <input type="submit" class="btn" value="Login">
            <a type="" class="register" href="register.php">Register</a>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_SESSION["errors"])) {
    unset($_SESSION["errors"]);
}
session_write_close();
?>