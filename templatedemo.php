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

include_once('./php/config.php');
include_once('./php/bonestemplate.php');
include_once('./php/navigation.php');


$page = new BonesTemplate();
$page->set("title","Template Demo");
$page->set("content",file_get_contents('content.html'));
$page->set("date","");


$includes[] = new PIStyleSheet($conf['template']['baseurl'].'css/style.css');
$includes[] = new PIJavascript($conf['template']['baseurl'].'js/jquery.js');
$page->set("includes",BonesTemplate::merge($includes));

$header = new THeader();
$header->set("navigation",printnavigation('HOME'));
$header->set("siteurl",$conf['site']['baseurl']);
$header->set("siterss",$conf['site']['baseurl'].'rss.xml');
$page->set("header",$header->output());

$sidebar = new TSidebar();
$page->set("sidebar",$sidebar->output());


$footer = new TFooter();
$footer->set("navigation",printnavigation());
$page->set("footer",$footer->output());

echo $page->output();
?>
