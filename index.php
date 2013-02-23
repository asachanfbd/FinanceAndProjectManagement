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
      //navigation of different accounts
          $nav['dashboard'] = 'Dashboard';
          $nav['addaccount'] = 'Add Account';
          $nav['adddebt'] = 'Add Debt';
          $nav['addexpenses'] = 'Add Expenses';
          $nav['addincome'] = 'Add Income';
          $nav['companyname'] = 'Company Name';
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
      $data['footer'] = 'Copyright &copy; 2012 Bitumode. Powered By <a style="text-decoration: none; color: inherit;" href="http://www.coravity.com/" target="_blank">Coravity Infotech</a>';
      echo $view->htmlframe($data, $page);
  }
  else{
      require_once('login.php');
  }
  
  $profiler->add('Loaded Html completely.');
  echo $profiler->display();
  
?>