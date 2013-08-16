<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';
$action = isset($_GET['action']) ? $_GET['action'] : null;
switch($action){
	case 'save':
		$fields = array('question','answer1','answer2','answer3','answer4','answer5','answer6','status');
		$pfields = array();
		foreach( $fields as $k){
			$v = $_POST[$k];
			$pfields[] = "{$k} = '{$v}'";
		}
		$sql = "INSERT INTO survey SET ".implode(",",$pfields);;
		$pdo = Db::singleton();
		$pdo->exec($sql);
		$qid = $pdo->lastInsertId();
		if( isset($qid) && !empty($qid) ){
?>
			<a href="send-survey.php?qid=<?=$qid?>">Send survey</a> or <a href="survey-builder.php">Return to home</a>
<?php			
		}
	case 'build':
		include("buildform.php");
		break;
	default:
		include("home.php");
		break;
}
?>