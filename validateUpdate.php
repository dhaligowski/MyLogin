<?php
require_once 'account.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

$account = new Account();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $row = $account->getAccountData($username);
    $password = $row['account_password'];
    $email = $row['account_email'];
    $aboutMe = $row['account_aboutme'];
    $image = $row['account_image'];
    $id = $row['account_id'];

    if (!isset($_POST['image'])) $_POST['image'] = '';

    $newUsername = ($_POST['username']) ? $_POST['username'] : $username;
    $newEmail = ($_POST['email']) ? $_POST['email'] : $email;
    $newAboutMe = ($_POST['aboutMe']) ? $_POST['aboutMe'] : $aboutMe;
    $newImage = ($_POST['image']) ? $_POST['image'] : $image;
    $newPassword = ($_POST['password']) ? $_POST['password'] : '';

    $sanitizedUsername = test_input($newUsername);
    $sanitizedPassword = test_input($newPassword);

    //username or password contain symbols or special characters.
    if ($sanitizedPassword !== $newPassword || $sanitizedUsername !== $newUsername) {
        $_SESSION['errors'] = "Username and password cannot contain special characters or symbols.";
        session_write_close();
        header('Location: update.php');
        exit;
    }

    //verify username is valid
    if (!$account->isUsernameValid($newUsername)) {
        $_SESSION['errors'] = "Username must be between 8 and 16 characters.";
        session_write_close();
        header('Location: update.php');
        exit;

        //verify password is valid    
    } elseif (!$account->isPasswordValid($newPassword) && !empty($newPassword)) {
        $_SESSION['errors'] = "Password must be between 8 and 16 characters.";
        session_write_close();
        header('Location: update.php');
        exit;

        //verify username is available
    } elseif (!is_null($account->getIdFromUsername($newUsername)) && $newUsername !== $username) {
        $_SESSION['errors'] = "Username is not available.";
        session_write_close();
        header('Location: update.php');
        exit;
    }

    //verify email is valid
    if ($newEmail)
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'] = "Pleae enter in a valid email address.";
            session_write_close();
            header('Location: update.php');
            exit;
        }
    // }


    //Entries are valid..continue update
    $account->updateAccount($id, $newUsername, $newPassword, $newEmail, $newAboutMe, $newImage);
    $_SESSION['username'] = $newUsername;
    if (isset($_SESSION["errors"])) {
        unset($_SESSION["errors"]);
    }
    session_write_close();
    header('Location: profile.php');
    exit;
} else {

    if (isset($_SESSION["errors"])) {
        unset($_SESSION["errors"]);
        session_write_close();
    }
}

//sanitize user data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
