<?php
  /**
  * file name:      library.php
  * date:           14-09-2012
  * company:        Coravity Infotech
  * developer:      Sudhanshu Mishra
  * description:    This is php page where all the important classes of the project are included and corresponding object instantiation process takes place.
  */
  
  date_default_timezone_set('Asia/Calcutta');
  
  /*PHP class inclusions*/  
  require_once('commonfunctions.php');
  require_once('profiler.php');
  require_once('stats.php');
  require_once('db.php');
  require_once('error.php');
  //$host=''; /*host name*/
  $uname=''; /*user name*/
  $pass=''; /*password*/
  $dbname=''; /*database name*/  
  
  /*To check location of server*/
  if((stristr($_SERVER['HTTP_HOST'], 'localhost') || stristr($_SERVER['HTTP_HOST'], '192.168'))){
      /*in case the database is located on the localhost*/
      $dbname='coravity';
      $db=new db($dbname);
  }
  else{
      $db=new db($dbname, $host, $uname, $pass);/*initialization in case of server is not on localhost*/
  }
  
  $profiler=new profiler(FALSE);
  
  
  require_once('pages.php');
  require_once('view.php');
  
  /*PHP file inclusion contains table name with structures*/
  require_once('mysql.php');
  require_once('user.php');


  
  /*Object Instantiation for classes*/
  $error=new error();
  set_error_handler(array($error, 'report'));
  $contentpages=new pages();
  $stats=new stats();
  $view=new view();
  $user=new user();
?>
