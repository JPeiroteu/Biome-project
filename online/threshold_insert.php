<?php
include 'connection.php';

session_start();

$sql = "SELECT Temperature, Humidity FROM Room ORDER BY ID DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
  while ($row =  mysqli_fetch_assoc($result)) {
    $row_temperature = $row["Temperature"];
    $row_humidity = $row["Humidity"];
  }
  mysqli_free_result($result);
}

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];
   $stmt = $conn->prepare("INSERT INTO Room (Temperature, Humidity, Threshold) VALUES (?, ?, ?)"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
   $stmt->bind_param("ddd", $row_temperature, $row_humidity, $threshold);
   
   if ($stmt->execute()) {
      header("Location: home.php");
      //header("Location: ./");
   } else {
      echo $conn->error;
   }
   $stmt->close();
   $conn->close();
}

/*
   $stmt = $conn->prepare("INSERT INTO User_has_Room (User_ID, Room_ID) VALUES (?, ?)");
   $stmt->bind_param("ii", $_SESSION['id'], $roomId);*/
?>