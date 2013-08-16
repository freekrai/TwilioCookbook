<?php
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<Response>';
	$user_pushed = (int) $_REQUEST['Digits'];
	switch( $user_pushed ){
		case 1:
			echo '<Say>Connecting you to the caller. All calls are recorded.</Say>';
			break;
		default:
			echo '<Hangup />';
			break;
	}
	echo '</Response>';
?>
