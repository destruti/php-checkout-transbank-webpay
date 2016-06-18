<?php

require '/var/www/transbank/public/class/toolbox.php';

toolbox::log('CallBack finalUrl');
toolbox::log($_POST);

toolbox::printR($_POST);

echo '<br/><br/>Done';