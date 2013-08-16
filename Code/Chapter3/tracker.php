<?php
	include("config.php");
	include("pdo.class.php");

	$pdo = Db::singleton();

	if( isset($_POST['Body']) ){
		$phone = $_POST['From'];
		$phone = str_replace('+','',$phone);
		$action = strtolower($_POST['Body']);
		$sid = $_POST['SmsSid'];
		$sql = "UPDATE responses SET answer='{$action}' WHERE phone_number='{$phone}' AND sms_sid='{$sid}'";
		$pdo->exec( $sql );
		$msg = "Your answer has been recorded";
		print_sms_reply($msg);
	}

	function print_sms_reply ($sms_reply){
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
		echo "<Response>\n<Sms>\n";
		echo $sms_reply;
		echo "</Sms></Response>\n";
	}
?>