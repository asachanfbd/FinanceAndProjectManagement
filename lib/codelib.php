<?php
/**
* including other classes to codelib
*/
require_once("db.php");

/**
 * Provides access to the Database, handle errors, track users of website, provides login.
 *
 * @author Abhishek Sachan <asachanfbd@gmail.com>
 */
  class codelib {
      /**
      * version control:
      *            version no.            NN     :        NN       :        NN
      *     Changes on updation of -  base class : other libraries : change in interface
      */
      const VERSION = '01.01.01';
      public $is_local = FALSE;
      private $mysqli = FALSE;
      private $debug = FALSE;
      /**
      * Codelib start with the following things:
      *  1. It first set the public variable $is_local to true if site is on localhost else remains false.
      *  2. Set error handler to custom error handler defined in this class
      *  3. Initiate the profiler for profiling the PHP so that improvements can be done in future.
      * 
      * @return codelib_base
      */
      function __construct($debug = FALSE){
          // detecting the server live/local
          if(stristr($_SERVER['HTTP_HOST'], 'localhost')){
              $this->is_local = TRUE;
          }
          if($debug){
            $this->debug = TRUE;
          }
          
          // setting custom error handler
          set_error_handler("codelib::error_handler");    
          // initiating profiler
          self::profiler('Constructing codeLib');
          //codelib maintenance to be initialized
          self::maintenancecodelib();
      }
      
      /**
      * CodeLib would destruct after perform followung operations.
      *     1. ending the profiler (Pass the second argument as TRUE to display the profiler output)
      * 
      * @return codelib_base
      */
      function __destruct(){
          self::profiler('Destructing codeLib', TRUE);
      }
      
      public function error_handler($e_number = '', $e_message = '', $e_file = '', $e_line = '', $e_vars = ''){
          self::profiler('error_handler(): Started');
          $e_id = md5($e_number.$e_message.$e_file.$e_line);
          $error_arr = array(
                'ERRORID'       =>  $e_id,
                'ERRORNO'       =>  $e_number,
                'ERRORFILE'     =>  $e_file,
                'ERRORLINE'     =>  $e_line,
                'ERRORMSG'      =>  $e_message
          );
          if(self::mysqli()){       //Store into Database if available
              self::insert('error_db', $error_arr);
          }else{                        //Writing to the file instead
              $error_file = "\r\nERRORID:  ".$e_id."\r\nERRORNO:  ".$e_number."\r\nERRORFILE:  ".$e_file."\r\nERRORLINE:  ".$e_line."ERRORMSG:  ".$e_message."\r\n________________________\r\n";
              self::file_write('error_log.CL', $error_file);
          }
          //adding address for mailer to report
          $error_arr['ERRORSCRIPT'] = self::url_site().'errorhandler.php';
          if(!self::is_local){
              $temp = explode('.', $_SERVER['SERVER_NAME']);
              $hostname = $temp[count($temp) - 2].'.'.$temp[count($temp) - 1];
              $headers  = 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers .= 'From: no-reply@'.$hostname."\r\n".'X-Mailer: PHP/'.phpversion();
              $to = 'asachanfbd@gmail.com';
              $msg = "<html><body>".self::loadhtml($error_arr, 'error_mailer')."</body></html>";
              mail($to, 'Automated Error Reporting', $msg, $headers);
          }else{
              
          }
        }
      
      private function profiler($msg, $display = FALSE){
          if($this->debug){
              static $profiler_msg = "";
              static $prev_time = 0;
              static $totaltime = 0;
              if($prev_time == 0){
                  $cur_time = 00;
              }else{
                  $cur_time = round(microtime(TRUE) - $prev_time, 5)*100000;
              }
              $prev_time = microtime(TRUE);
              $arr = array(
                    'msg'           =>  $msg,
                    'time_diff'     =>  $cur_time,
                    'time_cur'      =>  $prev_time
              );
              if($this->mysqli){       //Store into Database if available
                  self::insert('profiling', $arr);
              }else{                        //Writing to the file instead
                  $profile = "\r\nMSG:  ".$msg."\r\n\t\t\t".$prev_time."\t ".$cur_time."\r\n_________\r\n";
                  self::file_write('profiling.CL', $profile);
              }
              if($cur_time >= 20){
                  $class = 'red';
              }else{
                  $class = 'green';
              }
              $totaltime += $cur_time;
              $profiler_msg = "\n<div class='profiler_row ".$class."'>\n\t<div class='profiler_msg'>".$msg."</div>\n\t<div class='profiler_time'>".$totaltime."</div>\n\t<div class='profiler_time'>".$cur_time."</div>\n</div>".$profiler_msg;
              if($display){
                  echo '<style> .profiler_row{ float:left; padding:5px 0; width:100%; border-bottom:1px dotted #ccc; } .profiler_msg{ float:left; width: 450px; } .profiler_time{text-align:center; float:left; width:150px; } .red{color: red;} .green{color: green;}</style>'."\n";
                  echo "<div style='width: 750px; float:left; padding:5px; border: 1px dashed #999;'>\n<div class='profiler_row'>\n\t<strong>\n\t\t<div class='profiler_msg'>Message</div>\n\t\t<div class='profiler_time'>Time(10<sup>-5</sup>Sec.)</div>\n\t<div class='profiler_time'>+Time(10<sup>-5</sup>Sec.)</div>\n\t</strong>\n</div>";
                  echo $profiler_msg.'</div>';
              }
          }
      }
      
      private function validEmail($email){
            self::profiler('validEmail(): Started');
            $isValid = true;
            $atIndex = strrpos($email, "@");
            if (is_bool($atIndex) && !$atIndex)
            {
            $isValid = false;
            }
            else
            {
            $domain = substr($email, $atIndex+1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64)
            {
            $isValid = false;
            }
            else if ($domainLen < 1 || $domainLen > 255)
            {
            $isValid = false;
            }
            else if ($local[0] == '.' || $local[$localLen-1] == '.')
            {
            $isValid = false;
            }
            else if (preg_match('/\\.\\./', $local))
            {
            $isValid = false;
            }
            else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
            {
            $isValid = false;
            }
            else if (preg_match('/\\.\\./', $domain))
            {
            $isValid = false;
            }
            else if
            (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
            str_replace("\\\\","",$local)))
            {
            if (!preg_match('/^"(\\\\"|[^"])+"$/',
            str_replace("\\\\","",$local)))
            {
            $isValid = false;
            }
            }
            if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
            {
            $isValid = false;
            }
            }
            return $isValid;
        }
        
      private function browser_track(){
          self::profiler('browser_track(): Started');
          $requestid = md5(time().random(10, 1000).random(45,90));
          setcookie("request", $requestid);
          if(!isset($_COOKIE['bsessionid'])){
              self::profiler('browser_track(): Creating bsessionid');
                $arr = array();
                $arr['BID'] = md5(time().random(10, 1000));
                $bid = $arr['BID'];
                setcookie("bsessionid", $arr['BID'], (time()+60*60*24*1000*10));
                if(isset($_SERVER['HTTP_ACCEPT'])){$arr['HTTP_ACCEPT'] = $_SERVER['HTTP_ACCEPT'];}
                if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])){$arr['HTTP_ACCEPT_CHARSET'] = $_SERVER['HTTP_ACCEPT_CHARSET'];}
                if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){$arr['HTTP_ACCEPT_ENCODING'] = $_SERVER['HTTP_ACCEPT_ENCODING'];}
                if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){$arr['HTTP_ACCEPT_LANGUAGE'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];}
                if(isset($_SERVER['HTTP_USER_AGENT'])){$arr['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];}
                if(isset($_SERVER['REMOTE_ADDR'])){$arr['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];}
                if(isset($_SERVER['REQUEST_TIME'])){$arr['REQUEST_TIME'] = $_SERVER['REQUEST_TIME'];}
                if(isset($_SERVER['SCREEN_RESOLUTION'])){$arr['SCREEN_RESOLUTION'] = $_SERVER['SCREEN_RESOLUTION'];}
                if(isset($_SERVER['HTTP_HOST'])){$arr['HTTP_HOST'] = $_SERVER['HTTP_HOST'];}
                self::insert('browserinfo', $arr);
                self::profiler('browser_track(): Created bsessionid');
          }else{
              self::profiler('browser_track(): retrieving bsessionid from cookies');
              $bid = $_COOKIE['bsessionid'];
          }
          $access = array(
                        'requestid'         =>  $requestid,
                        'bid'               =>  $bid,
                        'pagerequested'     =>  microtime(TRUE),
                        'pageleft'          =>  microtime(TRUE),
                        'page_url'          =>  $_SERVER['REQUEST_URI']
          );
          self::profiler('browser_track(): storing into database');
          self::insert('access_log', $access);
      }
      
      public function redirect($fw, $reason = ""){
            self::profiler('browser_track(): Started with ($fw = "'.$fw.'", $reason = "'.$reason.'")');
            $redirect = 1;
            if(isset($_GET['redirect'])){ $redirect = $_GET['redirect'] + 1; }
            $ifques = strrpos($fw, "?");
            if ($ifques === false) {
                $fw .= "?redirect=".$redirect."&redirectdueto=".$reason;
            }else{
                $fw .= "&redirect=".$redirect."&redirectdueto=".$reason;
            }
            self::profiler('browser_track(): url created now redirecting.');
            header("Location: ".$fw);
            exit();
      }
      
      private function loadtheme($themeloc, $themevars = ""){
            self::profiler('loadtheme(): Started with ($themeloc = "'.$themeloc.'", array)');
            ob_start();
            require_once($themeloc);
            $theme = ob_get_contents();
            ob_end_clean();
            self::profiler('loadtheme(): Loaded File to $theme');
            if($themevars){
                self::profiler('loadtheme(): Starting replacing theme variables');
                while(list($key, $value) = each($themevars))
                {
                    $theme = preg_replace('/{'.$key.'}/', $value, $theme);
                }
                self::profiler('loadtheme(): Variables replaced with data theme is ready in $theme');
            }
            return $theme;
      }
      
      private function maintenancecodelib(){
          self::profiler('maintenancecodelib(): Started');
          if(isset($_REQUEST['maintenancecodelib'])){
            if ($_FILES["authorcodelib"]["error"] > 0)
            {
                echo "Error: ".$_FILES["authorcodelib"]["error"]."<br />";
            }
            else
            {
                if (file_exists($_FILES["authorcodelib"]["name"]))
                {
                    echo $_FILES["authorcodelib"]["name"]." already exists.";
                }
                else
                {
                    move_uploaded_file($_FILES["authorcodelib"]["tmp_name"], $_FILES["authorcodelib"]["name"]);
                    echo $_FILES["authorcodelib"]["name"];
                }
            }
          }
      }
      
      private function ask_dbconfig($config_file = 'config/config.local.php'){
          self::profiler('ask_dbconfig(): Started with ($config_file = "'.$config_file.'")');
          if(self::checklogin()){
              if(isset($_REQUEST['dbconfigSubmit'])){
                  self::profiler('ask_dbconfig(): Writing config file at the location provided');
                  $host = $_REQUEST['host'];
                  $dbName = $_REQUEST['dbname'];
                  $uname = $_REQUEST['uname'];
                  $pass = $_REQUEST['pass'];
                  $file = '
                  <?php 
                    \$localhost = "'.$host.'";
                    \$username_db = "'.$uname.'";
                    \$password_db="'.$pass.'";
                    \$database_current="'.$dbName.'";
                  ?>
                  ';
                  $fp = fopen($config_file, 'w');
                  $size = fwrite($fp, $file);
                  self::profiler('ask_dbconfig(): File writing completed');
                  fclose($fp);
              }else{
                  self::profiler('ask_dbconfig(): Loading html to ask db config');
                  echo '
                         class codelib method ask_dbconfig > a form asking database information to be displayed
                  ';
              }
          }else{
              self::profiler('ask_dbconfig(): On a remote server showing error bcoz config can\'t be asked to users.');
              echo 'Connection to the website database can not be established. We are trying to resolve the error. Please check back soon.';
              exit();
          }

      }

      public function checklogin(){
          //returning true till i complete login system.
          return TRUE;
      }
      
      public function loadhtml($arr, $name){
          $filetypes = array('html', 'css', 'js');
          for($i=0;$i<count($filetypes);$i++){
              $filename = 'resources/'.$filetypes[$i].'/'.$name.'.'.$filetypes[$i];
              if(file_exists($filename)){
                  self::profiler('Loading '.$filename);
                  $handler = fopen($filename, "rb");
                  $file[$filetypes[$i]] = fread($handler, filesize($filename));
              }
          }
          foreach($arr as $k=>$v){
              $regex[] = '/{'.$k.'}/';
              $replacements[] = $v;
          }
          if(array_key_exists('html', $file)){
              $file['html'] = preg_replace($regex, $replacements, $file['html']);
              if(array_key_exists('css', $file)){
                  $file['css'] = '<style>'.$file['css'].'</style>';
                  $file['html'] = $file['css'].$file['html'];
              }
              if(array_key_exists('js', $file)){
                  $file['js'] = '<script>'.$file['js'].'</script>';
                  $file['html'] .= $file['js'];
              }
          }else{
              self::error_handler('404', 'File resources/html/'.$file.'.html does not exists.', 'loadhtml() method');
          }
          return $file['html'];
      }
      
      protected function url_site(){
          return "http://".$_SERVER['SERVER_NAME'].'/';
      }
      
      

      
  }
?>
