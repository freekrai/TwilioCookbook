<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");
	
	$pdo = Db::singleton();
	$body = cleanVar($_POST['Body'],'text');
	$from = cleanVar($_POST['From'],'phone');
	$media = '';
	if( isset($_POST['ContentUrls']) ){
		$media = $_POST['ContentUrls'];
		if( isset($media) && !empty($media) ){
			$media = cache_image( $media,$id );
		}
	}
	$res = $pdo->query("INSERT INTO call_log SET msg='{$body}',phonenumber='{$from}',photo='{$media}',type='s'");
