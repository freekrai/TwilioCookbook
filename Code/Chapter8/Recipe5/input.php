<?php
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<Response>';
	$user_pushed = (int) $_REQUEST['Digits'];
	switch( $user_pushed ){
		case 1:
			echo '<Say>Our store hours are 8 AM to 8 PM everyday.</Say>';
			break;
		case '2';
			echo '<Say>My pretend company is located at 101 4th Street in Neverland</Say>';
			echo '<Gather action="input.php" numDigits="1">';
			echo '<Say>For directions from the First Star to the right, press 5</Say>';
			echo '<Say>For directions from San Jose, press 6</Say>';
			echo '</Gather>';
			echo "<Say>Sorry, I didn't get your response.</Say>";
			echo '<Redirect method="GET">listener.php</Redirect>';
			break;
		case 3:
			echo '<Gather action="extensions.php" numDigits="1">';
			echo "<Say>Please enter your party's extension.</Say>";
			echo '<Say>Press 0 to return to the main menu</Say>';
			echo '</Gather>';
			echo "<Say>Sorry, I didn't get your response.</Say>";
			echo '<Redirect method="GET">input.php?Digits=2</Redirect>';
			break;
		case 4:
			echo '<Play>duck.mp3</Play>';
			break;
		case 5:
			echo '<Say>Take the first star to the right and follow it straight on to the dawn.</Say>';
			break;
		case 6:
			echo '<Say>Take Cal Train to the Milbrae BART station. Take any Bart train to Powell Street</Say>';
			break;
		default:
			echo "<Say>Sorry, I can't do that yet.</Say>";
			echo '<Redirect>listener.php</Redirect>';
			break;
	}
	echo '<Pause/>';
	echo '<Say>Main Menu</Say>';
	echo '<Redirect>listener.php</Redirect>';
	echo '</Response>';
?>
