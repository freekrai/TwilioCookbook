<?php
include("config.php");
include("pdo.class.php");

include 'Services/Twilio.php';

$qid = $_GET['qid'];

$_SESSION['survey'] = $qid;	// we store the survey in session so we can retrieve it later

$pdo = Db::singleton();

$client = new Services_Twilio($accountsid, $authtoken);

$survey = $pdo->query("SELECT * FROM survey WHERE ID='{$qid}'");
if( $survey->rowCount() >= 1 ){
	$survey = $survey->fetch();
	$message = array();
	$message[] = $survey['question'];
	for($i = 1;$i <= 6;$i++){
		$k = 'answer'.$i;
		if( !empty($survey[ $k ]) ){
			$message[] = $i." - ".$survey[ $k ];
		}
	}
	$message[] = "Reply with the number corresponding to your answer";
	$cnt = count($message);
	$res = $pdo->query("SELECT ID,phone_number FROM subscribers WHERE status='1'");
	while( $row = $res->fetch() ){
		$ph = $row['phone_number'];
		$i = 1;
		foreach($message as $m){
			$m = $m . "({$i} / {$cnt})";
			$smsg = $client->account->sms_messages->create( $fromNumber, $ph, $m );
			$sid = $smsg->sid;
			$sql = "INSERT INTO responses SET phone_number='{$ph}',question_id='{$qid}',sms_sid='{$sid}',answer=''";
			$pdo->exec( $sql );
			$i++;
		}
	}
}
?>
<h2>Survey sent!</h2>
<p><a href="survey-builder.php">Return to home</a></p>