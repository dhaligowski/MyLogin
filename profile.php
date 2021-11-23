<?php
require_once 'account.php';

session_start();

$account = new Account();

//$deleteProfile = false;

if (!isset($_SESSION['username'])) {
    session_write_close();
    session_destroy();
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

$profile = $account->getAccountData($username);
$password = $profile["account_password"] ?? null;
$email = $profile['account_email'] ? $profile['account_email'] :  '<br>';
$aboutMe = $profile['account_aboutme'] ? $profile['account_aboutme'] :  "Tell People about yourself...";
$image = $profile['account_image'];
$id = $profile['account_id'] ?? '';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/profile.css">
</head>

<body>
    <div class="card">
        <form action="">
            <div class="card-img">
                <div id="image_drop_area" class="image_drop_class" style="background-image: url(<?php echo $image ?>)">
                </div>
            </div>
            <div class="card-body">
                <div class="card-element">
                    <h5 class="card-title">Username</h5>
                    <p class="card-text"><?php echo $username ?></p>
                </div>
                <h5 class="card-title">Password</h5>
                <p class="card-text card-pass"><?php echo $password ?></p>
                <h5 class="card-title">Email</h5>
                <p class="card-text"><?php echo $email ?></p>
                <h5 class="card-title">About Me</h5>
                <textarea class="about-me" readonly placeholder="<?php echo $aboutMe ?>" cols="35" rows="3"></textarea>
                <div class="logout">
                    <a href="update.php" class="btn-logout">Update</a>
                    <a class="btn-logout" id="delete-profile" value="Delete" onclick="return confirm('Are you sure you want to delete your profile?');" href="deleteProfile.php">Delete</a>


                    <div class="logout-button">
                        <a href="logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
        </form>
    </div>
    <script src="./draggable.js">
    </script>

</body>

</html>