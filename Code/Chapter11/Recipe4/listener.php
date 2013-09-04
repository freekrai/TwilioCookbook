<?php
	include("config.php");
	include("pdo.class.php");
	include("ImageFilter.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();
	
	$body = censorString( cleanVar($_POST['Body'],'text') );
	$from = cleanVar($_POST['From'],'phone');
	$media = '';
	$numMedia = $_POST['NumMedia'];
	if( $numMedia > 0 ){
		for ($i = 0; $i <= $numMedia; $i++) {
			$key = 'MediaUrl'.$i;
			$media = $_POST[$key];
			if( isset($media) && !empty($media) ){
				$media = cache_image( $media,$id );
				$filter = new ImageFilter(); 
				$score = $filter->GetScore( $media ); 
				if( isset($score) ){
					if($score >= 30){
						unlink( $media );
					}else{
						$res = $pdo->query("INSERT INTO call_log SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
					}
				}
			}
		}
	}
