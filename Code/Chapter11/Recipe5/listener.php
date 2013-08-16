<?php
	include("config.php");
	include("pdo.class.php");
	include("ImageFilter.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();

	$from = clean_number($_POST['From']);
	
	if( !is_banned($from,$blacklist) ){
		$good = 1;
		if( !is_allowed($from,$whitelist) ){
			$body = censorString( $_POST['Body'] );
			$good = 0;
		}else{
			$body = $_POST['Body'];
		}
		if( isset($_POST['ContentUrls']) ){
			$media = $_POST['ContentUrls'];
			if( isset($media) && !empty($media) ){
				$media = cache_image( $media,$id );
				if( !is_allowed($from,$whitelist) ){
					$filter = new ImageFilter(); 
					$score = $filter->GetScore( $media ); 
					if( isset($score) ){
						if($score >= 30){
							unlink( $media );
						}else{
							$good = 1;
						}
					}
				}
			}
		}
		if( $good ){
			$res = $pdo->query("INSERT INTO callog SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
		}
	}
