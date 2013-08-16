<?php
	$orders = array(
		'111'=>'shipped',
		'222'=>'processing',
		'333'=>'awaiting fullfillment'
	);
	if( isset($_POST['Body']) ){
		$phone = $_POST['From'];
		$order_id = strtolower($_POST['Body']);
		$status = order_lookup($order_id);
		print_sms_reply("Your order is currently set at status '".$status."'");
	}else{
		print_sms_reply("Please send us your order id and we will look it up ASAP");
	}
	function print_sms_reply ($sms_reply){
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
		echo "<Response>\n<Sms>\n";
		echo $sms_reply;
		echo "</Sms></Response>\n";
	}
	function order_lookup($order_id){
		global $orders;
		if( isset($orders[$order_id]) ){
			return $orders[$order_id];
		}
		return 'No Order Matching that ID was found';
	}
?>