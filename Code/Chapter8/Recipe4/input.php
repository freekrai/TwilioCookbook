<?php
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<Response>';
	$user_pushed = (int) $_REQUEST['Digits'];
	switch( $user_pushed ){
		case 1:
			echo '<Say>Our store hours are 8 AM to 8 PM everyday.</Say>';
			break;
		case 2:
			echo '<Gather action="extensions.php" numDigits="1">';
			echo "<Say>Please enter your party's extension.</Say>";
			echo '<Say>Press 0 to return to the main menu</Say>';
			echo '</Gather>';
			echo "<Say>Sorry, I didn't get your response.</Say>";
			echo '<Redirect method="GET">input.php?Digits=2</Redirect>';
			break;
		default:
			echo "<Say>Sorry, I can't do that yet.</Say>";
			echo '<Redirect>listener.php</Redirect>';
			break;
	}
	echo '</Response>';
?>
