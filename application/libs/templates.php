<?php

namespace Fyre\Library;

    class Template {

        protected $file;
        protected $values = array();
        
        public function setfile($file) {
            
            $this->file = APP . "templates/" . $file;
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
            
            if (preg_match_all("/\[@[^\]]*\]/", $output, $matches)) {
                
                foreach ($matches[0] as $match) {
                    
                    $output = str_replace($match, "", $output);
                }
            }
            
            return $output;
        }
        
        static public function merge($templates, $separator = "\n") {

            $output = "";
            
            foreach ($templates as $template) {
            	$content = (get_class($template) !== "Fyre\Library\Template")
            		? "Error, incorrect type - expected Template." 
            		: $template->output();
            	$output .= $content . $separator;
            }
            
            return $output;
        }
    }

?>