<?php
  /**
    * Creating form for adding expenses to database.
    */
    $data['pagetitle'] = 'Add Expenses';
    $q = "SELECT SUM(balance) as balance FROM ci_finance_accounts";
    $re = $db->querydb($q, true);
    if($re->balance > 0){
        $expense = '';
        $expense .= $view->getformfields('Expense title', 'text', 'expense_title', 'Enter description of expense in one or two words.', '', 'Describe in one or two words');
        $expense .= $view->getformfields('Amount', 'text', 'amount', 'Enter the amount spent in INR.', 0);
        $expense .= $view->getformfields('Details of Expense', 'textarea', 'details', 'Describe the expense with as much details as possible.');
        $q = "SELECT id, owner, type, SUM(`balance`) as balance FROM ci_finance_accounts GROUP BY owner, type ORDER BY balance DESC";
        $re = $db->querydb($q);
        if($re->num_rows){
            while($ro = $re->fetch_object()){
                $acc[$ro->id] = $ro->owner." > ".$ro->type." (INR ".$ro->balance.")";
            }
            $expense .= $view->getformfields('Account to credit', 'select', 'account_id', 'Select the account to be credited.', $acc);
        }
        $expense_of = array(
                'coravity'  => 'Coravity Infotech',
                'abhishek'  => 'Abhishek',
                'deepak'    => 'Deepak',
                'lalit'     => 'Lalit'
        );
        $expense .= $view->getformfields('Expense of ', 'select', 'expense_of', 'Select the person who owns the expense.', $expense_of);
        $expense .= $view->getformfields('', 'submit', 'addnewexpense', '', 'Save');
        $expense = $view->getform($id, 'addexpense', $expense);
    }else{
        $expense = "You can't make expense. There is no balance in any of our accounts.";
    }
    $links_arr = array( 
        'Add Income'        => '?subpage=addincome',
        'Add Debt'          => '?subpage=adddebt',
        'Add an Account'    => '?subpage=addaccount',
        'View Summary'   => '?subpage=finance'
    );
    $body .= $view->getcmsbox('Expenses', $expense, 'Add company expenses here with as much details as available.', $links_arr);
    /**
    * Expenses Form Completed
    */
?>
