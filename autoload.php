<?php
    function load($classname){
        $name = str_replace('Express\\', '', $classname);
        require '..\\express'.$name.'.php'; 
    }
    spl_autoload_register('load');