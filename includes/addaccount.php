<?php
  
    /**
    * Creating form for adding accounts to database.
    */
    
  $data['pagetitle'] = 'Add Accounts';
        $accounts = '';
        $accounts .= $view->getformfields('Name of account owner', 'text', 'owner', 'Enter the name of account owner.');
        $acc_type = array(
                'BANK' => 'BANK',
                'CASH' => 'CASH'
        );
        $accounts .= $view->getformfields('Type of account', 'select', 'account_type', 'Type of account Cash/Bank', $acc_type);
        $accounts .= $view->getformfields('', 'submit', 'addnewaccount', '', 'Save');
        $accounts = $view->getform($subpage, 'addaccount', $accounts);
        $links_arr = array( 
                'Add Income'    => '?subpage=addincome',
                'Add Debt'      => '?subpage=adddebt',
                'Add New Expenses'  => '?subpage=addexpenses',
                'View Summary'   => '?subpage=finance'
        );
        $body .= $view->getcmsbox('Accounts', $accounts, 'Add a new account where company funds are managed and kept for use.', $links_arr);
        
    /**
    * Accounts Form Completed
    */
    
?>
