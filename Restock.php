<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title></title>
</head>

<h3 style="color:#00000; text-align:center">RESTOCK LIST</h3>

<body>

	<div class="row">
	<div style="text-align: center;"class="col-12">
		<table class="table table-striped">
		<thead class="table-dark">
		<td>ProductID</td>
		<td>Item</td>
		<td>Price</td>
		<td>CurrentStock</td>
		<td>MinimumStock</td>
		<td>SupplierID</td>
		<td>Restock Order</td>
		</thead>

		<?php
	 	$db = new SQLITE3('C:\xampp\htdocs\myDB.db');
		$sql = "SELECT * FROM Products WHERE Minimum_Stock >= Current_Stock";
		$stmt = $db->prepare($sql);
		$result = $stmt->execute();

		$arrayResult = [];//prepare an empty array first

		while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
				$arrayResult [] = $row; //adding a record until end of records
		}


	 	for ($i=0; $i<count($arrayResult); $i++):
	  	?>
		<tr>
		<td><?php echo $arrayResult[$i]['Product_ID']?></td>
		<td><?php echo $arrayResult[$i]['Product_Name']?></td>
	 	<td><?php echo $arrayResult[$i]['Price']?></td>
	 	<td><?php echo $arrayResult[$i]['Current_Stock']?></td>
		<td><?php echo $arrayResult[$i]['Minimum_Stock']?></td>
		<td><?php echo $arrayResult[$i]['Supplier_ID']?></td>
		<td><a href="ConfirmRestock.php?uid=<?php echo $arrayResult[$i]['Product_ID']; ?>">Reorder
	    </a></td>
		</tr>
		<?php endfor;?>
 		</table> 
 		<a href="managerpage.php">
  			<input type="button" value="Back" />
		</a>
		<a href="ViewRestocks.php">
  			<input type="button" value="View Past Restocks" />
		</a>
 	</div>
 </div>

</body>
</html>