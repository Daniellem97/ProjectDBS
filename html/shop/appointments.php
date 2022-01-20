<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Appointments</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body class="bodyStyle">

	<div id="header" class="mainHeader">
		<hr>
		<div class="center">Evergreen Silk Plants;</div>
	</div>
	<br>
	<?php
		// Get the application environment parameters from the Parameter Store.
		include ('getAppParameters.php');

		// Display the server metadata information if the showServerInfo parameter is true.
		include('serverInfo.php');
	?>
	<hr>
	<div class="topnav">
		<a href="index.php">Home</a>
		<a href="shop.php">Shop</a>
		<a href="orderHistory.php" class="active">Order History</a>
		<a href="Appointments.php" class="active">Appointments</a>
	</div>

	<hr>
	<div class="cursiveText">
		<p>Appointment History</p>
	</div>

<?php

// Create a connection to the database.

$conn = new mysqli($db_url, $db_user, $db_password, $db_name);

// Check the connection.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all orders in the database.

$sql = "SELECT a.bookings_id, a.booking_name, a.start_date, b.booking_group_number, b.booking_group_name
        FROM bookings a, booking_group b
        WHERE a.booking_group_number = b.booking_group
        ORDER BY b.booking_group_number DESC, a.bookings_id ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    // Display information for each order.

    $previousr = 0;
    $firstTime = true;

    while($row = $result->fetch_assoc()) {

        if ($row["booking_group_number"] != $previousBookingGroupNumber) {

            if (!$firstTime) {
                echo '</table>';
                echo '</div>';
                echo '<hr>';
            }

            echo '<div>';
            echo '<p>';
            echo '<b>Booking Number: ' . $row["booking_number"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: ' . substr($row["booking_date_time"], 0, 10)
            . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time: ' . substr($row["booking_date_time"], 11, 8) . '</b>';
            echo '</p>';

            echo '<table style="width: 80%">';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '</tr>';

            $previousBookingGroupNumber = $row["booking_group_number"];
            $firstTime = false;
        }
        echo '<tr>';
        echo '<td align="center">' . $row["booking_name"] . '</td>';
        echo '</tr>';

    }

} else {

    echo '<p class="center">You have no appointments at this time.</p>';
}

// Close the last table division.

echo '</table>';
echo '</div>';
echo '<hr>';

// Close the connection.

$conn->close();
?>

	<br>
	<div id="Copyright" class="center">
		<h5>&copy; 2021, Danielle Murphy 10553937. All rights
			reserved.</h5>
	</div>

</body>
</html>

