<?php
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'addproject'){
        // request to be processed for expenses.
        $id = uniqid();
        if(ddmmyytounixtime($_POST['expected_start_date'])<1 || ddmmyytounixtime($_POST['expected_start_date']) == ''){
            $errorvar = 'Check the format of project start date. It should be DD-MM-YY';
        }
        if(ddmmyytounixtime($_POST['expected_end_date'])<1 || ddmmyytounixtime($_POST['expected_end_date']) == ''){
            $errorvar = 'Check the format of project end date. It should be DD-MM-YY'.ddmmyytounixtime($_POST['expected_end_date']);
        }
        $values = array(
            'id'                    => $id,
            'name'                  => $_POST['project_name'],
            'desc'                  => $_POST['project_desc'],
            'scope_project'         => $_POST['project_scope'],
            'expected_start_date'   => ddmmyytounixtime($_POST['expected_start_date']),
            'expected_end_date'     => ddmmyytounixtime($_POST['expected_end_date']),
            'addedby'                => $user->getid()
        );
        if($errorvar == ''){
            $re = $db->insert('projects', $values);
            if($re){
                $success = 'showresult';
                $result = "Project Created!";
            }else{
                $errorvar = "Error in creating project";
            }
        }
    }
?>
