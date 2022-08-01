<?php
require "../private/connection.php";

$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Authentication</title>
</head>

<body>
    <h2>Authentication</h2><br>
    <div class="login">
        <form id="login" method="post" action="auth.php">
            <label><b>User Name
                </b>
            </label>
            <input type="email" name="email" id="email" placeholder="Email" required maxlength="300">
            <br><br>
            <label><b>Password
                </b>
            </label>
            <input type="password" name="pasword" id="password" placeholder="Password" required maxlength="300">
            <br><br>
            <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>" />
            <input type="submit" name="log" id="log" value="Log In">
        </form>
    </div>
</body>

</html>