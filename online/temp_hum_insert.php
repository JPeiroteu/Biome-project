<?php
include 'connection.php';

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];
   $sql2 = "INSERT INTO Room (Threshold) VALUES ('$threshold')";
   if (mysqli_query($conn, $sql2)) {
      echo "New record has been added successfully !";
   } else {
      echo "Error: " . $sql . ":-" . mysqli_error($conn);
   }
   mysqli_close($conn);
}
?>