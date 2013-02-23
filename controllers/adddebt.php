<?php
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'adddebt'){
        $id = uniqid();
        $q = "SELECT * FROM ci_finance_accounts WHERE id = '".$_POST['account_id']."'";
        $re = $db->querydb($q, true);
        if($re){
            $newbalance = ($re->balance - $_POST['amount']);
            if($newbalance >= 0){
                $values = array(
                    'id'                => $id,
                    'debt_given_to'     => $_POST['debt_given_to'],
                    'amount'            => $_POST['amount'],
                    'reason'            => $_POST['reason'],
                    'debt_issue_date'   => $_POST['debt_issue_date'],
                    'return_date'       => $_POST['return_date'],
                    'account_id'        => $_POST['account_id'],
                    'author'            => $user->getid()
                );
                $q = "UPDATE ci_finance_accounts SET balance = balance - ".$_POST['amount'].", author = '".$user->getid()."', modified = ".time()." WHERE id = '".$_POST['account_id']."'";
                $re = $db->insert('ci_finance_debt', $values);
                if($re){
                    $re = $db->querydb($q);
                }
                $success = 'showresult';
                $result = "Debt added to database successfully!";
            }else{
                $errorvar = "Insufficient balance in selected account";
            }
        }
    }
?>
