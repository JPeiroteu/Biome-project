<?php
require "../private/connection.php";

$sql = "SELECT uro_id FROM user_room WHERE uro_use_id = '".$_SESSION['id']."'";

if ($result = $conn->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    $row_uro_id = $row["uro_id"];
  }
}

if(isset($_GET['submit'])) {    
   $threshold = $_GET['threshold'];

   $stmt = $conn->prepare("INSERT INTO target(tar_uro_id, tar_roo_id, tar_threshold) VALUES (?, 1, ?)");
   $stmt->bind_param("id", $row_uro_id, $threshold);
   
   if ($stmt->execute()) {
      header("Location: home.php");
      //header("Location: ./");
   } else {
      echo $conn->error;
   }
   $stmt->close();
   $conn->close();
}
