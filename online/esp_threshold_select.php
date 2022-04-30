<?php
include 'connection.php';

$sql = "SELECT Threshold FROM Room ORDER BY ID DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
  while ($row =  mysqli_fetch_assoc($result)) {
   $row_threshold = $row["Threshold"];
  }
  mysqli_free_result($result);
}
mysqli_close($conn);

echo $row_threshold;
?> 