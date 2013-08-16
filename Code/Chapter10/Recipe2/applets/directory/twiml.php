<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/directory.class.php');
include_once(APPPATH.'models/vbx_device.php');
define('SESSION_KEY', AppletInstance::getInstanceId());
session_start();

$directory = new DirectorySearch();

if(isset($_SESSION[SESSION_KEY]['user'])){
	$user = unserialize($_SESSION[SESSION_KEY]['user']);
	if(isset($_REQUEST['RecordingUrl'])){
		OpenVBX::addVoiceMessage(
			$user,
			$_REQUEST['CallGuid'],
			$_REQUEST['Caller'],
			$_REQUEST['Called'],
			$_REQUEST['RecordingUrl'],
			$_REQUEST['Duration']);

		$response = new Response();
		$response->addHangup();
		$response->Respond();
		return;
	} elseif(isset($_REQUEST['DialStatus']) OR isset($_REQUEST['DialCallStatus'])) {
		if(!isset($_REQUEST['DialStatus'])){
			$_REQUEST['DialStatus'] = $_REQUEST['DialCallStatus'];
		}
		if('answered' == $_REQUEST['DialStatus']){
			$response = new Response();
			$response->addHangup();
			$response->Respond();
			return;
		}
		return $directory->connect(new Response(), $user)->Respond();
	}
	return $directory->searchPrompt($directory->errorResponse(new Response()))->Respond();
}
if(isset($_SESSION[SESSION_KEY]['users'])) {
	$users = unserialize($_SESSION[SESSION_KEY]['users']);
	$index = $_REQUEST['Digits'];
	if("0" == $index){
		return $directory->searchPrompt($directory->addMessage(new Response(), 'restartMessage', 'Starting over.'))->Respond();
	} elseif(!isset($users[$index - 1])){
		return $directory->promptMenu($directory->addMessage(new Response(), 'invalidMessage', 'Not a valid selection.'), $users)->Respond();
	}
	unset($_SESSION[SESSION_KEY]['users']);
	$user = $users[$index - 1];
	$_SESSION[SESSION_KEY]['user'] = serialize($user);
	$_SESSION[SESSION_KEY]['number'] = 0;
	$response = new Response();
	$response->addSay("Connecting you to {$user->first_name} {$user->last_name}");
	return $directory->connect($response, $user)->Respond();
}
if(isset($_REQUEST['Digits'])){
	$users = $directory->getMatches($_REQUEST['Digits']);
	if(0 == count($users)){
		return $directory->searchPrompt($directory->addMessage(new Response(), 'nomatchMessage', 'Sorry, no matches found.'))->Respond();
	}
	$_SESSION[SESSION_KEY]['users'] = serialize($users);
	return $directory->promptMenu($directory->addMessage(new Response(), 'menuPrompt', 'Please select a user, or press 0 to search again.'), $users)->Respond();
}
return $directory->searchPrompt(new Response())->Respond();