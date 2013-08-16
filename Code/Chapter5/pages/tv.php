<?php
$key = 'Your API Key';
$zip = $_POST['FromZip'];
$cc = $_POST['FromCountry'];

//	Get the first TV service for this region:

$url = 'http://api.rovicorp.com/TVlistings/v9/listings/services/postalcode/'.$zip.'/info?locale=en-US&countrycode='.$cc.'&apikey='.$key.'&sig=sig';
$services = get_query( $url );
$services = json_decode( $services );
$services = $services->ServicesResult->Services->Service;
if( count($services) ){
	$sid = $services[0]->ServiceId;
	if( !empty($sid) ){
		$url= 'http://api.rovicorp.com/TVlistings/v9/listings/linearschedule/'.$sid.'/info?locale=en-US&duration=60&inprogress=true&apikey='.$key.'&sig=sig';
		$whatson = get_query( $url );		
		$whatson = json_decode( $whatson );
#		echo '<pre>'.print_r($whatson,true).'</pre>';
		$whatson = $whatson->LinearScheduleResult->Schedule->Airings;
		$shows = array();
		$shows[] = "TV Shows starting in the next 60 minutes are:";
		$i = 0;
		foreach( $whatson as $show ){
			$shows[] = $show->Channel.' - '.$show->Title;
			$i++;
			if( $i == 10)	break;			
		}
		print_sms_reply( $shows );
	}
}else{
	print_sms_reply( 'No shows were found for your region.' );
}
