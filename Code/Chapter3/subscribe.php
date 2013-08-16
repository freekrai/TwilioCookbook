<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';
$action = isset($_GET['action']) ? $_GET['action'] : null;
switch($action){
	case 'save':
		$fields = array('phone_number','status');
		$pfields = array();
		$_POST['status'] = 1;
		foreach( $fields as $k){
			$v = $_POST[$k];
			$pfields[] = "{$k} = '{$v}'";
		}
		$sql = "INSERT INTO subscribers SET ".implode(",",$pfields);
		$pdo = Db::singleton();
		$pdo->exec($sql);
		$qid = $pdo->lastInsertId();
		if( isset($qid) && !empty($qid) ){
?>
			<p>Thank you, you have been subscribed to receive surveys</p>
<?php			
		}
	default:
?>
		<h2>Subscribe here to receive surveys</h2>
		<form method="POST" action="subscribe.php?action=save">
		<table>
		<tr>
			<td>Please enter your phone number</td>
			<td><input type="text" name="phone_number" /></td>
		</tr>
		</table>
		<button type="submit">Save</button>
		</form>
<?php
		break;
}
?>