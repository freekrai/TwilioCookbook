<h2>My Number</h2>
<?php
	$pdo = Db::singleton();
	$sql = "SELECT * FROM `numbers` WHERE `user_id`='{$user['ID']}'";
	$res = $pdo->query( $sql );
	while( $row = $res->fetch() ){
		echo preg_replace("/[^0-9]/", "", $row['number']);
	}
	try {
?>
		<h2>My Call History</h2>
		<p>Here are a list of recent calls, you can click any number to call them back, we will call your registered phone number and then the caller</p>
		<table width=100% class="table table-hover tabled-striped">
		<thead>
		<tr>
			<th>From</th>
			<th>To</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Duration</th>
		</tr>
		</thead>
		<tbody>
<?php
		foreach ($client->account->calls as $call) {
#			echo "<p>Call from $call->from to $call->to at $call->start_time of length $call->duration</p>";
			if( !stristr($call->direction,'inbound') )	continue;
			$type = find_in_list($call->from);
?>
			<tr>
				<td><a href="<?=$uri?>/call?number=<?=urlencode($call->from)?>"><?=$call->from?></a></td>
				<td><?=$call->to?></td>
				<td><?=$call->start_time?></td>
				<td><?=$call->end_time?></td>
				<td><?=$call->duration?></td>
			</tr>
<?php
		}
?>
		</tbody>
		</table>
<?php
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
?>
	<hr />
	<a href="<?=$uri?>/delete" onclick="return confirm('Are you sure you wish to close your account?');">Delete My Account</a>
