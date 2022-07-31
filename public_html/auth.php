<?php
require "../private/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (!isset($_POST["token"]) || !isset($_SESSION["token"])) { //avoid CSRF attack, with the help of the token
        header("Location: ./");
    }
    if ($_POST["token"] == $_SESSION["token"]) {
    
    $email = $_POST["email"];
    $password = $_POST["pasword"];
    
    $stmt = $conn->prepare("SELECT * FROM userr WHERE use_email = ? LIMIT 1"); //stmt - prepared statement, without it the webapp is vulnerable to SQL Injection
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $passwordCheck = password_verify($password, $row['use_password']);

        if ($passwordCheck == false) {
            header("Location: ./");
        }
        else {
            $_SESSION['id'] = $row['use_id'];
            $_SESSION['email'] = $row['use_email'];
            header("Location: home.php");
        }
    }
    else {
        header("Location: ./");
    }
    $stmt->close();

    }
}
else {
    header("Location: ./");
}

$conn->close();

/* 
//insert new user - this option is not configured
$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
sql = "INSERT INTO userr (use_name, use_email, use_password) VALUES ('Guest Test', 'guest.test@code.berlin', '$hashPassword')";  //123 password
*/
?> 