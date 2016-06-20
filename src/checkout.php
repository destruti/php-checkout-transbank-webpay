<?php

require $_SERVER["DOCUMENT_ROOT"].'/src/wss/soap-validation.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/tbk_TransaccionNormal.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/toolbox.php';

$commerceId   = '597020000403';
$commerceCode = '597020000403';
$buyOrder     = rand(10000000000,90000000000);
$sessionId    = 'integration_tbk';
$returnUrl    = toolbox::website().'src/returnUrl.php?status=success&buyOrder='.$buyOrder;
$finalUrl     = toolbox::website().'src/returnUrl.php?status=error&buyOrder='.$buyOrder;
$amount       = 11000;

$wsTransactionDetail = new wsTransactionDetail();
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

$webpayService = new WebpayService(toolbox::getUrlWsdl());

$initTransactionResponse = $webpayService->initTransaction(array("wsInitTransactionInput" => $wsInitTransactionInput));
$xmlResponse = $webpayService->soapClient->__getLastResponse();

$soapValidation = new SoapValidation($xmlResponse, toolbox::getCert());
$validationResult = $soapValidation->getValidationResult();

$wsInitTransactionOutput = $initTransactionResponse->return;

?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.redirect.submit();
    });
</script>
<form name='redirect' action='<?php echo $wsInitTransactionOutput->url; ?>' method='POST'>
    <input type='hidden' name='token_ws' value='<?php echo $wsInitTransactionOutput->token; ?>'>
</form>