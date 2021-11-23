<?php
include_once "account.php";

session_start();

$account = new Account();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($account->login($username, $password)) { //login successful
        $_SESSION['username'] = $username;
        session_write_close();
        header('Location: profile.php');
        exit;
    } else {
        $_SESSION['errors'] = "Please register or provide valid login credentials.";
        session_write_close();
        header('Location: index.php');
        exit;
    }
} else {
    session_write_close();
    header('Location: index.php');
}
