<?php

if (["SERVER_NAME"] == 'transbank.dev') $env = '/var/www/transbank-webpay-php/';
if (["SERVER_NAME"] == 'transbank-test.herokuapp.com') $env = '/app/';
require $env.'src/class/toolbox.php';

toolbox::log('[INTEGRATION] Enter at Index.php');

?>

<center>

    <img src="<?php echo toolbox::website($env); ?>logos/transbank.png" style="width: 400px;" />
    <br/><br/>

    <img src="<?php echo toolbox::website($env); ?>logos/Logo_Webpay_CyD.jpg" style="width: 200px;" />
    <br/>

    <br/><br/>

    <h1>
        <a href="src/checkout.php">
            <img src="<?php echo toolbox::website($env); ?>logos/buy.png" style="width: 100px;" />
        </a>
    </h1>

    <br/><br/>
    <br/><br/>

    <strong>Tarjeta VISA</strong>
    <br/>4051885600446623 / CVV 123
    <br/> (SUCCESS TRANSACTION)
    <br/>
    <br/>

    <strong>Tarjeta MASTER</strong>
    <br/>5186059559590568 / CVV 123
    <br/> (ERROR TRANSACTION)
    <br/>
    <br/>

    <strong>LOGIN AT TBK</strong>
    <br/>RUT 11.111.111-1
    <br/>PASS 123
    <br/>
    <br/>

</center>