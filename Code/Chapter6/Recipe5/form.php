<!DOCTYPE html>
<html>
<head>
<title>Recipe 4 – Chapter 6</title>
</head>
<body>
<h2>Add an order</h2>
<form method="POST" action="orders.php?action=save">
<table>
<tr>
	<td>Order ID</td>
	<td><input type="text" name="name" /></td>
</tr>
<tr>
	<td>Phone Number</td>
	<td><input type="text" name="phone_number" /></td>
</tr>
<tr>
	<td>Order Date</td>
	<td><input type="text" name="timestamp" placeholder="DD/MM/YY HH:MM"/></td>
</tr>
<tr>
	<td>Order Status</td>
	<td>
		<select name="status">
<?php
foreach($statusArray as $k=>$v){
	echo '<option value="'.$k.'">'.$v.'</option>';		
}
?>
		</select>
	</td>
</tr>
</table>
<button type="submit">Save</button>
</form>
</body>
</html>