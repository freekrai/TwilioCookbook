<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch($action){
	case 'save':
		extract($_POST);
		$timestamp = strtotime( $timestamp );
		$sql = "INSERT INTO conference SET`name`='{$name}',`timestamp`='{$timestamp}'";
		$pdo = Db::singleton();
		$pdo->exec($sql);
		$qid = $pdo->lastInsertId();
		if( isset($qid) && !empty($qid) ){
			foreach($call_name as $k=>$cname){
				$cphone = $call_phone[$k];
				$cstatus = $call_status[$k];
				$sql = "INSERT INTO callers SET conference_id = '{$qid}',`name` = '{$cname}',`phone_number' = '{$cphone}',status='{$cstatus}'";
				$pdo->exec($sql);
			}
		}
		break;
	case 'addnew':
		include("form.php");
		break;
	default:
		include("home.php");
		break;
}
function getRecording($caSID){
	global $accountsid,$authtoken;
    $version = '2010-04-01';
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$accountsid}/Calls/{$caSID}/Recordings.xml";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "{$accountsid}:{$authtoken}");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    $output = simplexml_load_string($output);
    echo "<table>";
    foreach ($output->Recordings->Recording as $recording) {
        echo "<tr>";
        echo "<td>".$recording->Duration." seconds</td>";
        echo "<td>".$recording->DateCreated."</td>";
        echo '<td><audio src="https://api.twilio.com/2010-04-01/Accounts/'.$sid.'/Recordings/'.$recording->Sid.'.mp3" controls preload="auto" autobuffer></audio></td>';
        echo "</tr>";
    }
    echo "</table>";
}