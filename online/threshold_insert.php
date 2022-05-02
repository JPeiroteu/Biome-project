<?php
include 'connection.php';

session_start(); //important if you want to use the SESSION data

$sql = "SELECT Temperature, Humidity FROM Room ORDER BY ID DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
  while ($row =  mysqli_fetch_assoc($result)) {
    $row_temperature = $row["Temperature"];
    $row_humidity = $row["Humidity"];
  }
  mysqli_free_result($result);
}

$sql2 = "SELECT ID FROM Room ORDER BY ID DESC LIMIT 1";

if ($result2 = mysqli_query($conn, $sql2)) {
while ($row2 =  mysqli_fetch_assoc($result2)) {
   $row_roomId = $row2["ID"];
}
mysqli_free_result($result2);
}

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];
   $stmt = $conn->prepare("INSERT INTO Room (Temperature, Humidity, Threshold) VALUES (?, ?, ?)"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
   $stmt->bind_param("ddd", $row_temperature, $row_humidity, $threshold);
   $stmt->execute();

   $stmt2 = $conn->prepare("INSERT INTO User_has_Room (User_ID, Room_ID) VALUES (?, ?)"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
   $stmt2->bind_param("ii", $_SESSION['id'], $row_roomId);
   
   if ($stmt2->execute()) {
      header("Location: home.php");
      //header("Location: ./");
   } else {
      echo $conn->error;
   }
   $stmt->close();
   $stmt2->close();
   $conn->close();

/* 
//reset ID from Room, starting from 1
ALTER TABLE Room AUTO_INCREMENT = 1
*/
}
?>