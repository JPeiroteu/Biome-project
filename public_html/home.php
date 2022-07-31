<!DOCTYPE HTML>
<html>
<head>
  <title>Temperature Threshold Output Control</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
require "../private/connection.php";

//check if exist any session
if (isset($_SESSION["email"])) {

    echo "Welcome back " . $_SESSION['email'];


    $sql = "SELECT ros_temperature, ros_humidity FROM room_sensor ORDER BY ros_id DESC LIMIT 1";

    $sql2 = "SELECT tar_threshold FROM target ORDER BY tar_id DESC LIMIT 1";


    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_temperature = $row["ros_temperature"];
            $row_humidity = $row["ros_humidity"];
            $row_threshold = $row["tar_threshold"];

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
    mysqli_free_result($result);
    }
    mysqli_close($conn);
}
else {
    //header("Location: index.html");
}

?> 
</body>
</html>