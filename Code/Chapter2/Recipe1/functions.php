<?php
function get_usage( $action ){
	global $accountsid;
	$results = array();
	$fields = array();
	$url = "https://api.twilio.com/2010-04-01/Accounts/{$accountsid}/Usage/Records";
	switch($action){
		case 'lm':	//	last month
		    $url = $url."/LastMonth.json";
			break;
		case 'custom':
			$startd = $_GET['startd'];
			$endd = $_GET['endd'];
			$startd = date('Y-m-d',strtotime($startd));
			$endd = date('Y-m-d',strtotime($endd));
		    $url = $url."/Daily.json";
			$fields = array(
				"Category"=>'calls-inbound',
				"StartDate"=>$startd,
				"EndDate"=>$endd
			);
			break;
		case 'all':
		    $url = $url.".json";
			break;
		case 'today':
		default:
			$url = $url."/Today.json";
			break;
	}
	if ( isset($url) ){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERPWD, "{$accountsid}:{$authtoken}");
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    if( count($fields) > 0 ){
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string,'&');
            curl_setopt($ch,CURLOPT_POST,count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        }
	    $results = curl_exec($ch);
	    $info = curl_getinfo($ch);
	    curl_close($ch);
	    return json_decode( $results );
	}
	return array();
}
