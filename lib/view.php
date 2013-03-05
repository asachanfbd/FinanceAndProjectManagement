<?php
  /**
  * this file provides html only.
  * 
  * it gets the data in predefined format and gives output in html.
  */
  
  class view{
      /**
      * this function creates a page structure
      * position for navigation, body, footer, help tips, CSS style, JS/JQ scripts and error are predefined in structure.
      * 
      */
      private static $ajax = FALSE;
      
      
      private static $page = '';
      
      /**
      * CodeLib Back-end Row creator in the box.
      * this function creates a row which on click can expand. It is assumed that required JQ is present in main file.
      * 
      * @param mixed $page : page in which this row would be used. this helps in loading content.
      * @param mixed $id   : id of the page to be loaded on click.
      * @param mixed $heading : Heading of the row.
      * @param mixed $content : A small description to be shown with each row
      * @param mixed $action : Action text to be written in row.
      * @param mixed $status : status of the row.. read/unread.
      */
      function getcmsrow($page, $id, $heading, $content, $action = 'Edit', $status = 'read'){
          return '
                    <li class="'.$status.'" id="'.$id.'">
                        <a href="listner.php?page='.$page.'&pagename='.$id.'" class="ajaxify">
                            <div class="tabrow">
                                <div style="overflow:auto">
                                    <div class="tabrowheader headingplain">'.$heading.'</div>
                                    
                                    <div class="tabrowactionbox">
                                        <div class="successmsg"><span>Changes Saved</span></div>
                                        <div class="tabrowactionbutton">
                                            '.$action.'
                                        </div>
                                        <div class="loadingico">&nbsp;</div>
                                    </div>
                                </div>
                                <div class="tabrowcontent">'.$content.'</div>
                            </div>
                        </a>
                        <div class="ajaxresult">
                            <div class="tabrow">
                                <div style="overflow:auto">
                                    <div class="tabrowheader headingplain">'.$heading.'</div>
                                </div>
                                <div class="tabrowcontentajaxresult">Loading data...</div>
                            </div>
                        </div>
                    </li>';
      }
      
      function cmsrow_innerrow($page, $id, $heading, $content, $rollno){
          return '<li id="'.$id.'" style="background: #fff; border:1px solid #eee; list-style-type:none; margin:5px; overflow:auto; color: #666; float:left; width: 200px;">
                        <a href="listner.php?page='.$page.'&pagename='.$id.'" class="left studentinfo" style="display:block; width: 100%;overflow:auto;">
                            <div class="pad5 left" style="background: #eee;">'.$rollno.'.</div>
                            <div class="pad5 left">'.$heading.'</div>
                            <div style="overflow: auto; border-top:1px solid #eee; clear:both; background: url(\'images/father_ico1.jpg\') no-repeat 102px 6px;">
                                <div class="pad5 left">'.$content.'</div>
                            </div>
                        </a>
                    </li>
                ';
      }
      
      /**
      * CodeLib Back-end box creator.
      * this would create a box with heading, body and Footer
      * 
      * @param mixed $title : heading of the box to be created (Plain Text)
      * @param mixed $body : content of the box to be created  (HTML)
      * @param mixed $footer : Footer of the box (Plain Text)
      * @param mixed $add : Array : text and link to be created at top right of title.
      */
      function getcmsbox($title, $body, $footer="", $add = "", $breadcrumbs = ""){
          $addnew = '';
          $class = '';
          
          if(is_array($add)){
              foreach($add as $k=>$v){
                  $addnew .= '<a class="cmsbox_addbut" href="'.$v.'" style="float:right; font-size:17px; margin-left:8px;">'.$k.'</a>';
              }
          }
          else{
              $class = $add;
          }
          if($breadcrumbs != ""){
              $breadcrumbs = '<div class="breadcrumbs">'.$breadcrumbs.'</div>';
          }
          $frame = '
           
                <div class="innerbox'.$class1.$class.'">
                <div class="heading">
                        '.$title.'
                        '.$breadcrumbs.'
                        '.$addnew.'
                    </div>
                <div>
                    
                    <ul class="tabdata">
                        ';
          if(is_array($body)){
              foreach($body as $v){
                  $frame .= $v;
              }
          }else{
              $frame .= $body;
          }
          $frame .= '
                    </ul>';
          if($footer != ""){
              $frame .= '<div style="padding: 1px 6px; border-top:1px solid #ddd; font-size: 12px; display:none;">
                        '.$footer.'
                    </div>';
          }
          $frame .=  '
                        <div class="innerboxloading"></div>
                    </div>
                    
                </div>';
          return $frame;
      }
      
      function getformfields($label, $type, $name, $help = "abc", $value = "", $placeholder = "", $onclick=""){
          $c1 = '<label for="'.$name.'">'.$label.'</label>';
          $c2 = ':';
          if($type == 'text' || $type == 'password'){
              if($name=='mobile'){
              $c3 = '<input type="'.$type.'" class="clview_input showhelp" name="'.$name.'" id="'.$name.'" value="'.$value.'" maxlength="10" placeholder="'.$placeholder.'" >';   
              }else{
              $c3 = '<input type="'.$type.'" class="clview_input showhelp" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" >';
              }
          }
          elseif($type == 'date'){
              $c3 = '<input type="text" class="clview_input showhelp datepicker" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" >';
          }
          elseif($type == 'select'){
              $c3 = '<select name="'.$name.'"  class="clview_input">';
              foreach($value as $k => $v){
                  $c3 .= '<option ';
                  if($k==1){
                      $c3 .= 'selected="selected"';
                  }
                  $c3 .= ' value="'.$k.'">'.$v.'</option>';
              }
              $c3 .= '</select>';
          }
          elseif($type == 'submit'){
              $c1 = '';
              $c2 = '';
              $c3 = '<input type="submit" class="button" value="'.$value.'" name="'.$name.'" id="'.$name.'">';
              $help = 'Click to Submit';
          }elseif($type == 'textarea'){
              $c3 = '<textarea class="clview_input showhelp" name="'.$name.'" id="'.$name.'">'.$value.'</textarea>';
          }
          elseif($type == 'button' && $name=='cancel'){
              $c3 ='<input type="button" class="button" name="'.$name.'" value="'.$value.'" onclick="'.$onclick.'">';
          }
          else{
              $c3 = 'Input Type not defined.';
          }
          
          if($label == ''){
              $c2 = '';
          }
          
          return $this->getformrows($c1, $c2, $c3, $help);
      }
      
      function getformrows($c1 = '&nbsp;', $c2 = '&nbsp;', $c3 = '&nbsp;', $chelp = '&nbsp;'){
          $re = '
            <div class="clview_row">
                <div  class="clview_row_in">
                    <div class="clview_row_lbl">'.$c1.'</div>
                    <div class="left pad5">'.$c2.'</div>
                    <div class="left pad5" style="width:70%;">'.$c3.'</div>
                </div>
                <div class="clview_help">'.$chelp.'</div>
            </div>';
            return $re;
      }
      
      function getform($page, $type, $data){
          $re = '
          <form action="controller.php" method="post" class="ajaxsubmitform">
                <input type="hidden" value="'.$page.'" name="page" id="page">
                <input type="hidden" value="'.$type.'" name="type" id="type">
                <input type="hidden" value="" name="ajaxrequest" id="ajaxrequest">
                '.$data.'
          </form>';
          return $re;
      }
      
      function getnav($pages, $type, $pageid){
          $r = '<ul class="'.$type.'">';
          foreach($pages as $k => $v){
              $r .= '<li><a href="?page='.$k.'&type='.$type.'" ';
              if($k == $pageid){
                  $r .= 'class="selected" ';
              }
              $r .= '>'.$v.'</a></li>';
          }
          $r .= '</ul>';
          return $r;
      }
      
      function getsubnav($pages, $type, $pageid, $subpage){
          global $user;
          $r = '<ul class="'.$type.'"  id="leftsubnav">';
          $p = '';
          foreach($pages as $k => $v){
              $r .= '<li><a href="?page='.$pageid.'&type='.$type.'&subpage='.$k.'" ';
              if($k == $subpage){
                  $r .= 'class="selected" ';
              }
              $r .= '>'.$v.'</a></li>';
          }
          $r .= '</ul>';
          return $r;
      }
      
      function htmlframe($data, $page = ''){
          global $user;
          if(!$user->iflogin()){
              if($page == 'homepage'){
                  $theme = 'home_frame.php';
              }else{
                  $theme = 'frame_internal.php';
              }
          }else{
              $theme = 'loginpage.php';
          }
          ob_start();
          require_once('view/'.$theme);
          $d = ob_get_contents();
          ob_end_clean();
          foreach($data as $k => $v){
              while(substr_count($d, '[#:@`'.$k.'`]') > 0){
                  $d = str_replace('[#:@`'.$k.'`]', $v, $d);
              }
          }
          return $d;
      }
      
      function getbody($name){
          global $contentpages;
          //TODO: On login error needs to be handled.
            $a = $contentpages->getcontent($name);
            
          return $a;
      }
      
      function getimage($name){
          global $contentpages;
            $a = $contentpages->getimage($name);
          return $a;
          
      }
      
      function bodyinnerframe($nav, $body, $page, $subpage, $st_id = ''){
          return '<a name="loggedin"></a>
            <div style="overflow:auto; border-top:1px solid #666; margin:10px 0;">
                <div style="overflow:auto; min-height: 200px; border-left: 1px solid #aaa;">'.$body.'</div>
            </div>
          ';
      }
      
      function afterlogininfoheader($stid = ''){
          global $user, $parents_obj, $student, $db;
          $d = '';
          if($user->getusertype() == 'parent'){
              
              $st_id = $parents_obj->getstudentid($user->getid());
              if(is_array($st_id)){
                  $d .= '<ul class="student_nav">';
                  foreach($st_id as $v){
                      $d .= '<li><a href="?studentid='.$v.'" ';
                      if($v == $stid){
                          $d .= 'class="selected" ';
                      }
                      $d .= '>'.$student->getname($v).'';
                      if($v == $stid){
                          //$d .= 'born on <strong>'.date('M d, Y', $student->getdob($stid)).'</strong>';   
                      }
                      $d .= '</a></li>';
                  }
                  $d .= '</ul>';
              }
              
          }
          return $d;
      }
      
      function getloginbar(){
          global $user, $notify;
          if($user->iflogin()){
              $acc_type = 'Admin Account';
              $name = '<span style="font-size:15px; font-weight:bold;">'.$user->getfullname().'</span>';
              $settings = '<a href="?page=homepage&type=subnav&subpage=profiles">Settings</a>';
              $logout = '<a href=?logout>Logout</a>';
              $d = '
              <section id="logininfobar">
                        <div style="font-size:18px; font-weight:lighter; float:left;padding:3px;">'.$acc_type.'&nbsp;|&nbsp;'.$name.'</div>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>'.$settings.'</li>
                            <li>'.$logout.'</li>
                        </ul>
                    </section>
                    ';
              return $d;
          }
      }
      
      function usernamechangebox(){
          global $user;
          $d = $this->getformfields('New Username', 'text', 'username', 'Put your email id here.');
          $d .= '
          <div class="clview_row">
              <div  class="clview_row_in">
                  <div class="clview_row_lbl">&nbsp;</div>
                  <div class="left pad5">&nbsp;</div>
                  <input type="hidden" value="'.$user->getid().'" name="userid" id="userid">
                  <div class="left pad5"><input type="submit" name="submit" id="submit" value="Save"></div>
              </div>
          </div>';
          $d = $this->getform('profiles', 'changeusername', $d);
          return $this->getcmsbox('Change Username', $d, 'You can set your email id as username. So that you can remember it easily.');
      }
      
      function highlightsuccess($msg=''){
        return '<div class="ui-widget">
        <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Success!</strong> '.$msg.'</p>
        </div>
        </div>';
      }
      
      function highlighterror($msg=''){
        return '<div class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <strong>Alert:</strong> '.$msg.'</p>
        </div>
        </div>';
      }
      
      function createbluebox($title, $info = '', $notif = ''){
          $d = '';
          if(is_array($info)){
              foreach($info as $v){
                  $d .= '
                        <div class="bluebox_info nowrap" title="'.strip_tags($v).'">
                            '.$v.'
                        </div>
                        ';
              }
          }elseif($info != ''){
              $d .= '
                        <div class="bluebox_info nowrap" title="'.strip_tags($info).'">
                            '.$info.'
                        </div>
                        ';
          }
          if(is_array($notif)){
              foreach($notif as $v){
                  $d .= '
                        <div class="bluebox_notif" title="'.strip_tags($v).'">
                            '.$v.'
                        </div>
                        ';
              }
          }elseif($notif != ''){
              $d .= '
                        <div class="bluebox_notif" title="'.strip_tags($notif).'">
                            '.$notif.'
                        </div>
                        ';
          }
          $d = '
              <div class="bluebox">
                <div class="bluebox_title nowrap" title="'.strip_tags($title).'">
                    '.$title.'
                </div>
                '.$d.'
              </div>';
        return $d;
      }
  }
?>