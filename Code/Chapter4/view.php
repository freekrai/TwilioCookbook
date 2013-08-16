<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$pdo = Db::singleton();
$client = new Services_Twilio($accountsid, $authtoken);
?>
<table>
<thead>
<tr>
	<td>Participant</td>
	<td>Muted</td>
	<td></td>
</thead>
<tbody>
<?php
foreach ($client->account->conferences->getIterator(0, 50, array("Status" => "in-progress","FriendlyName" => $_GET['room'])) as $conference ) {
	foreach ($client->account->conferences->get( $conference->sid )->participants as $participant) { 
?>
		<tr>
			<td>
				<?=$participant->sid?>
			</td>
			<td>
				<?=($participant->muted ? "Yes" : "No")?>
			</td>
			<td>
<?php	if( $participant->muted ){	?>
				<a href="unmute.php?sid=<?=$_GET['room']?>&cid=<?=$participant->sid?>">Unmute</a>
<?php	}else{	?>
				<a href="mute.php?sid=<?=$_GET['room']?>&cid=<?=$participant->sid?>">Mute</a>
<?php	}	?>
			</td>
		</tr>
<?php
	}
}
?>
</tbody>
</table>