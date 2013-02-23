<?php
  class newsupdates{
      
      function getall(){
          global $db;
          $q = "SELECT * FROM newsupdates ORDER BY added DESC LIMIT 0,20";
          $re = $db->querydb($q);
          if($re->num_rows){
              $arr = array();
              while($ro = $re->fetch_object()){
                  $arr[] = $ro;
              }
              return $arr;
          }
      }
      
      function getcontent($id){
          global $db;
          $re = $db->querydb("SELECT * FROM newsupdates WHERE id = '".$id."'", true);
          if($re){
              return $re->body;
          }
      }
      
      function gettitle($id){
          global $db;
          $re = $db->querydb("SELECT * FROM newsupdates WHERE id = '".$id."'", true);
          if($re){
              return $re->title;
          }
      }
      
      function setnews($title, $body){
          global $db, $user;
          $arr = array(
                    'id'      =>  uniqid(),
                    'title'   =>  $title,
                    'body'    =>  $body,
                    'addedby' =>  $user->getid()
          );
          if($db->insert('newsupdates', $arr)){
              return $arr;
          }else{
              return false;
          }
      }
  }
?>
