<?php
/*
http://www.broculos.net/tutorials/how_to_make_a_simple_html_template_engine_in_php/20080315/en
*/

class BonesTemplate {
	protected $file;
	protected $values = array();
	protected $conf = array();

	public function __construct($file='tpl/template.tpl') {
        $this->conf = Config::getConf();
		$this->file = $this->conf['template']['base'].$file;
		$this->set("templatebaseurl",$this->conf['template']['baseurl']);

        // Import tempalte specific class file called template.php for custom
        // functionality that only applies for that active template.
        // Examples could be custom sidebar constructs 
        $templateSpecificClasses = $this->conf['template']['base'].'template.php';
        if(file_exists($templateSpecificClasses)) {
            include_once($templateSpecificClasses);  //Prevent recursive including of death
        }
	}
	
	public function set($key, $value) {
        $this->values[$key] = $value;
	}
    
    public function append($key, $value) {
        if(!isset($this->values[$key])){
            $this->set($key, $value);
        }
        else {
            $this->values[$key] = $this->values[$key].$value;
        }
    }

    public function prepend($key, $value) {
        if(!isset($this->values[$key])){
            $this->set($key, $value);
        }
        else {
            $this->values[$key] = $value.$this->values[$key];
        }
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
	            ? "Error, incorrect type (".get_class($template).") - expected BonesTemplate.<br />"
	            : $template->output();
	        $output .= $content . $separator;
	    }
	 
	    return $output;
	}

}

// Predefined Helper Class for page includes.  This is a "site" level class techincaly.
class PageIncludes extends BonesTemplate {
	protected $url;
	protected $type;
	
	public function __construct($url,$type) {
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
