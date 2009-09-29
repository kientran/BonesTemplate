<?php

include 'config.php';

// Override values of the previous config file
    $conf['template']['active'] = 'simpletemplate';

    $conf['template']['base'] = "templates/".$conf['template']['active'].'/';
    $conf['template']['baseurl'] = $conf['site']['baseurl'].$conf['template']['base'];


?>
