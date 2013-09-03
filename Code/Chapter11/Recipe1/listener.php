<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();
	$body = cleanVar($_POST['Body'],'text');
	$from = cleanVar($_POST['From'],'phone');
	$media = '';
	foreach($_POST as $k=>$media){
		if (stristr($k,'MediaUrl') ){
			if( isset($media) && !empty($media) ){
				$media = cache_image( $media,$id );
				$res = $pdo->query("INSERT INTO callog SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
			}
		}
	}
