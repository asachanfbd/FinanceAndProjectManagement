<?php
  class pages{
      
      private static $page = '';
      
      private static $name = '';
      
      function getcontent($name){
          $p = $this->getpage($name);
          return stripslashes($p->content);
      }
      
      public function gettitle($name){
          $p = $this->getpage($name);
          return stripslashes($p->title);
      }
      
      public function getcreated($name){
          $p = $this->getpage($name);
          return $p->added;
      }
      
      public function getauthor($name){
          $p = $this->getpage($name);
          return $p->editedby;
      }
      
      public function getlastedited($name){
          $p = $this->getpage($name);
          return $p->modified;
      }
      
      public function getseotags($name){
          $p = $this->getpage($name);
          return $p->seotags;
      }
      
      public function getimage($name){
          $p = $this->getpage($name);
          return $p->headerimg;
      }
      
      private function getpage($name){
          global $db;
          if(self::$name != $name){
               self::$name = $name;
               self::$page = $db->querydb("SELECT * FROM pages WHERE name = '".$name."' ORDER BY modified DESC", true);
          }
          return self::$page;
      }
      
      private function insert($tbl, $val){
          global $db;
          return $db->insert($tbl, $val);
      }
      
      private function update($tbl, $val, $con){
          global $db;
          return $db->update($tbl, $val, $con);
      }
      
      function setcontent($name, $title = '', $content = '', $seotags = ''){
          global $user;
          $values = array(
                        'id'        =>  uniqid(),
                        'title'     =>  $title,
                        'name'      =>  $name,
                        'content'   =>  $content,
                        'editedby'  =>  $user->getid(),
                        'seotags'   =>  $seotags
          );
          $this->insert('pages', $values);
          return true;
      }
  }
?>
