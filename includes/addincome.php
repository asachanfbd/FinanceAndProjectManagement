<?php
  
    /**
    * Creating form for adding income to database.
    */
    $data['pagetitle'] = 'Add Income';
        $income = '';
        $income .= $view->getformfields('Income Source', 'text', 'income_from', 'Enter description of income in one or two words.', '', 'Describe in one or two words');
        $income .= $view->getformfields('Amount', 'text', 'amount', 'Enter the amount spent in INR.', 0);
        $income .= $view->getformfields('Details', 'textarea', 'description', 'Describe the income with as much details as possible.');
        $q = "SELECT id, owner, type, SUM(`balance`) as balance FROM ci_finance_accounts GROUP BY owner, type ORDER BY balance DESC";
        $re = $db->querydb($q);
        if($re->num_rows){
            while($ro = $re->fetch_object()){
                $acc[$ro->id] = $ro->owner." > ".$ro->type." (INR ".$ro->balance.")";
            }
            $income .= $view->getformfields('Account to debit', 'select', 'account_id', 'Select the account to be debited.', $acc);
        }
        
        
        
        $income .= $view->getformfields('', 'submit', 'addnewincome', '', 'Save');
        $income = $view->getform($id, 'addincome', $income);
        
    $links_arr = array( 
        'Add Debt'          => '?subpage=adddebt',
        'Add an Account'    => '?subpage=addaccount',
        'Add New Expenses'  => '?subpage=addexpenses',
        'View Summary'   => '?subpage=finance'
    );
        $body .= $view->getcmsbox('Income', $income, 'Add income to the company with as much details as available.', $links_arr);
    /**
    * Income Form Completed
    */
    
?>
