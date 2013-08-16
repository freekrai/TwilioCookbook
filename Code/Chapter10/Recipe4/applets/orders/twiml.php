<?php
$ci =& get_instance();

$flow_type = AppletInstance::getFlowType();

if($flow_type != 'voice'){
	$orderid = $_REQUEST['Body'];
}else{
	$digits = clean_digits($ci->input->get_post('Digits'));
	if(!empty($digits))	$orderid = $digits;
}
$prefs = array(
  'voice' => $ci->vbx_settings->get('voice', $ci->tenant->id),
  'language' => $ci->vbx_settings->get('voice_language', $ci->tenant->id)
);

$response = new TwimlResponse;

if(!empty($orderid)) {
	$settings = PluginData::get('orders', array(
		'keys' => array(),
		'status' => array(),
	));
	$statusArray = array(
		'shipped'=>'Shipped',
		'fullfillment'=>'Sent to Fullfillment',
		'processing'=>'Processing'
	);
	$s = '';
	$keys = $settings->keys;
	$status = $settings->status;
	foreach($keys as $i=>$key ){
		if( $key == $orderid ){
			$s = $statusArray[ $status[$i] ];
			break;
		}
	}
	if( $s != '' ){
		$response->say("Your order is marked as {$s}.", $prefs);
		if(AppletInstance::getFlowType() == 'voice') {
			$next = AppletInstance::getDropZoneUrl('next');
			if(!empty($next))	$response->redirect($next);
		}
	}else{
		$response->say("We could not find your order.", $prefs);		
	}
}elseif($flow_type == 'voice' ) {
	$gather = $response->gather(array('numDigits' => 5));
	$gather->say( AppletInstance::getValue('prompt-text'), $prefs );
	$response->redirect();
}elseif($flow_type != 'voice' ) {
	$response->say( AppletInstance::getValue('prompt-text') );
}

$response->respond();