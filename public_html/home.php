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

        $sql = "SELECT ros_temperature, ros_humidity FROM room_sensor WHERE ros_dt=(SELECT MAX(ros_dt) FROM room_sensor)";

        $sql2 = "SELECT tar_threshold FROM target WHERE tar_dt=(SELECT MAX(tar_dt) FROM target)";
        /*
        $sql = "SELECT ros.ros_temperature, ros.ros_humidity, tar.tar_threshold FROM room_sensor ros 
                                                                                INNER JOIN room roo
                                                                                ON ros.ros_roo_id=roo.roo_id 
                                                                                INNER JOIN target tar ON roo.roo_id=tar.tar_roo_id 
                                                                                ";
*/

        if ($result = $conn->query($sql)) {
            $row = $result->fetch_assoc();
            $row_temperature = $row["ros_temperature"];
            $row_humidity = $row["ros_humidity"];
        }

        if ($result2 = $conn->query($sql2)) {
            $row2 = $result2->fetch_assoc();
            $row_threshold = $row2["tar_threshold"];
        }

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
        mysqli_free_result($result);
        mysqli_free_result($result2);

        mysqli_close($conn);
    } else {
        //header("Location: index.html");
    }

    ?>
</body>

</html>