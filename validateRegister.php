<?php
include_once "account.php";

session_start();

$account = new Account();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sanitizedUsername = test_input($username);
    $sanitizedPassword = test_input($password);

    if ($sanitizedPassword !== $password || $sanitizedUsername !== $username) {
        $_SESSION['errors'] = "Username and password cannot contain special characters or symbols.";
        session_write_close();
        header('Location: register.php');
        exit;
    }

    //validate username
    if (!$account->isUsernameValid($username)) {
        $_SESSION['errors'] = "Username must be between 8 and 16 characters.";
        session_write_close();
        header('Location: register.php');
        exit;

        //validate password
    } elseif (!$account->isPasswordValid($password)) {
        $_SESSION['errors'] = "Password must be between 8 and 16 characters.";
        session_write_close();
        header('Location: register.php');
        exit;

        //validate username is available        
    } elseif (!is_null($account->getIdFromUsername($username))) {
        $_SESSION['errors'] = "Username is not available.";
        session_write_close();
        header('Location: register.php');
        exit;
    }

    $id = $account->addAccount($username, $password);

    //login successful
    if ($id) {
        $_SESSION['username'] = $username;
        session_write_close();
        header('Location: profile.php');
        exit;
    }
}
//sanatize user data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
