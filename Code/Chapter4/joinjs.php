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
	$("#joinform").submit(function(e){
		var name = $("#room").val();
		$("#joinform").hide();
		$("#choices").show();
        joinConference(name, $("#linkbtn") );
		e.preventDefault();
		return false;
	});
    $("li > a").click(function() {
        name = $(this).prev().text();
        monitorConference(name, $(this));
    });
});
function joinConference(name, link) {
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
	$("#choices").hide();
	$("#joinform").show();
}
</script>
