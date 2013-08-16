<?php
	include("config.php");
	include("pdo.class.php");
	$pdo = Db::singleton();

	require_once("Services/HighriseAPI.class.php");
	
	$highrise = new HighriseAPI();
	$highrise->debug = false;
	$highrise->setAccount( $highrise_account );
	$highrise->setToken( $highrise_apikey );
	
	$people = $highrise->findPeopleBySearchCriteria(
		array('phone'=>$_REQUEST['From'])
	);
	if( count($people) ){
		$p = $people[0];
		$name =$p->getFirstName().' '.$p->getLastName();
		$now = time();
		$sql = "INSERT INTO calls SET caller_name='{$name}',caller='{$_REQUEST['From']}', call_time='{$now}'";
		$pdo->exec( $sql );
	}else{
		$now = time();
		$sql = "INSERT INTO calls SET caller='{$_REQUEST['From']}', call_time='{$now}'";
		$pdo->exec( $sql );
	}
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
	<Gather action="input.php" numDigits="1">
		<Say>Welcome to my pretend company.</Say>
		<Say>For store hours, press 1.</Say>
		<Say>For directions, press 2</Say>
		<Say>To speak to an agent, press 3.</Say>
		<Say>To speak to a duck, press 4.</Say>
		<Say>To leave a message, press 5.</Say>
	</Gather>
	<!-- If customer doesn't input anything, prompt and try again. -->
	<Say>Sorry, I didn't get your response.</Say>
	<Redirect>listener.php</Redirect>
</Response>
