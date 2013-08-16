<?php
	include("config.php");
	include("pdo.class.php");
	$pdo = Db::singleton();

	$result = $pdo->query('SELECT caller, call_time FROM calls');
	echo '<ul>';
	while( $row = $result->fetch() ){
		if( !empty($row['caller_name']) ){
			echo '<li>A call came in on '.date("F j, Y, g:i a",$row['call_time']).' from '.$row['caller'].' ('.$row['caller_name'].')</li>';
		}else{
			echo '<li>A call came in on '.date("F j, Y, g:i a",$row['call_time']).' from '.$row['caller'].'</li>';
		}
	}
	echo '</ul>';
?>
