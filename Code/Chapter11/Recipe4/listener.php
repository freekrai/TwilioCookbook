<?php
	include("config.php");
	include("pdo.class.php");
	include("ImageFilter.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();
	
	$body = censorString( $_POST['Body'] );
	$from = $_POST['From'];
	$media = '';
	if( isset($_POST['ContentUrls']) ){
		$media = $_POST['ContentUrls'];
		if( isset($media) && !empty($media) ){
			$media = cache_image( $media,$id );
			$filter = new ImageFilter(); 
			$score = $filter->GetScore( $media ); 
			if( isset($score) ){
				if($score >= 30){
					unlink( $media );
				}else{
					$res = $pdo->query("INSERT INTO callog SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
				}
			}
		}
	}