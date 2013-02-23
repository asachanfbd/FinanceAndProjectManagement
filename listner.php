<?php
    require_once("lib/library.php");
    if($user->iflogin()){
      if(isset($_GET['page']) && is_file('listners/'.$_GET['page'].'.php')){
          require_once 'listners/'.$_GET['page'].'.php';
      }else{
          echo 'No Action Available.';
      }
  }else{
      echo 'You need to login again.';
  }
?>
