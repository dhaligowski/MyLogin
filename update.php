<?php
include_once 'account.php';

session_start();

if (!isset($_SESSION['username'])) {
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
    <title>Update Profile</title>
    <link rel="stylesheet" href="styles/update.css">
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
        <form action="validateUpdate.php" method="post" enctype="multipart/form-data" class="form">
            <h2>Update Profile</h2>
            <div>
                <label for="username" class="form-title">Username</label>
                <input type="text" title="username" class="form-entry" name="username">
            </div>
            <div class="form-title">
                <label for="password" class="form-title">Password</label>
                <input type="text" title="password" class="form-entry" name="password" value="">
            </div>
            <div class="form-title">
                <label for="email" class="form-title">Email</label>
                <input type="text" class="form-entry" name="email" title="email" value="">
            </div>
            <div class="form-title">
                <label for="aboutMe" class="form-title">About Me</label>
                <textarea type="text" title="aboutMe" class="about-me" name="aboutMe" maxlength="100" placeholder="Tell others about yourself in 85 characters or less.." cols="50" rows="3"></textarea>
            </div>

            <div class="update-container">
                <a type="submit" class="update-btn" value="Back" href="profile.php">Back</a>
                <input type="submit" class="update-btn" value="Update">
            </div>

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