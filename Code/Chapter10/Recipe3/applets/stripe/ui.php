<?php
	$settings = PluginData::get('settings');
	if(is_object($settings)){
		$settings = get_object_vars($settings);
	}
?>
<div class="vbx-applet">
<?php if( empty($settings) || empty($settings['api_key'])){ ?>
	<div class="vbx-full-pane">
		<h3><em>Please set your Stripe.com settings first.</em></h3>
	</div>
<?php }else{ ?>
	<div class="vbx-full-pane">
		<h3>Amount to charge in cents?</h3>
		<p>How much money in cents to charge the card <small>($5.00 would be 500 cents)</small>.</p>
		<fieldset class="vbx-input-container">
			<input type="text" name="amount" class="medium" value="<?php echo AppletInstance::getValue('amount', 50); ?>" />
		</fieldset>
		<h3>What they are paying for?</h3>
		<fieldset class="vbx-input-container">
			<input type="text" name="description" class="medium" value="<?php echo AppletInstance::getValue('description'); ?>" />
		</fieldset>
	</div>
	<h2>What to do after the payment</h2>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('success'); ?>
	</div>
	<h2>If the payment fails</h2>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('fail'); ?>
	</div>
<?php } ?>
</div>
