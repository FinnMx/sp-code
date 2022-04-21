<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title></title>
</head>
<h3 style="color:#00000; text-align:center">PAST ORDER LIST</h3>
<body>

<div class="row">
	<div style = "text-align:center" class="col-12">
		<table class="table table-striped">
		<thead class="table-dark">
		<td>OrderID</td>
		<td>Order Date</td>
		<td>ProductID</td>
		<td>Number Shipped</td>
		</thead>

		<?php
	 	$db = new SQLITE3('C:\xampp\htdocs\myDB.db');
		$sql = "SELECT * FROM Orders";
		$stmt = $db->prepare($sql);
		$result = $stmt->execute();

		$arrayResult = [];//prepare an empty array first

		while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
				$arrayResult [] = $row; //adding a record until end of records
		}


	 	for ($i=0; $i<count($arrayResult); $i++):
	  	?>
		<tr>
		<td><?php echo $arrayResult[$i]['Order_ID']?></td>
		<td><?php echo $arrayResult[$i]['Order_Date']?></td>
	 	<td><?php echo $arrayResult[$i]['Product_ID']?></td>
	 	<td><?php echo $arrayResult[$i]['Number_Shipped']?></td>
	    </a></td>
		</tr>
		<?php endfor;?>
 		</table> 
 		</body>
<a href="employeepage.php">
   <input type="button" value="Back" />
</a>
 	</div>
 </div>

</html>