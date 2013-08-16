<?php
	include("config.php");
	include("pdo.class.php");

	$pdo = Db::singleton();

	if( isset($_POST['Body']) ){
		$phone = $_POST['From'];
		$phone = str_replace('+','',$phone);
		$action = strtolower($_POST['Body']);
		switch($action){
			case "pause":
				$sql = "UPDATE subscribers SET status=0 WHERE phone_number='{$phone}'";
				$pdo->exec( $sql );
				$msg = "We have unsubscribed you. Text 'unpause' to be resubscribed";
				break;
			case "unpause":
				$sql = "UPDATE subscribers SET status=1 WHERE phone_number='{$phone}'";
				$pdo->exec( $sql );
				$msg = "We have resubscribed you. Text 'pause' to be unsubscribed";
				break;
			default:
				$sid = $_POST['SmsSid'];
				$sql = "UPDATE responses SET answer='{$action}' WHERE phone_number='{$phone}' AND sms_sid='{$sid}'";
				break;
		}
		print_sms_reply($msg);
	}

	function print_sms_reply ($sms_reply){
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
		echo "<Response>\n<Sms>\n";
		echo $sms_reply;
		echo "</Sms></Response>\n";
	}
?>