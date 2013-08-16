<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");

	$pdo = Db::singleton();
	$sql = 'select * from callog ORDER BY ID DESC';
	$res = $pdo->query( $sql );
?>
	<table width=100%>
	<thead>
	<tr>
		<th>From</th>
		<th>Message</th>
		<th>Media</th>
		<th>Sent</th>
	</tr>
	</thead>
	<tbody>	
<?php
	while( $row = $res->fetch() ){
		$line = array();
		$id = $row['ID'];
		$created = $row['created'];
		$media = $row['photo'];
		$msg = $row['body'];
		$from = $row['phonenumber'];
		$img = $myUrl.$media.'?' . filemtime( $media );
?>
	<tr>
		<td><?=$from?></td>
		<td><?=$msg?></td>
		<td><img src="<?=$img?>" /></td>
		<td><?=$created?></td>
	</tr>
<?php
	}
?>
	</tbody>
	</table>