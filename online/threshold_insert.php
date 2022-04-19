<?php
require 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {    
     $threshold = $_POST['threshold'];
     $sql2 = "INSERT INTO Room (Threshold) VALUES ('$threshold')";
     if (mysqli_query($conn, $sql2)) {
        echo "New record has been added successfully !";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }
     mysqli_close($conn);
}
?>