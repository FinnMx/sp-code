<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<h3 style="color:#00000; text-align:center">ADD PRODUCT</h3>
<br><br>

<body>
 	 <div class="w-box">

	<form style="text-align:center" method="post">

		<label>Item Name:</label>
		<input type="text" name="Item">
		<br>
		<label>Price:</label>
		<input type="number" value="" name="Price" min="1">
		<br>
		<label>CurrentStock:</label>
		<input type="number" value="" name="CurrentStock" min="1">
		<br>
		<label>MinimumStock:</label>
		<input type="number" value="" name="MinimumStock" min="1">
		<br>
		<label>Supplier:</label>
		<input type="text" value="" name="Supplier">
		<br><br>
		<input type="submit" value="Add Item" name="apply">
		<a href="managerpage.php">
   		<input type="button" value="Back" />
		</a>
			<?php
		error_reporting(0);
		if(isset($_POST['apply'])){

		if($_POST['Item'] != '' && $_POST['Price'] != '' && $_POST['CurrentStock'] != '' && $_POST['MinimumStock'] != '' && $_POST['Supplier'] != ''){

		$db = new SQLite3('C:\xampp\htdocs\myDB.db');
	    $sql = "SELECT Supplier_Name FROM Suppliers";
		$stmt = $db->prepare($sql);
		$result = $stmt->execute();

		$arrayResult = [];//prepare an empty array first

		while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
				$arrayResult [] = $row; //adding a record until end of records
		}

		$MakeNewSup = true;

		for($i=0; $i<= count($arrayResult); $i++){
			if($_POST['Supplier'] == $arrayResult[$i][$i]){
				$MakeNewSup = false;
				break;
			} 
		}

		if($MakeNewSup = true){
			$sql = "INSERT INTO Suppliers VALUES(:sid,:sn)";	
			$stmt = $db->prepare($sql);
			$sid = $_POST['Supplier'].rand(100,999);
			$stmt->bindParam(':sid', $sid, SQLITE3_TEXT);
			$stmt->bindParam(':sn', $_POST['Supplier'], SQLITE3_TEXT);
			$result = $stmt->execute();
		}
		else{
			$sql = "SELECT Supplier_ID FROM Suppliers WHERE Supplier_Name=:sn";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':sid', $_POST['Supplier'], SQLITE3_TEXT);
			$result = $stmt->execute();
			$sid = $result;

		}

		$sql = "INSERT INTO Products VALUES(:Product_ID,:Item,:Price,:CurrentStock,:MinimumStock,:Supplier)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':Item', $_POST['Item'], SQLITE3_TEXT);
		$stmt->bindParam(':Price', $_POST['Price'], SQLITE3_TEXT);
		$stmt->bindParam(':CurrentStock', $_POST['CurrentStock'], SQLITE3_TEXT);
		$stmt->bindParam(':MinimumStock', $_POST['MinimumStock'], SQLITE3_TEXT);
		$pdid = substr($_POST['Item'], 0, 2).rand(100,999);
		$stmt->bindParam(':Product_ID', $pdid, SQLITE3_TEXT);
		$stmt->bindParam(':Supplier', $sid, SQLITE3_TEXT);
		$result= $stmt->execute();

		header("Location: managerpage.php");	
	}
	else{
		echo "Please fill all fields.";
	}
}
	?>

	</form>
</div>


</body>
</html>