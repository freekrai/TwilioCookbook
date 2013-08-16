<?php
include('Services/Twilio.php');
include("config.php");
include("functions.php");
if( isset($_POST['Body']) ){
	$phone = $_POST['From'];
	$body = $_POST['Body'];
	$from = $_POST['FromCity'].', '.$_POST['FromState'];
	$body = strtolower( $body );
	$keywords = explode(" ",$body);
	$key = $keywords[0];
	unset( $keywords[0] );
	$keywords = implode(" ",$keywords);
	if( file_exists("pages/".$key.".php") ){	//	if a file matching this key exists in the pages folder.. For example: movies, weather, find, tv
		include("pages/".$key.".php");
	}else{
		$lines = array();
		$lines[] = "Hi, thanks for using local search. Please use the following keywords to perform your search.";
		$lines[] = "find 'keyword' to search for local businesses or restaurants";
		$lines[] = "movies to find local movies";
		$lines[] = "weather to get the local forecast";
		$lines[] = "tv to get the local tv listings and see what's on right now";
		$lines[] = "classifieds 'keyword' to search local classifieds";
		$lines[] = "search 'keyword' to search google";
		$lines[] = "stock 'stock symbol' to search the stock market";
		$lines[] = "news to return the latest headline news";
		print_sms_reply ($lines);
	}
}
exit;