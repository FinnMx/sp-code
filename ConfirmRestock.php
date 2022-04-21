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

<h3 style="color:#00000; text-align:center">CONFIRM RESTOCK</h3>
<br><br>

<body>

	<form style="text-align:center" method="post">

		<label>ProductID:</label>
		<input type="text" value="<?php echo $arrayResult[0];?>" name="ProductID" readonly>
		<br>
		<label>SupplierID:</label>
		<input type="text" value="<?php echo $arrayResult[5];?>" name="SupplierID" readonly>
		<br>
		<label>Current amount:</label>
		<input type="text" value="<?php echo $arrayResult[3];?>" name="Current" readonly>
		<br>
		<label>Amount to buy:</label>
		<input type="numeric" value="" name="AmountAdded" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
		<br>
		<input type="submit" value="Apply" name="apply">
	</form>

</body>
<?php
	if (isset($_POST['apply'])){

		$db = new SQLite3('C:\xampp\htdocs\myDB.db');

		$sql = "INSERT INTO Stock_Purchases VALUES(:puid,:sid,:prid,:qr,:od,:st)";
		$st = "pending";
		$stmt = $db->prepare($sql);
		$puid = substr($_POST['SupplierID'], 0, 2).rand(1000,9999);
		$stmt->bindParam(':puid', $puid, SQLITE3_TEXT);
		$stmt->bindParam(':sid', $_POST['SupplierID'], SQLITE3_TEXT);
		$stmt->bindParam(':prid', $_POST['ProductID'], SQLITE3_TEXT);
		$stmt->bindParam(':qr', $_POST['AmountAdded'], SQLITE3_TEXT);
		$CurrentDate = date("d/m/y h:i:s");
		$stmt->bindParam(':od', $CurrentDate, SQLITE3_TEXT);
		$stmt->bindParam(':st', $st, SQLITE3_TEXT);
		$result= $stmt->execute();

		header("Location: ViewRestocks.php");	

	}
	?>
</html>