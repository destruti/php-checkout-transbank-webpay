<?php

class toolbox {

    public static function getUrlWsdl() {
        return 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl';
    }

    public static function getCert() {
        return $_SERVER["DOCUMENT_ROOT"].'/src/certs/597020000403.crt';
    }

    public static function getCertKey() {
        return $_SERVER["DOCUMENT_ROOT"].'/src/certs/597020000403.key';
    }

    public static function website() {
        $http_type = $_SERVER["REQUEST_SCHEME"];
        $http_type = ($http_type!=''?$http_type:'http');
        return $http_type.'://'.$_SERVER["HTTP_HOST"].'/';
    }

    public static function log($message) {
        error_log(date('Y.m.d h:i:s').' > '.var_export($message, true).PHP_EOL, 3, "/tmp/transbank.log");
        file_put_contents("php://stderr", var_export($message, true)."\n");
    }

    public static function printR($message) {
        echo '<br/><pre>';
        print_r($message);
        echo '</pre>';
    }




}