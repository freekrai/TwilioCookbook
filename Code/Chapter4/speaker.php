<?php
session_start();
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$pdo = Db::singleton();
$client = new Services_Twilio($accountsid, $authtoken);

$room = $_SESSION['room'];
$sql = "SELECT * FROM conference where `ID` = '{$room}'";
$res = $pdo->query( $sql );
$row = $res->fetch();
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
    <Dial>
        <Conference startConferenceOnEnter='false'><?=$row['ID']?></Conference>
    </Dial>
</Response>