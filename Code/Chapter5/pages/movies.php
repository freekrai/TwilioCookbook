<?php
	$movies = movies( $from );
	print_sms_reply( $movies );

function movies( $location ){
	require_once('simple_html_dom.php');
	$str = get_query( 'http://www.google.com/movies?near='.urlencode($location) );
	$html = str_get_html($str);
	$lines = array();
	foreach($html->find('#movie_results .theater') as $div) {
		$i = 0;
	    foreach($div->find('.movie') as $movie) {
		    $times = remEntities( strip_tags( $movie->find('.times',0)->innertext ) );
		    $line = strip_tags( $movie->find('.name a',0)->innertext).' [ '.$times.' ] @ '.strip_tags( $div->find('h2 a',0)->innertext );
	        $lines[ $line ] = $line;
	        $i++;
			if( $i == 10)	break;			
	    }
	    break;
	}
	$html->clear();
	return $lines;		
}

?>