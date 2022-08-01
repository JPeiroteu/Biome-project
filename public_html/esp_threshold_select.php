<?php
require "../private/connection.php";

$stmt = $conn->prepare("SELECT tar_threshold FROM target ORDER BY tar_id DESC LIMIT 1"); //stmt prepared statement, without it the webapp is vulnerable to SQL Injection
$stmt->execute();
$stmt->bind_result($threshold);
$stmt->store_result();

if($stmt->num_rows == 1) {
  $stmt->fetch();
}
else {
  echo $stmt->error;
}
$stmt->close();
$conn->close();

echo $threshold;
