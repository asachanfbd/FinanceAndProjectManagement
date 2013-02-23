<?php
    if(isset($_REQUEST['type'])){
        $values = array(
                        'title'     =>  $_REQUEST['pagetitle'],
                        'name'      =>  $_REQUEST['type'],
                        'content'   =>  $_REQUEST['pagecontent'],
                        'editedby'  =>  $user->getid(),
                        'seotags'   =>  $_REQUEST['pageseotags']
        );
        if($contentpages->setcontent($_REQUEST['type'], $_REQUEST['pagetitle'], $_REQUEST['pagecontent'], $_REQUEST['pageseotags'])){
            $result = 'Last updated '.getRelativeTime(time())." by ".$user->getfullname();
        }else{
            $errorvar = 'Error in updating';
        }
        
    }
?>
