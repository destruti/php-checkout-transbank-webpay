<?php

class toolbox {

    public static function website($env) {

        if ($env == '/app/') return 'https://transbank-test.herokuapp.com/';
        return 'http://transbank.dev/';
    }

    public static function log($message) {
        error_log(date('Y.m.d h:i:s').' > '.var_export($message, true).PHP_EOL, 3, "/tmp/transbank.log");
    }

    public static function printR($message) {
        echo '<br/><br/><br/><pre>';
        print_r($message);
        echo '</pre><br/><br/><br/>';
    }



}