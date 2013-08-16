<?php
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
    <Dial>
        <Conference startConferenceOnEnter='false'><?php echo htmlspecialchars($_REQUEST['name']); ?></Conference>
    </Dial>
</Response>