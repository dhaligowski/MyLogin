<?php
require_once 'account.php';

session_start();


$account = new Account();

//verify session is set
if (!isset($_SESSION['username'])) {
    session_write_close();
    header('Location: index.php');
    exit;
}


$username = $_SESSION['username'];

$profile = $account->getAccountData($username);

$updatedImage = $_POST['newProfilePic'];

$Output = "Success";

$password = '';
$email = $profile['account_email'];
$aboutMe = $profile['account_aboutme'];
$id = $profile['account_id'];

$account->updateAccount($id, $username, $password, $email, $aboutMe, $updatedImage);

exit(json_encode($Output));

// header("Location: profile.php");
// exit;
