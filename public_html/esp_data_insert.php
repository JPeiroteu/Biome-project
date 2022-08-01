<?php
require "../private/connection.php";

$api_key_value = "c5623602F3d2"; //api key created to avoid intersection between esp32 webapp and online webapp

$api_key = "";
$temperature = "";
$humidity = "";
$threshold = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $api_key = $_POST["api_key"];
   if ($api_key == $api_key_value) {
      $temperature = $_POST["temperature"];
      $humidity = $_POST["humidity"];
      $threshold = $_POST["threshold"];

      //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
      $stmt = $conn->prepare("INSERT INTO room_sensor(ros_roo_id, ros_sen_id, ros_temperature, ros_humidity) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("iidd", 1, 1, $temperature, $humidity);
      $stmt->execute();

      $stmt2 = $conn->prepare("INSERT INTO target(tar_uro_id, tar_roo_id, tar_threshold) VALUES (?, ?, ?)");
      $stmt2->bind_param("iid", 1, 1, $threshold);
      $stmt2->execute();

      if (!$stmt2->execute()) {
         echo $conn->error;
      }

      $stmt->close();
      $stmt2->close();
      $conn->close();
   }
}
