<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';
require_once('Services/Twilio/Capability.php');
$pdo = Db::singleton();
$API_VERSION = '2010-04-01';

$APP_SID = 'YOUR APP SID';	

$client = new Services_Twilio($accountsid, $authtoken);
include("monitorjs.php");
$conferences = $client->account->conferences->getPage(0, 50, array('Status' => 'in-progress'));
echo '<p>Found '.$conferences->total.' conference(s)</p>';
echo '<ul>';
foreach ($conferences as $conference) {
	echo '<li><span>'.$conference->friendly_name.'</span> <a href="#"">Listen in</a></li>';
}
echo '</ul>';