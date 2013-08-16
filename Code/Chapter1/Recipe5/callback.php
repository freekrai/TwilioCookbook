<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>A customer at the number <?php echo $_REQUEST['number']?> is calling</Say>
    <Dial record=true><?php echo $_REQUEST['number']?></Dial>
</Response>