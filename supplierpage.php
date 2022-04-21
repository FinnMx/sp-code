<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title></title>
</head>
<body>
	<h3 style="color:#00000; text-align:center">RESTOCK DETAILS</h3>

<div class="row">
	<div style="text-align: center;" class="col-12">
		<table class="table table-striped">
		<thead class="table-dark">
		<td>PurchaseID</td>
		<td>SupplierID</td>
		<td>Product_ID</td>
		<td>QuantityRequested</td>
		<td>OrderDate</td>
		<td>Status</td>
		</thead>

		<?php
		session_start();

		$_SESSION['AL'] = "supplier";

	 	$db = new SQLITE3('C:\xampp\htdocs\myDB.db');
		$sql = "SELECT * FROM Stock_Purchases WHERE Status = 'pending' AND Purchase_ID =:pid";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':pid', $_SESSION['pid'], SQLITE3_TEXT);
		$result = $stmt->execute();

		$arrayResult = [];//prepare an empty array first

		while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
				$arrayResult [] = $row; //adding a record until end of records
		}

	 	for ($i=0; $i<count($arrayResult); $i++):
	  	?>
		<tr>
		<td><?php echo $arrayResult[$i]['Purchase_ID']?></td>
		<td><?php echo $arrayResult[$i]['Supplier_ID']?></td>
	 	<td><?php echo $arrayResult[$i]['Product_ID']?></td>
	 	<td><?php echo $arrayResult[$i]['Quantity_Recieved']?></td>
		<td><?php echo $arrayResult[$i]['Order_Date']?></td>
		<td><?php echo $arrayResult[$i]['Status']?></td>
		</tr>

		<?php endfor;?>
 		</table> 
		<form method="post">
			<input type="submit" value="approve" name="approve"/>
			<input type="submit" value="decline" name="decline"/>
		</form>
		<br>
 		<a href="index.php">
   		<input type="button" value="Logout" />
		</a>
 	</div>
 </div>

</body>
<br>

<?php

if(isset($_POST['approve'])){
	$sql = "SELECT * FROM Stock_Purchases WHERE Purchase_ID =:pid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':pid', $_SESSION['pid'], SQLITE3_TEXT);
	$result = $stmt->execute();

	$arrayResult = [];//prepare an empty array first
	
	while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach

	$arrayResult [] = $row; //adding a record until end of records
		
	}


	$sql = "UPDATE Products SET Current_Stock = Current_Stock + :AmountAdded  WHERE Product_ID=:Product_ID";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':AmountAdded', $arrayResult[0]['Quantity_Recieved'], SQLITE3_TEXT);
	$stmt->bindParam(':Product_ID', $arrayResult[0]['Product_ID'], SQLITE3_TEXT);
	$result= $stmt->execute();

	$sql = "UPDATE Stock_Purchases SET Status='approved' WHERE Purchase_ID=:pid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':pid', $_SESSION['pid'], SQLITE3_TEXT);
	$result = $stmt->execute();

	header("Location: supplierlogin.php?approved");
}


if(isset($_POST['decline'])){
	$sql = "SELECT * FROM Stock_Purchases WHERE Purchase_ID =:pid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':pid', $_SESSION['pid'], SQLITE3_TEXT);
	$result = $stmt->execute();

	$arrayResult = [];//prepare an empty array first
	
	while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach

	$arrayResult [] = $row; //adding a record until end of records
		
	}

	$sql = "UPDATE Stock_Purchases SET Status='declined' WHERE Purchase_ID=:pid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':pid', $_SESSION['pid'], SQLITE3_TEXT);
	$result = $stmt->execute();

	header("Location: supplierlogin.php?declined");
}

?>


</html>