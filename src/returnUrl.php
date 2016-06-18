<?php

if (["SERVER_NAME"] == 'transbank.dev') $env = '/var/www/transbank-webpay-php/';
if (["SERVER_NAME"] == 'transbank-test.herokuapp.com') $env = '/app/';
require $env.'src/class/toolbox.php';

toolbox::log('CallBack returnUrl');
toolbox::log($_POST);

toolbox::printR($_POST);

echo '<br/><br/>Done';