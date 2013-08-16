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
?>
<Response>
  <Dial Record=true>
    <Conference
        startConferenceOnEnter='true'
        endConferenceOnExit='true' muted="false">
        <?=$row['ID']?>
    </Conference>
  </Dial>
</Response>
