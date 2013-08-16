<a href="survey-builder.php?action=build">Add new survey</a><hr />
<h2>Pending Surveys</h2>
<table width=100%>
<?php
	$res = $pdo->query("SELECT * FROM survey WHERE status=0");
	while( $row = $res->fetch() ){
?>
		<tr>
			<td><?=$row['question']?></td>
			<td><a href="send-survey.php?qid=<?=$row['ID']?>">Send</a></td>
		</tr>
<?php		
	}
?>
</table>
<br />
<h2>Sent Surveys</h2>
<table width=100%>
<?php
$res = $pdo->query("SELECT * FROM survey WHERE status=1");
while( $row = $res->fetch() ){
?>
<tr>
	<td><?=$row['question']?></td>
	<td><a href="view-survey.php?qid=<?=$row['ID']?>">View Responses</a></td>
</tr>
<?php
}
?>
</table>