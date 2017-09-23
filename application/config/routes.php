<?php

$routes = [
    // "path/:alpha" => array('controller','function','method')),
    ""  => array("main", "index", "get"),
    "/hello/:alpha"  => array("main", "hello", "get"),
    ];
    
/*  ':string' => '([a-zA-Z]+)',
    ':number' => '([0-9]+)',
    ':alpha'  => '([a-zA-Z0-9-_.,%\[\]=?]+)'*/
    