<?php
$token = new Services_Twilio_Capability($accountsid, $authtoken);
$token->allowClientOutgoing($APP_SID);
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
<script type="text/javascript">
var conn = null;
$(document).ready(function() {
    Twilio.Device.setup("<?php echo $token->generateToken();?>");
    $("li > a").click(function() {
        name = $(this).prev().text();
        monitorConference(name, $(this));
    });
});
function monitorConference(name, link) {
    if (conn == null){
        conn = Twilio.Device.connect( { 'name' : name } );
        link.text('Leave');
        link.click(function() {
            leaveConference(link);
        });
    }
}
function leaveConference(link) {
    conn.disconnect();
    conn = null;
    link.text('Listen in');
    link.click(function() {
        name = link.prev().text();
        monitorConference(name, link);
    })
}
</script>
