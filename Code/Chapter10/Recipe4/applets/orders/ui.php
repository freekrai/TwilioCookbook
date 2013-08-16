<?php
	$flow_type = AppletInstance::getFlowType();
	$vp = AppletInstance::getValue('prompt-text');
	
?>
<div class="vbx-applet monkey-applet">
    <h2>Order Tracking</h2>
    <p>Enter  a custom message that your callers will be greeted by.</p>
    <textarea class="medium" name="prompt-text"><?php 
        echo ( !empty($vp) ? AppletInstance::getValue('prompt-text') : 'Please enter your order id' )
    ?></textarea>
<?php if($flow_type == 'voice'): ?>
	<br/>
	<h2>Next</h2>
	<p>After retrieving the order id, continue to the next applet</p>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div>
<?php endif; ?>
</div>