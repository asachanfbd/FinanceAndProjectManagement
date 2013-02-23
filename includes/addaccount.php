<?php
  
    /**
    * Creating form for adding accounts to database.
    */
    
        $accounts = '';
        $accounts .= $view->getformfields('Name of account owner', 'text', 'owner', 'Enter the name of account owner.');
        $acc_type = array(
                'BANK' => 'BANK',
                'CASH' => 'CASH'
        );
        $accounts .= $view->getformfields('Type of account', 'select', 'account_type', 'Type of account Cash/Bank', $acc_type);
        $accounts .= $view->getformfields('', 'submit', 'addnewaccount', '', 'Save');
        $accounts = $view->getform($id, 'addaccount', $accounts);
        $body .= $view->getcmsbox('Accounts', $accounts, 'Add a new account where company funds are managed and kept for use.');
        
    /**
    * Accounts Form Completed
    */
    
?>
