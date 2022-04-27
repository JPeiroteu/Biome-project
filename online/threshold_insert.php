<?php
include 'connection.php';

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];
   $sql = "INSERT INTO Room (Temperature, Humidity, Threshold) VALUES ('0', '0', '$threshold')";
   if (mysqli_query($conn, $sql)) {
      echo "New record has been added successfully !";
   } else {
      echo "Error: " . $sql . ":-" . mysqli_error($conn);
   }
   mysqli_close($conn);
}
?>