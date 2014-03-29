<?php
	include("config.php");	
	header('Content-type: text/xml');	
?>
<Response>
    <Say>You will now be placed on hold to wait for the first available operator.</Say>
    <Dial>
        <Queue url="agent.php"><?= $callqueue ?></Queue>
    </Dial>
</Response>