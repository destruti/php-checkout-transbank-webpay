<?php

require_once('MySoap.php');

class nullify{
    var $nullificationInput;//nullificationInput
}

class nullificationInput{
    var $commerceId;//long
    var $buyOrder;//string
    var $authorizedAmount;//decimal
    var $authorizationCode;//string
    var $nullifyAmount;//decimal
}

class baseBean{
}

class nullifyResponse{
    var $return;//nullificationOutput
}

class nullificationOutput{
    var $authorizationCode;//string
    var $authorizationDate;//dateTime
    var $balance;//decimal
    var $nullifiedAmount;//decimal
    var $token;//string
}

class capture{
    var $captureInput;//captureInput
}

class captureInput{
    var $commerceId;//long
    var $buyOrder;//string
    var $authorizationCode;//string
    var $captureAmount;//decimal
}

class captureResponse{
    var $return;//captureOutput
}

class captureOutput{
    var $authorizationCode;//string
    var $authorizationDate;//dateTime
    var $capturedAmount;//decimal
    var $token;//string
}

class WSCommerceIntegrationService
{
    var $soapClient;

    private static $classmap = array(
        'nullify'=>'nullify'
        ,'nullificationInput'=>'nullificationInput'
        ,'baseBean'=>'baseBean'
        ,'nullifyResponse'=>'nullifyResponse'
        ,'nullificationOutput'=>'nullificationOutput'
        ,'capture'=>'capture'
        ,'captureInput'=>'captureInput'
        ,'captureResponse'=>'captureResponse'
        ,'captureOutput'=>'captureOutput'
    );

    function __construct($url='https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSCommerceIntegrationService?wsdl') {

        $this->soapClient = new MySoap($url, array("classmap"=>self::$classmap,"trace"=>true,"exceptions"=>true));

    }

    function nullify($nullify) {

        $nullifyResponse = $this->soapClient->nullify($nullify);
        return $nullifyResponse;

    }

    function capture($capture) {

        $captureResponse = $this->soapClient->capture($capture);
        return $captureResponse;

    }

}