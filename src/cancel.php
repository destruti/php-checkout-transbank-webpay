<?php

// toolbox::log('token_ws VISA 0001 e8b53e13a145bad1338f9d72386782a04c6e1babe1c7bda1a5f646f0d6db66df');

require '/var/www/transbank/public/wss/soap-validation.php';
require '/var/www/transbank/public/class/tbk_TransaccionAnulacion.php';
require '/var/www/transbank/public/class/toolbox.php';

$url_wsdl     = 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSCommerceIntegrationService?wsdl';
$SERVER_CERT  = '/var/www/transbank/cert4/597020000403.crt';
$commerceId   = '597020000403';
$commerceCode = '597020000403';
$buyOrder     = '0001';
$amount       = '7500';

toolbox::log('Transbank Start SetVars to Nullify');

$nullificationInput = new nullificationInput();
$nullificationInput->commerceId = $commerceId;
$nullificationInput->buyOrder = $buyOrder;
$nullificationInput->authorizedAmount = $amount;
$nullificationInput->authorizationCode = $commerceCode;
$nullificationInput->nullifyAmount = $amount;

$wsNullify = new nullify();
$wsNullify->nullificationInput = $nullificationInput;

toolbox::log($wsNullify);

toolbox::log('Transbank Start nullify');

$integrationService = new WSCommerceIntegrationService($url_wsdl);

$nullifyResponse = $integrationService->nullify(array("nullificationInput"=>$nullificationInput));

$xmlResponse = $integrationService->soapClient->__getLastResponse();

$soapValidation = new SoapValidation($xmlResponse, $SERVER_CERT);

$validationResult = $soapValidation->getValidationResult();

$nullificationOutput = $nullifyResponse->return;

toolbox::log($nullificationOutput);

toolbox::log('Transbank End nullify');

//http://pastebin.com/XUdWBbEw