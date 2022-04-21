<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title></title>
</head>


<?php

	$db = new SQLite3('C:\xampp\htdocs\myDB.db');
	$sql = "SELECT * FROM Products WHERE Product_ID=:Product_ID";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':Product_ID', $_GET['uid'], SQLITE3_TEXT);
	$result= $stmt->execute();
	$arrayResult = [];

	while($row=$result->fetchArray(SQLITE3_NUM)){ // how to read the result from the query

				$arrayResult = $row;															
	}

	?>

	<h3 style="color:#00000; text-align:center">UPDATE PRODUCT</h3>
<br><br>

<body>

	<form style="text-align:center" method="post">

		<label>ProductID:</label>
		<input type="text" value="<?php echo $arrayResult[0];?>" name="ProductID" readonly>
		<br>
		<label>Item:</label>
		<input type="text" value="<?php echo $arrayResult[1];?>" name="Item">
		<br>
		<label>Price:</label>
		<input type="numeric" value="<?php echo $arrayResult[2];?>" name="Price">
		<br>
		<label>CurrentStock:</label>
		<input type="numeric" value="<?php echo $arrayResult[3];?>" name="CurrentStock" readonly>
		<br>
		<label>MinimumStock:</label>
		<input type="numeric" value="<?php echo $arrayResult[4];?>" name="MinimumStock" min="0" 
		onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
		<br><br>
		<input type="submit" value="Apply" name="apply">
		<input type="submit" value="DELETE RECORD" name="delete">
		<br>

		<?php
	if (isset($_POST['apply']) && $_POST['MinimumStock'] >= 1){

		$db = new SQLite3('C:\xampp\htdocs\myDB.db');
		$sql = "UPDATE Products SET Product_Name=:Item, Price=:Price, Minimum_Stock=:MinimumStock WHERE Product_ID=:Product_ID";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':Item', $_POST['Item'], SQLITE3_TEXT);
		$stmt->bindParam(':Price', $_POST['Price'], SQLITE3_TEXT);
		$stmt->bindParam(':CurrentStock', $_POST['CurrentStock'], SQLITE3_TEXT);
		$stmt->bindParam(':MinimumStock', $_POST['MinimumStock'], SQLITE3_TEXT);
		$stmt->bindParam(':Product_ID', $_GET['uid'], SQLITE3_TEXT);
		$result= $stmt->execute();
		header("Location: managerpage.php");	

	}
	elseif (isset($_POST['apply'])) {
		echo "invalid entry";
	}

	if (isset($_POST['delete'])){
		$db = new SQLite3('C:\xampp\htdocs\myDB.db');
		$sql = "DELETE FROM Products WHERE Product_ID =:Product_ID";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':Product_ID', $_GET['uid'], SQLITE3_TEXT);
		$result= $stmt->execute();
		header("Location: managerpage.php");
	}

	?>

	</form>

</body>
</html>