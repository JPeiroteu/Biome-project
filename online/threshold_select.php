<?php
include 'connection.php';

$sql = "SELECT Threshold FROM Room ORDER BY ID DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
  while ($row =  mysqli_fetch_assoc($result)) {
   $row_threshold = $row["Threshold"];
  }
  $result->free();
}
$conn->close();

echo $row_threshold;
?> 