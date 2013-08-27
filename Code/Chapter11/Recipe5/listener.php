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
			$body = censorString( cleanVar($_POST['Body'],'text') );
			$good = 0;
		}else{
			$body = cleanVar($_POST['Body'],'text');
		}
		if( isset($_POST['MediaUrls']) ){
			foreach( $_POST['MediaUrls'] as $media ){
				if( isset($media) && !empty($media) ){
					$media = cache_image( $media,$id );
					if( is_allowed($from,$whitelist) ){
						$good = 1;
					}else{
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
				if( $good ){
					$res = $pdo->query("INSERT INTO call_log SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
				}
			}
		}
	}
