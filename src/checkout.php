<?php

require $_SERVER["DOCUMENT_ROOT"].'/src/wss/soap-validation.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/tbk_TransaccionNormal.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/toolbox.php';

$buyOrder = rand(10000000000,90000000000);

$wsTransactionDetail = new wsTransactionDetail();
$wsTransactionDetail->commerceCode = toolbox::getCommerceId();
$wsTransactionDetail->buyOrder = $buyOrder;
$wsTransactionDetail->amount = 11000;
$wsTransactionDetail->sharesNumber = null;
$wsTransactionDetail->sharesAmount = null;

$wsInitTransactionInput = new wsInitTransactionInput();
$wsInitTransactionInput->wSTransactionType = 'TR_NORMAL_WS';
$wsInitTransactionInput->commerceId = toolbox::getCommerceId();
$wsInitTransactionInput->buyOrder = $buyOrder;
$wsInitTransactionInput->sessionId = 'integration_tbk';
$wsInitTransactionInput->returnURL = toolbox::makeReturnUrl($buyOrder);
$wsInitTransactionInput->finalURL = toolbox::makeFinalUrl($buyOrder);
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