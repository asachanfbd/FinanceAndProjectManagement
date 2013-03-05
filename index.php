<?php

  require_once("lib/library.php");
  
  $profiler->start(false); //passing true will start the profiler logging.
  $data = array();
  $page = '';
  $profiler->add('Checking login.');
  if($user->iflogin()){
      $subnav = '';
      if(isset($_GET['subpage']) && $_GET['subpage'] != ""){
          $subpage = $_GET['subpage'];
      }else{
          $subpage = 'dashboard';
      }
      $id = $subpage;
      //navigation of different accounts
          $nav['dashboard'] = 'Dashboard';
          $nav['projects'] = 'Projects';
          $nav['finance'] = 'Finance';
          $nav['profiles'] = 'Account Settings';
      $data['pagetitle'] = $nav[$subpage];
      if($user->iflogin()){
          $data['loginbar'] = $view->getloginbar();
      }
      $data['mainnavigation'] = $view->getsubnav($nav, 'subnav', 'homepage', $subpage);
      $profiler->add('Now including and executing includes.php');
      require_once('includes.php');
      $data['mainbody'] = $body;
      $profiler->add('Completed executing includes.php');
      $data['footer'] = 'Copyright &copy; 2012 <a style="text-decoration: none; color: inherit;" href="http://www.coravity.com/" target="_blank">Coravity Infotech</a>';
      echo $view->htmlframe($data, $page);
  }
  else{
      require_once('login.php');
  }
  
  $profiler->add('Loaded Html completely.');
  echo $profiler->display();
  
?>