<?php
	include("config.php");
	include("pdo.class.php");
	include("ImageFilter.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();
	
	$body = censorString( cleanVar($_POST['Body'],'text') );
	$from = cleanVar($_POST['From'],'phone');
	$media = '';
	foreach($_POST as $k=>$media){
		if (stristr($k,'MediaUrl') ){
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
