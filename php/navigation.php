<?php

// Site Level Object/Fuction.  This can be called by any
// object in the Template tree
function printnavigation($selected="")
{
    include_once 'gagawa-1.2-beta.php';
    $conf = Config::getConf();
    $navigation = $conf['site']['navigation'];

    $ul = new Ul();
    
    foreach ( $navigation as $i => $value){
        $li = new Li();
        $link = new A();
        $link->setHref($value);
        $link->appendChild( new Text( $i ) );
        
        $li->appendChild($link);
        
        if ($selected === $i) $link->setCSSClass('selected');
        
        $ul->appendChild($li);      
    }
    return $ul->write();
}
?>
