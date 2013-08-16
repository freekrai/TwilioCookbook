<a href="schedule.php?action=addnew">Schedule new conference</a><hr />
<h2>Conferences</h2>
<table width=100%>
<?php
	$res = $pdo->query("SELECT * FROM conference ORDER BY `timestamp`");
	while( $row = $res->fetch() ){
		$conference = $client->account->conferences->getIterator(0, 50, array("FriendlyName" => $row['ID']));
?>
		<tr>
			<td><?=$row['name']?></td>
			<td><?=date("m-d-Y ",$row['timestamp'])?></td>
			<td>
<?php	if( $conference->status == "in-progress") { ?>
			<a href="monitor.php?room=<?=$row['ID']?>">Monitor</a> | 
			<a href="view.php?room=<?=$row['ID']?>">View Listeners</a>
<?php	}else if( $conference->status == 'completed') {
			getRecording( $conference->sid );
}else{	?>
			Not Yet Started
<?php	}	?>
			</td>
		</tr>
<?php		
	}
?>
	</table>
	<br />
