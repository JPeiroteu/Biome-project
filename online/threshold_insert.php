<?php
include 'connection.php';

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];
   $stmt = $conn->prepare("INSERT INTO Room (Threshold) VALUES (?)"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
   $stmt->bind_param("d", $threshold);
   if ($stmt->execute()) {
      echo "New record has been added successfully !<br><a href=\"/\">Return to Home Page</a>";
      //header("Location: ./");
   } else {
      echo $conn->error;
   }
   $stmt->close();
   $conn->close();
}
?>