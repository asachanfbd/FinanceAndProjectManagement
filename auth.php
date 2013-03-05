<?php
  require_once("lib/library.php");
  
  $login = $user->iflogin();
    
  if(isset($_POST['loginsubmitform']) && !$login){
      $remember = false;
      if(isset($_POST['remember'])){
          $remember = true;
      }
      $login = $user->dologin($_POST['username'], $_POST['password'], $remember);
  }
  if($login){
      header("Location: index.php");
      //echo 'logged in.';
  }else{
      header('Location: index.php?error=Error in Login Credentials');
      //echo 'not logged in.';
  }
?>