<?php
    $body = '';
    $include_file = 'includes/'.$subpage.'.php';
    if(file_exists($include_file)){
        require_once('includes/'.$subpage.'.php');
    }else{
        $body = 'No Action Available';
    }
    
?>