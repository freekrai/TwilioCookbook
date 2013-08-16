<?php
function get_user($uid){
	if( isset($uid) && !empty($uid) ){
		$pdo = Db::singleton();
		$sql = "SELECT * FROM `user` WHERE `ID`='{$uid}';";
#		echo $sql;
		$res = $pdo->query( $sql );
		while( $row = $res->fetch() ){
			return $row;
		}
	}
	return null;
}

function send_sms($number,$message){
	global $client,$fromNumber;
	$sms = $client->account->sms_messages->create(
		$fromNumber, 
		$number,
		$message
	);
	return $sms->sid;
}

function print_sms_reply ($sms_reply){
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
	echo "<Response>\n";
	if( !is_array($sms_reply) ){
		echo '<Sms>'.$sms_reply.'</Sms>';
	}else{
		$cnt = count($sms_reply);
		$i = 1;
		foreach($sms_reply as $line){
			$line = $line." (".$i."/".$cnt.")";
			echo '<Sms>'.$line.'</Sms>';
			$i++;
		}
	}
	echo "</Response>\n";
}
function usageTriggers($sid,$token,$trigger,$msg,$uid){
	global $mysiteURL;
	$url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Usage/Trigger.xml";
	$data = array();
	$data['FriendlyName'] = $msg;
	$data['Recurring'] = 'daily';
	$data['UsageCategory'] = 'totalprice';
	$data['TriggerBy'] = 'price';
	$data['TiggerValue'] = $trigger;
	$data['CallbackUrl'] = $mysiteURL.'/trigger.php?uid='.$uid;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "{$sid}:{$token}");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$output = simplexml_load_string($output);
	return $output;
}


function editNumber($psid,$fields,$sid,$token){
	$url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/IncomingPhoneNumbers/{$psid}.xml";
	$data = array();
	foreach($fields as $k=>$v){
		$data[$k] = $v;
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "{$sid}:{$token}");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$output = simplexml_load_string($output);
	return $output;
}

function releaseNumber($sid,$token,$psid){
	$url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/IncomingPhoneNumbers/{$psid}.xml";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "{$sid}:{$token}");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$output = simplexml_load_string($output);
	return $output;
}