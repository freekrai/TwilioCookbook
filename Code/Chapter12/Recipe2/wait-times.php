<?php
	include("config.php");	
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');

	$client = new Services_Twilio($accountsid, $authtoken); 
 
	$queues = $client->account->queues->getIterator(0, 50); 
 ?>
 	<table width=100%>
 	<thead>
 	<tr>
 		<th>Sid</th>
 		<th>Friendly Name</th>
 		<th>Calls Currently In Queue</th>
 		<th>Average Wait Time</th>
 	</tr>
 	</thead>
 	<tbody>
 <?php 
	foreach ($queues as $queue) { 
?>
	<tr>
		<td><?= $queue->sid?></td>
		<td><?= $queue->friendly_name?></td>
		<td><?= $queue->current_size?></td>
		<td><?= $queue->average_wait_time?></td>
	</tr>
<?php
	}
?>
	</tbody>
	</table>