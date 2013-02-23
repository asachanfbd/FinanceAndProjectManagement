<?php
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'addexpense'){
        // request to be processed for expenses.
        $id = uniqid();
        $q = "SELECT * FROM ci_finance_accounts WHERE id = '".$_POST['account_id']."'";
        $re = $db->querydb($q, true);
        if($re){
            $newbalance = ($re->balance - $_POST['amount']);
            if($newbalance >= 0){
                $values = array(
                    'id'            => $id,
                    'expense_title' => $_POST['expense_title'],
                    'amount'        => $_POST['amount'],
                    'details'       => $_POST['details'],
                    'expense_of'    => $_POST['expense_of'],
                    'account_id'    => $_POST['account_id'],
                    'author'        => $user->getid()
                );
                $q = "UPDATE ci_finance_accounts SET balance = balance - ".$_POST['amount'].", author = '".$user->getid()."', modified = ".time()." WHERE id = '".$_POST['account_id']."'";
                $re = $db->insert('ci_finance_expenses', $values);
                if($re){
                    $re = $db->querydb($q);
                }
                $success = 'showresult';
                $result = "Expense added to database successfully!";
            }else{
                $errorvar = "Insufficient balance in selected account";
            }
        }
    }
?>
