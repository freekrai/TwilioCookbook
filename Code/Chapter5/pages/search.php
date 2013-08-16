<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_CustomsearchService.php';
session_start();
$client = new Google_Client();
$client->setApplicationName('My Google SMS Search tool');
$client->setDeveloperKey('Your Developer Key Here');
$search = new Google_CustomsearchService($client);
$result = $search->cse->listCse($keywords, array(
	'cx' => 'YOUR CUSTOM SEARCH ENGINE CX HERE',
	'num'=> '3',
));
if( count($results['items']) ){
	$msg = array();
	foreach($results['items'] as $item){
		$msg[] = $item['title']." ".$item['link']);
	}
	print_sms_reply( $msg );
}else{
	print_sms_reply("No matches found");
}
