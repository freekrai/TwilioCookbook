<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
 
	$client = new Services_Twilio($accountsid, $authtoken); 
	if (!isset($_REQUEST['called'])) {
		$err = urlencode("Must specify your phone number");
		header("Location: record-call.php?msg=$err");
		die;
	}
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$url = str_replace("makecall","recording",$url);

	$call = $client->account->calls->create($fromNumber, $to, 'callback.php?number=' . $_REQUEST['called'],array("record"=>true));
	$msg = urlencode("Connecting... ".$call->sid);
	$_SESSION['csid'] = $call->sid;
	$RecordingUrl = $url."?csid=".$call->sid;
    $subject = "New phone recording from {$_REQUEST['called']}";
    $body = "You have a new phone recording from {$_REQUEST['called']}:\n\n";
    $body .= $RecordingUrl;
    $headers = 'From: noreply@'.$_SERVER['SERVER_NAME'] . "\r\n" .
        'Reply-To: noreply@'.$_SERVER['SERVER_NAME'] . "\r\n" .
        'X-Mailer: Twilio';
    mail($toEmail, $subject, $body, $headers);
	header("Location: record-call.php?msg=$msg");
?>