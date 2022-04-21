<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title></title>
</head>

	<h3 style="color:#00000; text-align:center">CREATE ORDER</h3>
	<br><br>

<body>
	<?php
	session_start();

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

	<form style="text-align: center;" method="post">

		<label>ItemID:</label>
		<input type="text" value="<?php echo $arrayResult[0];?>" name="Item" readonly>
		<br>
		<label>Stock:</label>
		<input type="text" value="<?php echo $arrayResult[3];?>" name="Stock" readonly>
		<br>
		<label>Order Amount:</label>
		<input type="text" value="0" name="Amount">
		<br>
		<input type="submit" value="Confirm" name="apply">
		<a href="managerpage.php">
   		<input type="button" value="Back" />	
		</a>
		<br>
		<?php

	if (isset($_POST['apply']) && $_POST['Stock'] - $_POST['Amount'] >= 1){
		$NewAmount = $_POST['Stock'] - $_POST['Amount'];

		$db = new SQLite3('C:\xampp\htdocs\myDB.db');
		$sql = "UPDATE Products SET Current_Stock=:Currentstock WHERE Product_ID=:Product_ID";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':Currentstock', $NewAmount, SQLITE3_TEXT);
		$stmt->bindParam(':Product_ID', $_GET['uid'], SQLITE3_TEXT);
		$result= $stmt->execute();

		$OrderID = substr($_GET['uid'], 0).rand(10000,99999);
		$CurrentDate = date("d/m/y h:i:s");

		$sql = "INSERT INTO Orders Values ('$OrderID', '$CurrentDate',:item,:numShipped)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':numShipped', $_POST['Amount'], SQLITE3_TEXT);
		$stmt->bindParam(':item', $_GET['uid'], SQLITE3_TEXT);
		$result= $stmt->execute();

		if($_SESSION['AL'] == "employee"){			
			header("Location: OrderListEmployee.php");
		}
		else{
			header("Location: OrderList.php");
		}

	}
	elseif(isset($_POST['apply']) && $_POST['Stock'] - $_POST['Amount'] <= 0){
		echo "invalid";

	}

?>

	</form>


</body>

</html>