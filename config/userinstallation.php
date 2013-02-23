<?php
  require_once('../lib/profiler.php');
  require_once('../lib/db.php');
  require_once('../lib/mysql.php');
  
  $profiler=new profiler(TRUE);
  
  $host=''; /*host name*/
  $uname=''; /*user name*/
  $pass=''; /*password*/
  $dbname=''; /*database name*/  
  
  if((stristr($_SERVER['HTTP_HOST'], 'localhost'))){
      /*in case the database is located on the localhost*/
      $dbname='demo_interface';
      $db=new db($dbname);
  }
  else{
      $db=new db($dbname, $host, $uname, $pass);/*initialization in case of server is not on localhost*/
  }
  
  $user_tables=array('users_email', 'users_info', 'users_notifications', 'users_sessions', 'users_logininfo',  'users_priviledge');
  
  for($i=0; $i<=5; $i++){
        if($db->checktable($user_tables[$i])){
                insert($user_tables[$i]);
        }
  }
  
  for($i=0; $i<=5; $i++){
      alter($user_tables[$i]);
  }
  
  
  function insert($tablename){
     global $db;
     if($tablename=='users_email'){
         $db->querydb("INSERT INTO `users_email` (`id`, `email`, `added`, `modified`) VALUES('superadmin', 'admin@coravity.com', ".time().", ".time().")");
     }if($tablename=='users_logininfo'){
         $db->querydb("INSERT INTO `users_logininfo` (`id`, `password`, `added`, `modified`) VALUES('superadmin', '".md5("admin")."', ".time().", ".time().")");
     }elseif($tablename=='users_info'){
         $db->querydb("INSERT INTO `users_info` (`id`, `fname`, `lname`, `sex`, `added`, `modified`) VALUES('superadmin', 'Web', 'Admin', 'M', ".time().", ".time().")");
     }elseif($tablename=='users_priviledge'){
         $db->querydb("INSERT INTO `users_priviledge` (`id`, `priviledge`, `added`, `modified`) VALUES('superadmin', 'superadmin', ".time().", ".time().")");
     }else{
         return false;
     }
  }
  function alter($tablename){
     global $db;
     if($tablename=='users_email'){
         $db->querydb("ALTER TABLE `users_email` ADD CONSTRAINT `users_email_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users_logininfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
     }elseif($tablename=='users_info'){
         $db->querydb("ALTER TABLE `users_info` ADD CONSTRAINT `users_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users_logininfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
     }elseif($tablename=='users_notifications'){
         $db->querydb("ALTER TABLE `users_notifications` ADD CONSTRAINT `users_notifications_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users_logininfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
     }elseif($tablename=='users_sessions'){
         $db->querydb("ALTER TABLE `users_sessions` ADD CONSTRAINT `users_sessions_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users_logininfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
     }else{
         return false;
     }   
  }
  
?>