<?php
session_start();
include './Model_product_Data.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Products
	</title>
	<link href="style.css" type="text/css" rel="stylesheet">
	<style>
		table {
			border: 1px solid black;
			width: 50rem;
		}
		table th {
			border: 1px solid black;
		}
		table td {
			border: 1px solid black;
		}
	</style>
</head>
<?php
if (!isset($_SESSION['data'])) {
	$_SESSION['data'] = [];
}
// To reset the session Data
if (isset($_POST['resetData'])) {
	session_destroy();
}
?>
<body>
	<div id="header">
		<?php
		include './header.php';
		?>
	</div>
	<div id="main">
		<div id="products">
			<form action="" method="POST">
				<p style="margin-left:2% ">Reset data:
					<button style="margin-left:2% " type=submit name="resetData">&#9850;</button>
				</p>
			</form>
			<!-- To Display products Dynamically -->
			<?php
			foreach ($products as $key => $value) {
				$s .= '<div id="' . $value['id'] . '" class="product">
					<img src="images/' . $value['image'] . '">
					<h3 class="title"><form method="post" action="Controller_cartData.php"><a  href="#">Product ' . $value['id'] . '</a></h3>
					<span>Price:$' . $value['price'] . '.00</span>
					<input type="hidden" name="pid" value="' . $value['id'] . '">
					<button class="add-to-cart" type="submit" name="addToCart">Add To Cart</button></form>
				</div>';
			}
			echo $s;
			?>
			<!-- Dynamic display part ends Here. -->
		</div>
		<br>
		<?php
		// To print the data in the session and display it in table format
		$total = 0;
		$t .=
			"<table><tr> <th><h3>Product ID:</h3></th> <th><h3>Name:</h3></th> <th><h3>Image:</h3></th> <th><h3>Price:</h3></th> <th><h3>Quantity:</h3></th> <th><h3>Delete Product:</h3></th>  </tr>";
		foreach ($_SESSION['data'] as $key => $value) {
			foreach ($products as $key1 => $value1) {

				if ($value['id'] == $value1['id']) {
					$total = $total + ($value1['price'] * $value['quantity']);
					$t .=
						"<tr><td><h3><b>" . $value1['id'] . "</b></h3></td>" . "<td><h3>" . $value1['name'] . "</h3></td>" . "<td>" . "<img src= 'images/" . $value1['image'] . "' style='height:50px ; width:50px ;'></td>" . "<td><h3>$" . ($value1['price'] * $value['quantity']) . "</h3></td>"
						. "<td><p><form method='post' action='Controller_cartData.php'><input type='hidden' name='pid' value='" . $value1['id'] . "'><button name='reduceQuant' style='height:20px ; width:20px ;'>-</button><b>"
						. $value['quantity']
						. "</b><button name='addQuant' style='height:20px ; width:20px ;'>+</button><p></form></td>"
						. "<td><form method='post' action='Controller_cartData.php'><input type='hidden' name='pid' value='" . $value1['id'] . "'><button name='delRow'>Delete</button></form></td></tr>";
				}
			}
		}
		$t .= "</table>";
		echo "<form action='Controller_cartData.php' method='POST'><button typ='submit' name='deleteCart'>Empty cart</button></form><br>";

		echo $t;
		//To display the Total cart bill amount
		echo "<br><h3>Your total Bill is $ $total </h3>";
		?>
	</div>
	<div id="footer">
		<?php
		include './footer.php';
		?>
	</div>
</body>
</html>