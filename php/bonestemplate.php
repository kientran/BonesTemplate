<?php
/*
@class BonesTemplate
@abstract Object Oriented Based Web Template System
@author Kien Tran

@description Bones Template is an Object Oriented style template system that supports
    a class heiarchy to reder it's content.

It supports an unlimited number of "Tags" that are defined by the user himself.

Tags are defined by [@tag] and set using the set($key, $value) function.

Tags can also be actual template objects for a recursive/cascade effect.

Tags can be defined at the site level where the value is independent of
the template used. (Useful for things like navigation menus)

Tags can be defined at the template level, where the value is independent
of the site parameters itself. (Useful for custom sidebar modules)

More documentaion and examples can be found in the documentation on github.

http://wiki.github.com/kientran/BonesTemplate

Inspiration for this class was found based on the examples here.

http://www.broculos.net/tutorials/how_to_make_a_simple_html_template_engine_in_php/20080315/en
*/

class BonesTemplate {
	protected $file;                // Location of template file
	protected $values = array();    // Tag values in an array of keys
	protected $conf = array();      // Local copy of configuration values

    /*
        @function __construct
        @params file - Allows the user to explcitly define a template file to use
    */
	public function __construct($file='tpl/template.tpl') {
        $this->conf = Config::getConf();
        $this->file = $this->conf['template']['base'].$file;

        // Import tempalte specific class file called template.php for custom
        // functionality that only applies for that active template.
        // Examples could be custom sidebar constructs 
        $templateSpecificClasses = $this->conf['template']['base'].'template.php';
        if(file_exists($templateSpecificClasses)) {
            include_once($templateSpecificClasses);  //Prevent recursive including of death
        }
    }

    /*
        @function set
        @param key String - Tag name
        @param value String - Value for tag
        @abstract sets [value] to [key] for use in tag replacement
    */	
	public function set($key, $value) {
        $this->values[$key] = $value;
	}

     /*
        @function append 
        @param key String - Tag name
        @param value String - Value for tag
        @abstract appends [value] to defined [key] for use in tag replacement
    */	
    public function append($key, $value) {
        if(!isset($this->values[$key])){
            $this->set($key, $value);
        }
        else {
            $this->values[$key] = $this->values[$key].$value;
        }
    }
     
    /*
        @function prepend 
        @param key String - Tag name
        @param value String - Value for tag
        @abstract prepends [value] to defined [key] for use in tag replacement
    */	
    public function prepend($key, $value) {
        if(!isset($this->values[$key])){
            $this->set($key, $value);
        }
        else {
            $this->values[$key] = $value.$this->values[$key];
        }
    }

	/*
        @function output 
        @abstract scans though template file and replaces [@key] with [value]
        @returns HTML string output with key values replaced with data
    */	
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

	/*
        @function merge 
        @abstract Merges array of template objects into single string
        @param templates Template[] - Stack of template objects
        @param separator String - Seperator for concatenated outputs
        @returns String of values of template output concatenated as one
    */	
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
	protected $url;     // URL location of Included File
	protected $type;    // Included file type

    /*
        @function __constructor
        @param url String - URL of the included source file
        @param type String - Include type
    */	
	public function __construct($url,$type) {
		$this->url = $url;
		$this->type = $type;
	}
}

class PIStyleSheet extends PageIncludes {
	protected $media; // CSS media type (all, screen, print)

    /*
        @function __constructor
        @param url String - URL of the included source file
        @param media String - CSS Media Type
        @param type String - Include type
        
    */	
		public function __construct($url, $media='all', $type='text/css') {
		parent::__construct($url,$type);
		$this->media = $media;
	}
	
    /*
        @function output
        @abstract Overrides Template output to print script tags 
        @returns HTML String of script tag with source values
    */	
		public function output() {
		$output = "<link rel='stylesheet' href='$this->url' type='text/css' media='$this->media'>";
		return $output;
	}
}

class PIJavaScript extends PageIncludes {
    /*
        @function __constructor
        @param url String - URL of the included source file
        @param type String - Include type
    */	
		public function __construct($url, $type='text/javascript') {
		parent::__construct($url,$type);
	}

    /*
        @function output
        @abstract Overrides Template output to print script tags 
        @returns HTML String of script tag with source values
    */	
	public function output() {
		$output = "<script src='$this->url' type='text/javascript'></script>";
		return $output;
	}
}

?>
