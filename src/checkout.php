<?php

if ($_SERVER["SERVER_NAME"] == 'transbank.dev') $env = '/var/www/transbank-webpay-php/';
if ($_SERVER["SERVER_NAME"] == 'transbank-test.herokuapp.com') $env = '/app/';

require $env.'src/wss/soap-validation.php';
require $env.'src/class/tbk_TransaccionNormal.php';
require $env.'src/class/toolbox.php';

toolbox::log('[INTEGRATION] Enter at checkout.php');

$url_wsdl     = 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl';
$SERVER_CERT  = $env.'src/certs/597020000403.crt';
$commerceId   = '597020000403';
$commerceCode = '597020000403';
$buyOrder     = '0001';
$sessionId    = 'integration_test';
$returnUrl    = toolbox::website($env).'src/returnUrl.php?status=success';
$finalUrl     = toolbox::website($env).'src/returnUrl.php?status=error';
$amount       = '7500';

toolbox::log('[INTEGRATION] Transbank Start SetVars to Checkout');

$wsTransactionDetail    = new wsTransactionDetail();
$wsTransactionDetail->commerceCode = $commerceCode;
$wsTransactionDetail->buyOrder = $buyOrder;
$wsTransactionDetail->amount = $amount;
$wsTransactionDetail->sharesNumber = null;
$wsTransactionDetail->sharesAmount = null;

$wsInitTransactionInput = new wsInitTransactionInput();
$wsInitTransactionInput->wSTransactionType = 'TR_NORMAL_WS';
$wsInitTransactionInput->commerceId = $commerceId;
$wsInitTransactionInput->buyOrder = $buyOrder;
$wsInitTransactionInput->sessionId = $sessionId;
$wsInitTransactionInput->returnURL = $returnUrl;
$wsInitTransactionInput->finalURL = $finalUrl;
$wsInitTransactionInput->transactionDetails = $wsTransactionDetail;

toolbox::log($wsInitTransactionInput);

toolbox::log('[INTEGRATION] Transbank Start WebpayService');

toolbox::log('[INTEGRATION] Transbank Call ' . $url_wsdl);
toolbox::log('[INTEGRATION] Transbank CommerceCode ' . $commerceCode);

$webpayService = new WebpayService($url_wsdl);

toolbox::log('[INTEGRATION] Transbank Start initTransaction');

$initTransactionResponse = $webpayService->initTransaction(array("wsInitTransactionInput" => $wsInitTransactionInput));

toolbox::log('[INTEGRATION] Transbank End initTransaction');

toolbox::log($initTransactionResponse);

$xmlResponse = $webpayService->soapClient->__getLastResponse();

toolbox::log('[INTEGRATION] Transbank xmlResponse');

toolbox::log($xmlResponse);
//toolbox::printR($xmlResponse);

$soapValidation = new SoapValidation($xmlResponse, $SERVER_CERT);

toolbox::log('[INTEGRATION] Transbank soapValidation');

toolbox::log($soapValidation);
//toolbox::printR($soapValidation);

$validationResult = $soapValidation->getValidationResult();

toolbox::log('[INTEGRATION] Transbank validationResult');

toolbox::log($validationResult);
//toolbox::printR($validationResult);

$wsInitTransactionOutput = $initTransactionResponse->return;

toolbox::log($wsInitTransactionOutput);
//toolbox::printR($wsInitTransactionOutput);

toolbox::log('[INTEGRATION] Transbank END');
toolbox::log('[INTEGRATION] Tarjeta VISA 4051885600446623 / 123 OK');
toolbox::log('[INTEGRATION] Tarjeta MAST 5186059559590568 / 123 N-OK');
toolbox::log('[INTEGRATION] RUT 11.111.111-1 / 123');

toolbox::log('[INTEGRATION] token_ws VISA 0001 e8b53e13a145bad1338f9d72386782a04c6e1babe1c7bda1a5f646f0d6db66df');

?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.redirect.submit();
    });
</script>
<form name='redirect' action='<?php echo $wsInitTransactionOutput->url; ?>' method='POST'>
    <input type='hidden' name='token_ws' value='<?php echo $wsInitTransactionOutput->token; ?>'>
</form>