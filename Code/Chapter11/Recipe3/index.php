<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");

	$pdo = Db::singleton();
	if($_SERVER['HTTP_X_REQUESTED_WITH']==''){
		include("header.php");
	}
	$sql = 'select * from call_log ORDER BY ID DESC';
	$res = $pdo->query( $sql );
	$items = array();
	while( $row = $res->fetch() ){
		$line = array();
		$id = $row['ID'];
		$created = $row['created'];
		$media = $row['photo'];
		$msg = $row['msg'];
		$img = $myUrl.$media.'?' . filemtime( $media );
?>
		<a href="photo.php?id=<?=$id?>" title="<?=$msg?>" class="123btn" data-id="<?=$id?>" data-img="<?=$img?>">
			<img src="<?=$img?>" title="<?=$msg?>" alt="<?=$msg?>" class="photo-image" />
		</a>
<?php
	}
	if($_SERVER['HTTP_X_REQUESTED_WITH']==''){
		include("footer.php");
	}
?>