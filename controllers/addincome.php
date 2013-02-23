<?php
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'addincome'){
        // request to be processed for expenses.
        $id = uniqid();
        $values = array(
            'id'            => $id,
            'income_from'   => $_POST['income_from'],
            'amount'        => $_POST['amount'],
            'description'   => $_POST['description'],
            'account_id'    => $_POST['account_id'],
            'author'        => $user->getid()
        );
        $q = "UPDATE ci_finance_accounts SET balance = balance + ".$_POST['amount'].", author = '".$user->getid()."', modified = ".time()." WHERE id = '".$_POST['account_id']."'";
        $re = $db->insert('ci_finance_income', $values);
        if($re){
            $re = $db->querydb($q);
        }
        $success = 'showresult';
        $result = "Income added to database successfully!";
    }
?>
