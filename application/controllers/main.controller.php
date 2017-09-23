<?php 

/** 
* Controller main 
*
*
**/

namespace Fyre\Controller;

class main extends \Fyre\Core\Controller {

   function index() {

        $layout = clone $this->template_engine;
        $layout->setFile("layout.tpl");
        $layout->set("name" , "Fyre");
        
        
        echo $layout->output();
    }
    
    function hello($name) {
        
        echo "hello " . $name;
    }
}