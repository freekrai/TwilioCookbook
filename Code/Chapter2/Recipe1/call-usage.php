<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
 	include("functions.php");
 
	$client = new Services_Twilio($accountsid, $authtoken);

	$action = isset($_GET['action']) ? $_GET['action'] : 'today';
?>
	<nav>
		<a href="call-usage.php?action=today">Today</a>
		<a href="call-usage.php?action=lm">Last Month</a>
		<a href="call-usage.php?action=all">All Calls</a>
		<span>Custom Report:</span>
		<form action="" method="GET">
			<input type="hidden" name="action" value="custom" />
			<input type="date" name="startd" placeholder="Start Date" />
			<input type="date" name="endd" placeholder="End Date" />
			<button type="submit">Generate</button>
		</form>
	</nav>
	<hr />
<?php
	$results = get_usage($action){

	if( count($results > 0) ){
#		echo '<pre>'.print_r($results,true).'</pre>';
?>
		<table width=100%>
		<thead>
		<tr>
			<th>Category</th>
			<th>Description</th>
			<th>SID</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Usage</th>
			<th>Usage Unit</th>
			<th>Price</th>
			<th>Price Unit</th>
		</tr>
		</thead>
		<tbody>
<?php	foreach( $results->usage_records as $row ){	?>
		<tr>
			<td><?= $row->category?></td>
			<td><?= $row->description?></td>
			<th><?= $row->account_sid?></th>
			<td><?= $row->start_date?></td>
			<td><?= $row->end_date?></td>
			<td><?= $row->usage?></td>
			<td><?= $row->usage_unit?></td>
			<td><?= $row->price?></td>
			<td><?= $row->price_unit?></td>
		</tr>
<?php 	}	?>
		</tbody>
		</table>
<?php
	}
?>