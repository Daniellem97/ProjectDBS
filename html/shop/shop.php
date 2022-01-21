<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shop/Appointments</title>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/menu.css">
</head>
<body class="bodyStyle">
	<div id="header" class="mainHeader">
		<hr>
		<div class="center">Evergreen Silk Plants</div>
	</div>
	<br>
	<?php
		include ('getAppParameters.php');
	?>
	<hr>
	<div class="topnav">
		<a href="index.php">Home</a>
		<a href="shop.php" class="active">Shop/Appointments</a>
		<a href="tutorial.php">Tutorials</a>
		<a href="orderHistory.php">Order History</a>
	</div>
<?php
// Create a connection to the database.
$conn = new mysqli($db_url, $db_user, $db_password, $db_name);
// Check the connection.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get all rows from the product table.
$sql = "SELECT a.id, a.product_name, a.description, a.price, b.product_group_number, b.product_group_name, a.image_url 
        FROM product a, product_group b
        WHERE b.product_group_number = a.product_group
        ORDER BY b.product_group_number, a.id";
$result = $conn->query($sql);
$numOfItems = $result->num_rows;
if ($numOfItems > 0) {
    // Display each returned item in a form.
	echo '<form id="orderForm" action="processOrder.php" method="post">';
		echo '<form id="orderForm" action="processOrder.php" method="post" onsubmit="return validateOrder()">';
	$previousProductGroupNumber = 0;
	// output data of each row
	while($row = $result->fetch_assoc()) {
	    if ($row["product_group_number"] != $previousProductGroupNumber) {
            echo '<hr>';
            echo '<div class="cursiveText">';
            echo '<p>' . $row["product_group_name"] . '</p>';
            echo '</div>';
	        $previousProductGroupNumber = $row["product_group_number"];
	    }
	    $price = number_format($row["price"], 2);
	    echo '	<div class="column">';
	    echo '			<div class="card">';
	    echo '				<img align="right" src="' . $row["image_url"] . '" style="width: 50%>';
	    echo '				<div class="container">';
	    echo '					<h2 class="productTitle">' . $row["product_name"] . '</h2>';
	    echo '					<p class="center">' . $currency . $price . '</p>';
	    echo '					<p class="center">' . $row["description"] . '</p>';
	    echo '					<input type="hidden" name="productId[]" value="' . $row["id"] . '">';
	    echo '					<input type="hidden" name="productName[]" value="' . $row["product_name"] . '">';
	    echo '					<input type="hidden" name="price[]" value=' . $price . '>';
	    echo '					<div class="center">';
	    echo '						Quantity: <input name="quantity[]" type="number" min="0" max="15" value="0" maxlength="2" onchange="updateTotal(' . $row["id"] . ', this.value, ' . $price . ')">';
	    echo '					</div>';
	    echo '					<br>';
	    echo '				</div>';
	    echo '			</div>';
	    echo '		</div>';
	}
	echo '<div>';
	echo '	<p class="center">';
	echo '		Order Total: ' . $currency . '<span id="orderTotal"></span>';
	echo '	</p>';
	echo '</div>';
	echo '<br> <input type="Submit" value="Submit Order" class="button">';
	echo '<br> <br> <input type="Reset" value="Reset Order" class="button" onclick="resetForm()">';
	echo '</form>';
} else {
    echo '<br><p class="center">There are no items on the product list.</p>';
}
	
$sql = "SELECT a.bookings_id, a.booking_name, a.start_date, b.booking_group_number, b.booking_group_name
        FROM bookings a, booking_group b
        WHERE b.booking_group_number = a.booking_group
        ORDER BY b.booking_group_number, a.bookings_id";
$result = $conn->query($sql);
$numOfItems = $result->num_rows;
if ($numOfItems > 0) {
    // Display each returned item in a form.
	echo '<form id="orderForm" action="processAppointment.php" method="post" >';
        echo '<form id="orderForm" action="processAppointment.php" method="post" onsubmit="return updateQuantitys()">';
	

	
	$previousBookingGroupNumber = 0;
	// output data of each row
	while($row = $result->fetch_assoc()) {
	    if ($row["booking_group_number"] != $previousBookingGroupNumber) {
            echo '<hr>';
            echo '<div class="cursiveText">';
            echo '<p>' . $row["booking_group_name"] . '</p>';
            echo '</div>';
	        $previousBookingGroupNumber = $row["booking_group_number"];
	    } 
		
	    $bookings_id = number_format($row["bookings_id"], 2);
	    echo '	<div class="column">';
	    echo '			<div class="card">';
	    echo '				<div class="container">';
	    echo '					<h2 class="bookingTitle">' . $row["booking_name"] . '</h2>';
	    echo '					<br>';
	    echo 					"This appointment is for " . date("Y/m/d") . "<br>";
	    echo '					<input type="hidden" name="bookings_Id[]" value="' . $row["id"] . '">';
	    echo '					<input type="hidden" name="BookingName" value="' . $row["booking_name"] . '">';
	    echo '					<div class="center">';
            echo '					<br>';
 	    echo '						Quantity: <input name="quantitys[]" type="number" min="0" max="1" value="0" maxlength="1" >';
 	    echo '					<br>';
	    echo '					<br>';
	    echo '                 <input type="Submit" value="Confirm Appointment" class="button">';
	    echo '					</div>';
	    echo '					<br>';
	    echo '				</div>';
	    echo '			</div>';
	    echo '		</div>';
	}
	echo '<div>';
	echo '	<p class="center">';
	echo '	</p>';
	echo '</div>';
	echo '<br> <input type="Submit" value="Confirm Appointment" class="button">';
	echo '<br> <br> <input type="Reset" value="Clear Appointment"  " class="button" onclick="resetForm()">';
	echo '</form>';
} else {
    echo '<br><p class="center">There are no items on the product list.</p>';
}
// Close the connection.
$conn->close();
?>
	<div id="Copyright" class="center">
		<h5>&copy; 2021, Danielle Murphy. 10553937 All rights reserved.</h5>
	</div>
	<script>
		document.getElementById("orderTotal").innerHTML = "0.00";
<?php
    echo 'var itemTotals = new Array(' . $numOfItems . ');'
?>
		var i;
		for (i = 0; i < itemTotals.length; i++) {
			itemTotals[i]=0.00;
		}
		function calculateOrderTotal() {
			var orderTotal = 0.00;
			var i;
			for (i = 0; i < itemTotals.length; i++) {
				orderTotal += itemTotals[i];
			}
			return orderTotal;
		}
		function resetForm() {
			document.getElementById("orderForm").reset();
			document.getElementById("orderTotal").innerHTML = "0.00";
			var i;
			for (i = 0; i < itemTotals.length; i++) {
			  itemTotals[i] = 0.00;
			}
		}
		function updateTotal(itemNo, quantity, price) {
			var amount = quantity * price;
			itemTotals[itemNo] = amount;
			var totalAmount = calculateOrderTotal().toFixed(2);
			document.getElementById("orderTotal").innerHTML = totalAmount;
		}
		function confirmAppointment() {
			alert('your appointment is for $booking_name');
		}

		

		}
	</script>

</body> 
</html>
