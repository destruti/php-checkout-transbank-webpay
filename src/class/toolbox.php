<?php

class toolbox {

    /**
     * @return string
     * @env integration
     * SET COMMERCEID SEND FROM TRANSBANK SUPORT
     */
    public static function getCommerceId() {
        return '597020000403';
    }

    /**
     * @return string
     * @env integration
     * SET INTEGRATION WS LINK SEND FROM TRANSBANK SUPORT
     */
    public static function getUrlWsdl() {
        return 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl';
    }

    /**
     * @return string
     * @env integration
     * PATH TO crt FILE SEND FROM TRANSBANK SUPORT
     */
    public static function getCert() {
        return $_SERVER["DOCUMENT_ROOT"].'/src/certs/597020000403.crt';
    }

    /**
     * @return string
     * @env integration
     * PATH TO key FILE SEND FROM TRANSBANK SUPORT
     */
    public static function getCertKey() {
        return $_SERVER["DOCUMENT_ROOT"].'/src/certs/597020000403.key';
    }

    /** DONT NEED TO CHANGE AT THIS POINT */

    public static function makeReturnUrl($buyOrder) {
        return self::website().'src/returnUrl.php?status=success&buyOrder='.$buyOrder;
    }

    public static function makeFinalUrl($buyOrder) {
        return self::website().'src/returnUrl.php?status=error&buyOrder='.$buyOrder;
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