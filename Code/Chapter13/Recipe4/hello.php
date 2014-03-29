<?php
	session_start();
	include("config.php");
	include 'Services/Twilio/Capability.php';
	
	if( isset($_REQUEST['myname']) ){
		$_SESSION['myname'] = str_replace( " ","_",strtolower($_REQUEST['myname']) );
	}

	if( isset($_SESSION['myname']) ){  
		$capability = new Services_Twilio_Capability($accountsid, $authtoken);
	
		$capability->allowClientOutgoing( $appsid );
		$capability->allowClientIncoming( $_SESSION['myname'] );
		$token = $capability->generateToken();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Client</title>
<?php	if( isset($_SESSION['myname']) ){  ?>
	<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<?php include("clientjs.php");	?>
<?php	}	?>
</head>
<body>
<?php	if( !isset($_SESSION['myname']) ){	?>
	<form method="POST">
	<input type="text" name="myname" placeholder="Enter your name" />
	<button type="submit">Go</button>
	</form>
<?php	}else{	?>
	<button class="call" onclick="call();">Call</button>
	<button class="hangup" onclick="hangup();">Hangup</button>
	
	<input type="text" id="number" name="number" placeholder="Enter a phone number or client to call"/>
	
	<div id="log">Loading pigeons...</div>
<?php	}	?>
</body>
</html>