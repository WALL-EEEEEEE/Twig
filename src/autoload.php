<?php
/**
 * Autoload class for twig framework
 */

spl_autoload_register(function($class) {
    //trip framework name Twig
    $class = stripos($class,'Twig') === 0 ? substr($class,5):$class;
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    include_once($class.'.php');
});
 
 
