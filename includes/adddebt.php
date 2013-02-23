<?php
  /**
    * Creating form for adding expenses to database.
    */
    $q = "SELECT SUM(balance) as balance FROM ci_finance_accounts";
    $re = $db->querydb($q, true);
    if($re->balance > 0){
        $expense = '';
        $expense .= $view->getformfields('Debt to person', 'text', 'debt_given_to', '', '', 'Name of debtor');
        $expense .= $view->getformfields('Amount', 'text', 'amount', 'Enter the amount debt in INR.', 0);
        $expense .= $view->getformfields('Debt Date', 'text', 'debt_issue_date', 'DD-MM-YYYY', '', 'DD-MM-YYYY');
        $expense .= $view->getformfields('Expected Date of Debt Return', 'text', 'return_date', 'DD-MM-YYYY', '', 'DD-MM-YYYY');
        $expense .= $view->getformfields('Debt money for', 'textarea', 'reason', 'Describe the reason with as much details as possible.');
        $q = "SELECT id, owner, type, SUM(`balance`) as balance FROM ci_finance_accounts GROUP BY owner, type ORDER BY balance DESC";
        $re = $db->querydb($q);
        if($re->num_rows){
            while($ro = $re->fetch_object()){
                $acc[$ro->id] = $ro->owner." > ".$ro->type." (INR ".$ro->balance.")";
            }
            $expense .= $view->getformfields('Account to credit', 'select', 'account_id', 'Select the account to be credited.', $acc);
        }
        $expense .= $view->getformfields('', 'submit', 'addnewexpense', '', 'Save');
        $expense = $view->getform($id, 'adddebt', $expense);
    }else{
        $expense = "You can't debt money. There is no balance in any of our accounts.";
    }
    
    echo $view->getcmsbox('Debt', $expense, 'Add debtor details here with as much details as available. Payment for the delivered service can also be added here.');
    /**
    * Expenses Form Completed
    */
?>
