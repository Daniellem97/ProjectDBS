<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Products</title>
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
		// Get the application environment parameters from the Parameter Store.
		include ('getAppParameters.php');

		// Display the server metadata information if the showServerInfo parameter is true.
		include('serverInfo.php');
	?>
	<hr>
	<div class="topnav">
		<a href="index.php">Home</a>
		<a href="shop.php" class="active">Shop</a>
		<a href="orderHistory.php">Order History</a>
	</div>
	
	<div id="mainContent">

		<div id="mainPictures" class="center">
			<hr>
			<h2>Watch our tutorials and then make your own!</h2>
			<table>
				<tr><iframe width="925" height="721"
				src="https://www.youtube.com/embed/TTs2cN46bb0">
				</iframe>
								</tr>
			</table>
			
			<br>

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
        WHERE b.product_group_number = a.product_group AND a.price = 4.90 OR b.product_group_number = a.product_group AND a.price = 1.40 OR b.product_group_number = a.product_group AND a.price = 3.90
        ORDER BY b.product_group_number, a.id";

$result = $conn->query($sql);

$numOfItems = $result->num_rows;

if ($numOfItems > 0)  {

    // Display each returned item in a form.

	echo '<form id="orderForm" action="processOrder.php" method="post" onsubmit="return validateOrder()">';

	$previousProductGroupNumber = 0;

	// output data of each row
	while($row = $result->fetch_assoc()) 
	{

	    if ($row["product_group_number"] != $previousProductGroupNumber)
	    {

            echo '<hr>';
            echo '<div class="cursiveText">';
            echo '<p>' . $row["product_group_name"] . '</p>';
            echo '</div>';

	        $previousProductGroupNumber = $row["product_group_number"];
	    }

	    $price = number_format($row["price"], 2);

	    echo '	<div class="column">';
	    echo '			<div class="card">';
	    echo '				<img align+"right" src="' . $row["image_url"] . '" style="width: 50%">';
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
	echo '	</p>';
	echo '</div>';
	echo '<br> <input type="Submit" value="Submit Order" class="button">';
	echo '<br> <br> <input type="Reset" value="Reset Order" class="button" onclick="resetForm()">';
	echo '</form>';

} else {
    echo '<br><p class="center">There are no items on the product list.</p>';
}


$conn->close();
?>

	<div id="Copyright" class="center">
		<h5>&copy; 2021, Danielle Murphy. 10553937 All rights reserved.</h5>
	</div>
</body>
</html>
