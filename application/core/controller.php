<?php

namespace Fyre\Core;

class Controller {
    
    public $template_engine;

    function __construct() {
        
        require_once( APP . "libs/templates.php");
        $this->template_engine = new \Fyre\Library\Template;
        
    }
}
