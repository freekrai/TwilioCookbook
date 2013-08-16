<?php
	$results = stock( $keywords );
	$i = 1;
	$reply = array();
	$quote = $results->quote;
	$msg = $quote->symbol.' - '.$quote->LastTradePriceOnly.' - '.$quote->Change.' - '.$quote->PercentChange;
    $reply[] = $msg;
	print_sms_reply( $reply );

function stock( $symbol ){
	$yelpql = "
	USE 'http://www.datatables.org/yahoo/finance/yahoo.finance.quotes.xml' AS yahoo.finance.quotes;select * from yahoo.finance.quotes where symbol in ('{$symbol}')";
	$result = getResultFromYQL( $yelpql );
	return $result->query->results;
}
?>