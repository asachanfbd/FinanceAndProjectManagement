<?php
  /**
  * name
  * desc
  * scope of the project
  * proposal
  * budget
  * invoices
  * start date
  * end date
  * expected end date
  * expected start date
  * 
  */
  
    $accounts = '';
    $re = $db->querydb("SELECT * FROM projects ORDER BY modified");
    if($re){
        while($ro = $re->fetch_object()){
            $info = array();
            // info 1
            if($ro->lastactivity == '0'){
                $info[] = 'Added '.getRelativeTime($ro->added);
            }else{
                $info[] = 'Last activity '.getRelativeTime($ro->lastactivity);
            }
            // notif 1
            
            $accounts .= $view->createbluebox($ro->name, $info);
        }
    }
    $body .= $view->getcmsbox('List of projects', $accounts, '', array('Add New Project'=>'?subpage=addproject'));
        
?>
