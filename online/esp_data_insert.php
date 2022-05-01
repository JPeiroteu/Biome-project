<?php
include 'connection.php';

$api_key_value = "c5623602F3d2"; //api key created to avoid intersection between esp32 webapp and online webapp

$api_key = "";
$temperature = "";
$humidity = "";
$threshold = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $api_key = $_POST["api_key"];
   if($api_key == $api_key_value) {
      $temperature = $_POST["temperature"];
      $humidity = $_POST["humidity"];
      $threshold = $_POST["threshold"];
      
      $stmt = $conn->prepare("INSERT INTO Room (Temperature, Humidity, Threshold) VALUES (?, ?, ?)"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
      $stmt->bind_param("ddd", $temperature, $humidity, $threshold);
      if (!$stmt->execute()) {
         echo $conn->error;
      }
      $stmt->close();
      $conn->close();
   }
}
?>