<?php 
	$pluginData = OpenVBX::$currentPlugin->getInfo();
	require_once $pluginData['plugin_path'] . '/Test.class.php';
	$test = new Test(OpenVBX::$currentPlugin);
	$exception = false;
	if(isset($_POST['callsid'])){
		$test->setCallSid($_POST['callsid']);
	}
	try{
		if(isset($_POST['test']) AND array_key_exists($_POST['flow'], $test->getFlows())){
			$test->callFlow($_POST['flow']);
		}
	} catch (Exception $exception) {
	}
?>
<div class="vbx-plugin">
<?php if( $exception ){?>
	<div class="notify">
		<p class="message">Could not call your OpenVBX Browser Phone - is it online?<a href class="close action"></a></p>
	</div>
<?php }?>
<?php if( $test->getCallSid() ){?>
	<div class="notify">
		<p class="message">Connected to the OpenVBX Browser Phone. You can continue to test without hanging up.<a href class="close action"></a></p>
	</div>
<?php }?>
	<h2>Test Call Flows</h2>
	<p></p>
	<p>Select a call flow to test using the OpenVBX Browser Phone <small>Please make sure you have set your browser phone to online first</small>:</p>
	<form action="" method="post">
		<?php echo form_dropdown('flow', $test->getFlows()) ?>
		<button class="submit-button ui-state-focus" type="submit" name="test"><span>Test Flow</span></button>
		<input type="hidden" name="callsid" value="<?php echo $test->getCallSid()?>">
	</form>
</div>