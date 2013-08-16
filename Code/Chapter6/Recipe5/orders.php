<?php
	include('Services/Twilio.php');
	include("config.php");
	include("pdo.class.php");
	include("functions.php");

	$client = new Services_Twilio($accountsid, $authtoken);

	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	switch($action){
		case 'update':
			$oid = $_GET['oid'];
			$status = $_GET['status'];
			$now = time();
			$sql = "UPDATE orders SET `status`='{$status}',`order_date`='{$now}' WHERE ID='{$oid}'";
			$pdo = Db::singleton();
			$pdo->exec($sql);
			$sql = "SELECT * FROM orders where `ID` = '{$oid}'LIMIT 1";
			$res = $pdo->query( $sql );
			while( $row = $res->fetch() ){
				$message = "Your order has been set to ".$statusArray[$status];
				send_sms($row['phone_number'],$message);
			}
			header("location: orders.php");
			exit;
			break;
		case 'save':
			extract($_POST);
			$now = time();
			$sql = "INSERT INTO orders SET `order_key`='{$name}',`status`='{$status}',`phone_number`='{$phone_number}',`order_date`='{$now}'";
			$pdo = Db::singleton();
			$pdo->exec($sql);
			header("location: orders.php");
			exit;
			break;
		case 'addnew':
			include("form.php");
			break;
		default:
			include("home.php");
			break;
	}