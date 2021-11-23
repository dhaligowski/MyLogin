<?php
session_start();

include_once 'account.php';

$username = $_SESSION['username'];

$account = new Account();

$profile = $account->getAccountData($username);

$id = $profile['account_id'] ?? '';

$account->deleteAccount($id);

session_write_close();

session_destroy();

header("Location: index.php");
exit;
