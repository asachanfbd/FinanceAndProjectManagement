<?php
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'addaccount'){
        // request to be processed for expenses.
        $q = "SELECT * FROM ci_finance_accounts WHERE owner = '".$_POST['owner']."' AND type = '".$_POST['account_type']."'";
        if(!$db->querydb($q, true)){
            $values = array(
                    'id'    => uniqid(),
                    'owner' => $_POST['owner'],
                    'type'  => $_POST['account_type'],
                    'author'=> $user->getid()
            );
            $re = $db->insert('ci_finance_accounts', $values);
            $success = 'showresult';
            $result = "Account added to database successfully!";
        }else{
            $errorvar = 'Account Already Exists';
        }
    }
?>
