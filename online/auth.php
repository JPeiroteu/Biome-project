<?php
include 'connection.php';

session_start(); //important if you want to use the SESSION data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["pasword"];
    
    $stmt = $conn->prepare("SELECT ID, Email FROM User WHERE Email = ? LIMIT 1"); //stmt - prepared statement, without it the webapp is vulnerable to SQL Injection
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $stmt->fetch()) {
        $passwordCheck = password_verify($password, $row['Password']);

        if ($passwordCheck == false) {
            header("Location: ./");
        }
        else {
            $_SESSION['id'] = $row['ID'];
            $_SESSION['email'] = $row['Email'];
            header("Location: home.php");
        }
    }
    else {
        header("Location: ./");
    }
    $stmt->close();
}
else {
    header("Location: ./");
}

$conn->close();

/* 
//insert new user - this option is not configured
$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
sql = "INSERT INTO User (Email, Password) VALUES ('guest.test@code.berlin', '$hashPassword')"; //123 password
*/
?> 