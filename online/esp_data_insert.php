<?php
include 'connection.php';

$api_key_value = "c5623602F3d2";

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
      
      $sql = "INSERT INTO Room (Temperature, Humidity, Threshold) VALUES ('$temperature', '$humidity', '$threshold')";
      if (mysqli_query($conn, $sql)) {
         echo "New record has been added successfully !";
      } else {
         echo "Error: " . $sql . ":-" . mysqli_error($conn);
      }
      mysqli_close($conn);
   }
}
?>