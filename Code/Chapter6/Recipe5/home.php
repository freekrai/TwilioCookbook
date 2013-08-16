<!DOCTYPE html>
<html>
<head>
<title>Recipe 4 – Chapter 6</title>
</head>
<body>
<a href="orders.php?action=addnew">Add a new order</a><hr />
<h2>Orders</h2>
<table width=100%>
<tr>
	<th>Order ID</th>
	<th>Status</th>
	<th>Order Date</th>
</tr>
<?php
	$pdo = Db::singleton();
	$res = $pdo->query("SELECT * FROM orders ORDER BY `ID`");
	while( $row = $res->fetch() ){
?>
		<tr>
			<td><?=$row['order_key']?></td>
			<td>
<?php
				echo $statusArray[ $row['status'] ];
?>
			</td>
			<td><?=date("m-d-Y ",$row['order_date'])?></td>
			<td>
<?php	if( $row['status'] != "shipped") { ?>
			<a href="orders.php?oid=<?=$row['ID']?>&status=shipped&action=update">Mark as Shipped</a>
			<a href="orders.php?oid=<?=$row['ID']?>&status=fullfillment&action=update">Mark as In Fullfillment</a>
			<a href="orders.php?oid=<?=$row['ID']?>&status=processing&action=update">Mark as In Processing</a>
<?php	}	?>

			</td>
		</tr>
<?php		
	}
?>
	</table>
	<br />
</body>
</html>