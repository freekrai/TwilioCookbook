<?php
$const = array();
$const['STRIPE_ACTION'] = 'stripeAction';
$const['STRIPE_COOKIE'] =  'payment-' . AppletInstance::getInstanceId();
$const['GATHER_CARD'] =  'GatherCard';
$const['GATHER_MONTH'] =  'GatherMonth';
$const['GATHER_YEAR'] =  'GatherYear';
$const['GATHER_CVC'] =  'GatherCvc';
$const['SEND_PAYMENT'] =  'SendPayment';
foreach($const as $k=>$v){
	define($k,$v);
}

$response = new TwimlResponse;

$state = array(
	STRIPE_ACTION => GATHER_CARD,
	'card' => array()
);

$ci =& get_instance();
$settings = PluginData::get('settings');
$amount = AppletInstance::getValue('amount');
$description = AppletInstance::getValue('description');
$digits = clean_digits($ci->input->get_post('Digits'));
$finishOnKey = '#';
$timeout = 15;

$card_errors = array(
	'invalid_number' => GATHER_CARD,
	'incorrect_number' => GATHER_CARD,
	'invalid_expiry_month' => GATHER_MONTH,
	'invalid_expiry_year' => GATHER_YEAR,
	'expired_card' => GATHER_CARD,
	'invalid_cvc' => GATHER_CVC,
	'incorrect_cvc' => GATHER_CVC
);

if(is_object($settings))	$settings = get_object_vars($settings);

if(isset($_COOKIE[STRIPE_COOKIE])) {
	$state = json_decode(str_replace(', $Version=0', '', $_COOKIE[STRIPE_COOKIE]), true);
	if(is_object($state))	$state = get_object_vars($state);
}

if($digits !== false) {
	switch($state[STRIPE_ACTION]) {
		case GATHER_CARD:
			$state['card']['number'] = $digits;
			$state[STRIPE_ACTION] = GATHER_MONTH;
			break;
		case GATHER_MONTH:
			$state['card']['exp_month'] = $digits;
			$state[STRIPE_ACTION] = GATHER_YEAR;
			break;
		case GATHER_YEAR:
			$state['card']['exp_year'] = $digits;
			$state[STRIPE_ACTION] = $settings['require_cvc'] ? GATHER_CVC : SEND_PAYMENT;
			break;
		case GATHER_CVC:
			$state['card']['cvc'] = $digits;
			$state[STRIPE_ACTION] = SEND_PAYMENT;
			break;
	}
}
switch($state[STRIPE_ACTION]) {
	case GATHER_CARD:
	default:
		$gather = $response->gather(compact('finishOnKey', 'timeout'));
		$gather->addSay($settings['card_prompt']);
		break;
	case GATHER_MONTH:
		$gather = $response->gather(compact('finishOnKey', 'timeout'));
		$gather->addSay($settings['month_prompt']);
		break;
	case GATHER_YEAR:
		$gather = $response->gather(compact('finishOnKey', 'timeout'));
		$gather->addSay($settings['year_prompt']);
		break;
	case GATHER_CVC:
		$gather = $response->gather(compact('finishOnKey', 'timeout'));
		$gather->addSay($settings['cvc_prompt']);
		break;
	case SEND_PAYMENT:
		require_once(dirname(dirname(dirname(__FILE__))) . '/stripe-php/lib/Stripe.php');
		Stripe::setApiKey($settings['api_key']);
		try {
			$charge = Stripe_Charge::create(array(
				'card' => $state['card'],
				'amount' => $amount,
				'currency' => 'usd',
				'description' => $description
			));
			if($charge->paid && true === $charge->paid) {
				setcookie(STRIPE_COOKIE);
				$next = AppletInstance::getDropZoneUrl('success');
				if(!empty($next))	$response->redirect($next);
				$response->respond();
				die;
			}
		}catch(Exception $e) {
			$error = $e->getCode();
			$response->addSay($e->getMessage());
			if(array_key_exists($error, $card_errors)) {
				$state[STRIPE_ACTION] = $card_errors[$error];
				$response->redirect();
			}else {
				setcookie(STRIPE_COOKIE);
				$next = AppletInstance::getDropZoneUrl('fail');
				if(!empty($next))	$response->redirect($next);
				$response->respond();
				die;
			}
		}
}
setcookie(STRIPE_COOKIE, json_encode($state), time() + (5 * 60));
$response->respond();
