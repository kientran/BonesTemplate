<?php

// This code exists inside of the page template instanciation

// Template specific classes.  These classes do not exist outside
// of this template
class THeader extends BonesTemplate {
	public function __construct($file='tpl/header.tpl') {
		parent::__construct($file);
	}
}

class TSidebar extends BonesTemplate {
	public function __construct($file='tpl/sidebar.tpl') {
		parent::__construct($file);
	}
}

class TFooter extends BonesTemplate {
	public function __construct($file='tpl/footer.tpl') {
		parent::__construct($file);
	}
}


// We set Template specific variables here, including creating
// child class objects for blocks of the page

// We can obviously include other files outside of template.php
// if we desired.  Of course the more nested it gets the more of a
// performance hit you risk.

// This is a Template Level Include
$includes[] = new PIStyleSheet($this->conf['template']['baseurl'].'css/style.css');
$includes[] = new PIJavascript($this->conf['template']['baseurl'].'js/template.js');
$this->append("includes",BonesTemplate::merge($includes)); // Include it to top stack

$header = new THeader();
// Navigation was defined on site level so we can use it here
$header->set("logourl",$this->conf['template']['baseurl'].'images/logo.png');
$header->set("navigation",printnavigation('HOME'));
$header->set("siteurl",$this->conf['site']['baseurl']);
$header->set("siterss",$this->conf['site']['baseurl'].'rss.xml');
$this->set("header",$header->output());

$sidebar = new TSidebar();
$sidebar->set("headshoturl",$this->conf['template']['baseurl'].'images/headshot.jpg');
$this->set("sidebar",$sidebar->output());

$footer = new TFooter();
$footer->set("navigation",printnavigation());
$this->set("footer",$footer->output());

?>
