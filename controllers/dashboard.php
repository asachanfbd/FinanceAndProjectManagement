<?php
    if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'addnew'){
        $values = array(
                'id'    =>  uniqid(),
                'title' =>  $_REQUEST['title'],
                'body'  =>  $_REQUEST['body']
        );
        $db->insert('companyname', $values);
        $success = 'SHOW RESULT';
    }
    
    if(isset($_REQUEST['type'])){
        if(isset($_REQUEST['msg']) && $_REQUEST['msg'] != ""){
            $values = array(
                            'id'     =>  uniqid(),
                            'enqid'  =>  $_REQUEST['type'],
                            'msg'    =>  $_REQUEST['msg'],
            );
            if($db->insert("companynamecomments", $values)){
                
                $updateresult = '
                <div class="boxslip">
                    <div class="left boxtitleslip">
                        <div>'.$user->getfirstname().'</div>
                    </div>
                    <div class="right boxtitleslip">
                        <div>'.getRelativeTime(time()).'</div>
                    </div>
                    <div class="boxslipbody left">
                        <div>'.$values['msg'].'</div>
                    </div>
                </div>
                                ';
            }else{
                $errorvar = 'Message not saved.';
            }
        
        }
    }
    elseif(isset($_REQUEST['delenq'])){
        if($db->delete('companyname', "id = '".$_REQUEST['delenq']."'")){
            $result = 'delrow';
        }else{
            $errorvar = "Can not delete row.";
        }
    }
?>
