<!DOCTYPE HTML>
<html>
<head>
  <title>Temperature Threshold Output Control</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
include 'connection.php';

$sql = "SELECT Temperature, Humidity, Threshold FROM Room ORDER BY ID DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
  while ($row =  mysqli_fetch_assoc($result)) {
    $row_temperature = $row["Temperature"];
    $row_humidity = $row["Humidity"];
    $row_threshold = $row["Threshold"];

echo '
  <h2>Temperature</h2> 
  <h3>' . $row_temperature . ' &deg;C</h3>
  <h2>Humidity</h2> 
  <h3>' . $row_humidity . '  &percnt;</h3>
  <h2>ESP Arm Trigger</h2>
  <form action="threshold_insert.php" method="get">
    Temperature Threshold <input type="number" step="0.1" name="threshold" value="' . $row_threshold . '" required><br>
    <input type="submit" name="submit" value="Submit">
  </form>';
  }
  $result->free();
}
$conn->close();
?> 
</body>
</html>