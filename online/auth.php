<?php
include 'connection.php';

session_start(); //important if you want to use the SESSION data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["pasword"];
    $password = sha1($password);
    
    $stmt = $conn->prepare("SELECT ID, Email FROM User WHERE Email = ? AND Password = ? LIMIT 1"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($id, $email);
    $stmt->store_result();
    
    if($stmt->num_rows == 1) {
        if($stmt->fetch()) {
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
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
//insert new user (sha1)
sql = "INSERT INTO User (Email, Password) VALUES ('guest.test@code.berlin', sha1(123))";

//insert new user - this option is not configured
$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
sql = "INSERT INTO User (Email, Password) VALUES ('test@test.com', '$hashPassword')"; 123 password
*/
?> 