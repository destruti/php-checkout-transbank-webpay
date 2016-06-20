<?php

require $_SERVER["DOCUMENT_ROOT"].'/src/wss/xmlseclibs.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/wss/soap-wsse.php';

class MySoap extends SoapClient {

    private $useSSL = false;

    function getEnv(){
        return $_SERVER["DOCUMENT_ROOT"].'/';
    }

    function __construct($wsdl,$options){
        $locationparts = parse_url($wsdl);
        $this->useSSL = $locationparts['scheme']=="https" ? true:false;
        return parent::__construct($wsdl,$options);
    }

    function __doRequest($request, $location, $saction, $version) {

        if ($this->useSSL){
            $locationparts = parse_url($location);
            $location = 'https://';
            if(isset($locationparts['host'])) $location  .= $locationparts['host'];
            if(isset($locationparts['port'])) $location  .= ':'.$locationparts['port'];
            if(isset($locationparts['path'])) $location  .= $locationparts['path'];
            if(isset($locationparts['query'])) $location .= '?'.$locationparts['query'];
        }

        $doc = new DOMDocument('1.0');

        $doc->loadXML($request);
        $objWSSE = new WSSESoap($doc);

        $objKey  = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1,array('type'=> 'private'));
        $objKey->loadKey($this->getEnv().'src/certs/597020000403.key', TRUE);

        $options = array("insertBefore" => TRUE);
        $objWSSE->signSoapDoc($objKey, $options);
        $objWSSE->addIssuerSerial($this->getEnv().'src/certs/597020000403.crt');

        $objKey = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
        $objKey->generateSessionKey();

        $doc = new DOMDocument();
        $retVal = parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);
        $doc->loadXML($retVal);

        return $doc->saveXML();

    }

}