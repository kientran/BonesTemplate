<?php
/*
http://www.broculos.net/tutorials/how_to_make_a_simple_html_template_engine_in_php/20080315/en
*/

class BonesTemplate {
	protected $file;
	protected $values = array();
	protected $conf = array();
	
	public function __construct($file='template.tpl',$config="config.php") {
		include($config);
		$this->file = $conf['template']['base'].$file;
		$this->set("templatebaseurl",$conf['template']['baseurl']);		
	}
	
	public function set($key, $value) {
    $this->values[$key] = $value;
	}
 
	public function output() {
	    if (!file_exists($this->file)) {
	        return "Error loading template file ($this->file).<br />";
	    }
	    $output = file_get_contents($this->file);
	 
	    foreach ($this->values as $key => $value) {
	        $tagToReplace = "[@$key]";
	        $output = str_replace($tagToReplace, $value, $output);
	    }
	 
	    return $output;
	}
	
	static public function merge($templates, $separator = "\n") {
	    $output = "";
	 
	    foreach ($templates as $template) {
	        $content = (!is_a($template, "BonesTemplate"))
	            ? "Error, incorrect type - expected BonesTemplate.".get_class($template)
	            : $template->output();
	        $output .= $content . $separator;
	    }
	 
	    return $output;
	}

}

class THeader extends BonesTemplate {
	public function __construct($file='header.tpl') {
		parent::__construct($file);
	}
}

class TSidebar extends BonesTemplate {
	public function __construct($file='sidebar.tpl') {
		parent::__construct($file);
	}
}

class TFooter extends BonesTemplate {
	public function __construct($file='footer.tpl') {
		parent::__construct($file);
	}
}

class PageIncludes extends BonesTemplate {
	protected $url;
	protected $type;
	
	public function __construct($url,$type,$config='config.php') {
		include($config);
		$this->url = $url;
		$this->type = $type;
	}
}

class PIStyleSheet extends PageIncludes {
	protected $media;
	public function __construct($url, $media='all', $type='text/css') {
		parent::__construct($url,$type);
		$this->media = $media;
	}
	
	public function output() {
		$output = "<link rel='stylesheet' href='$this->url' type='text/css' media='$this->media'>";
		return $output;
	}
}

class PIJavaScript extends PageIncludes {
	public function __construct($url, $type='text/javascript') {
		parent::__construct($url,$type);
	}
	
	public function output() {
		$output = "<script src='$this->url' type='text/javascript'></script>";
		return $output;
	}
}

?>