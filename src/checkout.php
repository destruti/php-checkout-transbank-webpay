<?php

require $_SERVER["DOCUMENT_ROOT"].'/src/wss/soap-validation.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/tbk_TransaccionNormal.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/toolbox.php';

$url_wsdl     = 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl';
$SERVER_CERT  = $_SERVER["DOCUMENT_ROOT"].'/src/certs/597020000403.crt';
$commerceId   = '597020000403';
$commerceCode = '597020000403';
$buyOrder     = rand(10000000000,90000000000);
$sessionId    = 'integration_test';
$returnUrl    = toolbox::website().'src/returnUrl.php?status=success&buyOrder='.$buyOrder;
$finalUrl     = toolbox::website().'src/returnUrl.php?status=error&buyOrder='.$buyOrder;
$amount       = '11000';

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

$webpayService = new WebpayService($url_wsdl);

$initTransactionResponse = $webpayService->initTransaction(array("wsInitTransactionInput" => $wsInitTransactionInput));
$xmlResponse = $webpayService->soapClient->__getLastResponse();

$soapValidation = new SoapValidation($xmlResponse, $SERVER_CERT);
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