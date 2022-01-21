<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Appointment Confirmation</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body class="bodyStyle">

	<div id="header" class="mainHeader">
		<hr>
		<div class="center">Appointments</div>
	</div>
	<br>
	<?php
		include ('getAppParameters.php');
	?>
	<hr>
	<div class="topnav">
		<a href="index.php">Home</a> 
		<a href="shop.php">Shop/Appointment</a>
		<a href="tutorial.php">Tutorial</a>
		<a href="orderHistory.php">Order History</a>
	</div>

	<hr>
	<div class="cursiveText">
		<p>Appointment Confirmation</p>
	</div>

<?php

// Create a connection to the database.

$conn = new mysqli($db_url, $db_user, $db_password, $db_name);

// Check the connection.

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order information from submitted form.

$BookingIds = $_POST["booking_Id"];
$BookingNames = $_POST["BookingName"];
$quantitys = $_POST["itemQuantity"];
$start_date = $_POST["AppointmentDate"];
$totalAmount = 0.00;
$amounts = 1;

date_default_timezone_set("Europe/London");

$currentTimeStamp = date('Y-m-d H:i:s');

$sql = "INSERT INTO `appointment` (booking_name) VALUES ('$BookingNames')";

if ($conn->query($sql) === TRUE) {
    $orderNumber = $conn->insert_id;
} else {
    die ("Error: " . $sql . "<br>" . $conn->error);
}

// Insert appointment_item rows.

$itemNo = 1;
	
for ($i = 0; $i < sizeof($BookingNames); $i++) {

    if ($totalAmount = 0.00) {

        $sql = "INSERT INTO appointment_item (appointment_number, appointment_item_number, bookings_id, bquantity)
                       VALUES ($orderNumber, $itemNo, $booking_Id, $quantitys);";

        if ($conn->query($sql) === TRUE) {
            $itemNo += 1;
        } else {
            die ("Error: " . $sql . "<br>" . $conn->error);
               }
        }
        }
	


// Close the connection.

$conn->close();
?>
	<p class="center">Thank for your confirming your appointment! We look forward to seeing you!.</p>

	<?php
echo  '</tr>';
	

 echo '<b>Quantity: ' . $itemQuantity[$i] . 'Booking: ' . $BookingNames[$i] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Order Number: ' . $orderNumber . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: ' . substr($currentTimeStamp, 0, 10)
. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time booking was made: ' . substr($currentTimeStamp, 11, 8) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Amount: ' . $currency . number_format($totalAmount, 2) . '</b>';		
for ($i = 0; $i < $amounts; $i++) {

 foreach ($BookingnNames[$i] as $BookingNames[$i])
 {
	 if ($total[$i] == 1) {
		 
 echo '<b>Booking: ' . $BookingNames . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Order Number: ' . $orderNumber . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: ' . substr($currentTimeStamp, 0, 10)
. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time booking was made: ' . substr($currentTimeStamp, 11, 8) '</b>';

echo '<table style="width: 80%">'; 
echo '</table>';
echo '</div>';
	 } 

    }
}
?>
	<br>
	<div id="Copyright" class="center">
		<h5>&copy; 2021, Danielle Murphy, 10553937</h5>
	</div>

</body> 
</html>
