<?php

/*$file="templatecontentdemo";

$_GET['file'] = (isset($_GET['file']) ? $_GET['file'] : $file);

if($_GET['file']) {
        // Add a template suffix
        $file = $_GET['file'] . '.html';
        if(preg_match('/^\w+$/', $_GET['file'])==false ||
                file_exists($file)==false) {
                header("HTTP/1.0 404 Not Found");
                exit;
        }
}

*/

include_once('./php/config.class.php');     // Config loader Class
include_once('./php/bonestemplate.php');    // Template Class
include_once('./php/navigation.php');       // Site level include 

//new Config('config2.php');    // Load a custom config with chained config files!
$conf = Config::getConf();      // Local copy of config for ease of use

$page = new BonesTemplate();
$page->set("title","Template Demo");
$page->set("content",file_get_contents('content.html'));
$page->set("date","");

// These are site level includes.  They will always be available and included
// no matter what template is used
// As noted with the append, it will append to the end of the stack
$includes[] = new PIJavascript($conf['site']['baseurl'].'js/site.js');
$page->append("includes",BonesTemplate::merge($includes));

echo $page->output();
?>
