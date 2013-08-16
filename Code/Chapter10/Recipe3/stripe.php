<?php
if(count($_POST)){
  PluginData::set('settings', array(
    'api_key' => $_POST['api_key'],
    'card_prompt' => $_POST['card_prompt'],
    'month_prompt' => $_POST['month_prompt'],
    'year_prompt' => $_POST['year_prompt'],
    'require_cvc' => isset($_POST['require_cvc']),
    'cvc_prompt' => $_POST['cvc_prompt']
  ));
}
$settings = PluginData::get('settings', array(
  'api_key' => null,
  'card_prompt' => "Please enter your credit card number followed by the pound sign.",
  'month_prompt' => "Please enter the month of the card's expiration date followed by the pound sign.",
  'year_prompt' => "Please enter the year of the expiration date followed by the pound sign.",
  'require_cvc' => true,
  'cvc_prompt' => "Please enter the card's security code followed by the pound sign."
));
OpenVBX::addJS('script.js');
?>
<div class="vbx-content-main">
  <div class="vbx-content-menu vbx-content-menu-top">
    <h2 class="vbx-content-heading">Stripe Settings</h2>
  </div>
  <div class="vbx-table-section vbx-stripe">
    <form method="post" action="">
      <fieldset class="vbx-input-container">
        <p>
          <label class="field-label">API Key<br/>
            <input type="password" name="api_key" class="medium" value="<?= htmlentities($settings->api_key); ?>" />
          </label>
        </p>
        <p>Please enter what you want to say to your customer as they fill out your order form over the phone.</p>
        <p>
          <label class="field-label">Credit card prompt<br/>
            <textarea rows="10" cols="100" name="card_prompt" class="medium"><?= htmlentities($settings->card_prompt); ?></textarea>
          </label>
        </p>
        <p>
          <label class="field-label">Expiration month prompt<br/>
            <textarea rows="10" cols="100" name="month_prompt" class="medium"><?= htmlentities($settings->month_prompt); ?></textarea>
          </label>
        </p>
        <p>
          <label class="field-label">Expiration year prompt<br/>
            <textarea rows="10" cols="100" name="year_prompt" class="medium"><?= htmlentities($settings->year_prompt); ?></textarea>
          </label>
        </p>
        <p>
          <label class="field-label">
            <input type="checkbox" name="require_cvc" <?= $settings->require_cvc ? ' checked="checked"' : ''; ?> /> Require CVC
          </label>
        </p>
        <p>
          <label class="field-label">Card CVC prompt<br/>
            <textarea rows="10" cols="100" name="cvc_prompt" class="medium"><?= htmlentities($settings->cvc_prompt); ?></textarea>
          </label>
        </p>
        <p><button type="submit" class="submit-button"><span>Save</span></button></p>
      </fieldset>
    </form>
  </div>
</div>