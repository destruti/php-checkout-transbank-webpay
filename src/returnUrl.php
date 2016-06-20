<?php

require $_SERVER["DOCUMENT_ROOT"].'/src/wss/soap-validation.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/tbk_TransaccionNormal.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/class/toolbox.php';

toolbox::printR('returned vars POST');
toolbox::printR($_POST);

toolbox::printR('returned vars GET');
toolbox::printR($_GET);

$token_ws = $_POST['token_ws'];

$getTransactionResult = new \getTransactionResult();
$getTransactionResult->tokenInput = $token_ws;

$webpayService = new \WebpayService(toolbox::getUrlWsdl());
$getTransactionResultResponse = $webpayService->getTransactionResult($getTransactionResult);

$xmlResponse = $webpayService->soapClient->__getLastResponse();
$soapValidation = new \SoapValidation($xmlResponse, toolbox::getCert());
$soapValidation->getValidationResult();

$response = $getTransactionResultResponse->return;

toolbox::printR('getTransactionResult');
toolbox::printR($response);

if ($_GET['status'] == 'success') {

    $acknowledgeTransaction = new \acknowledgeTransaction();
    $acknowledgeTransaction->tokenInput = $token_ws;

    $webpayService = new \WebpayService(toolbox::getUrlWsdl());
    $webpayService->acknowledgeTransaction($acknowledgeTransaction);

    $xmlResponse = $webpayService->soapClient->__getLastResponse();
    $soapValidation = new \SoapValidation($xmlResponse, toolbox::getCert());
    $soapValidation->getValidationResult();

    toolbox::printR('acknowledge done');

} else {

    toolbox::printR('somethings wrong');

}

toolbox::printR('end');