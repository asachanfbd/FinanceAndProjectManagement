<?php
    $body .= '<style>
.quicknav{
    list-style-type: none;
    margin:0px;
    padding:0px;
    overflow:auto;
}
.quicknav li{
    width: 48%;
    float:left;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    margin: 1%;
}
.quicknav li a{
    display: block;
    background: #ccc;
    color: #fff;
    width: auto;
    padding: 10px;
}

</style>

<div class="box-bg">
    <ul class="quicknav">
';
    $q = "SELECT * FROM ci_finance_accounts";
    $re = $db->querydb($q);
    if($re->num_rows > 0){
        $q = "SELECT SUM(balance) as balance FROM ci_finance_accounts";
        $re = $db->querydb($q, true);
        
        /**
        * Expense History
        */
        $q = "SELECT * FROM ci_finance_expenses ORDER BY modified DESC LIMIT 0, 5";
        $exp_re = $db->querydb($q);
        $expense_history = '';
        if($exp_re->num_rows > 0){
            while($exp_ro = $exp_re->fetch_object()){
                $expense_history = "<div style='height:10%; background: #f4f4f4; overflow:auto; text-align:left; font-weight:normal;'>
                    <div style='width: 8%; height: 8%;float:left;padding:1%;'>
                        <img src='images/".$exp_ro->expense_of.".png' width='100%' style='border: 1px solid #ccc;'>
                    </div>
                    <div style='width: 60%;float:left;'>
                        <div style='font-size: 120%; padding: 2px 5px;'>".$exp_ro->expense_title." <span style='padding-left:2%;color: #aaa; font-size: 80%'>- ".date('D, d M, Y', $exp_ro->modified)."</span></div>
                        <div style='font-size: 80%; padding: 2px 5px;'>".$exp_ro->details."</div>
                    </div>
                    <div style='width: 29%; padding-right:1%;float:left; font-size: 200%; text-align:right;'>
                        <img src='images/rupee.png'>".$exp_ro->amount."
                    </div>
                    </div>".$expense_history;
            }
            $expense_history = '<div style="font-size: 200%; background: #ddd; padding: 0 2%; text-align:left;font-weight:normal;">Expense Summary</div>'.$expense_history;
        }
        /**
        * Expense history: End
        */
        
        /**
        * Debt Summary
        */
            $debt_summary = '';
            $q = "SELECT * FROM ci_finance_debt ORDER BY modified DESC LIMIT 0, 5";
            $debt_re = $db->querydb($q);
            $debt_summary = '';
            if($debt_re->num_rows > 0){
                while($debt_ro = $debt_re->fetch_object()){
                    $debt_summary = "<div style='height:10%; background: #f4f4f4; overflow:auto; text-align:left; font-weight:normal;'>
                        <div style='width: 70%;float:left;'>
                            <div style='font-size: 120%; padding: 2px 5px;'>".$debt_ro->debt_given_to." <span style='padding-left:2%;color: #aaa; font-size: 80%'>- ".date('D, d M, Y', $debt_ro->modified)."</span></div>
                            <div style='font-size: 80%; padding: 2px 5px;'>".$debt_ro->debt_issue_date."-".$debt_ro->return_date.": ".$debt_ro->reason."</div>
                        </div>
                        <div style='width: 29%; padding-right:1%;float:left; font-size: 200%; text-align:right;'>
                            <img src='images/rupee.png'>".$debt_ro->amount."
                        </div>
                        </div>".$debt_summary;
                }
                $debt_summary = '<div style="font-size: 200%; background: #ddd; padding: 0 2%; text-align:left;font-weight:normal;">Debt Summary</div>'.$debt_summary;
            }
        /**
        * Debt Summary: End
        */
        
        /**
        * Income Summary
        */
            $income_summary = '';
            $q = "SELECT ci_finance_income.*, ci_finance_accounts.owner, ci_finance_accounts.type FROM ci_finance_income, ci_finance_accounts WHERE ci_finance_income.account_id = ci_finance_accounts.id ORDER BY ci_finance_income.modified DESC LIMIT 0, 5";
            $income_re = $db->querydb($q);
            $income_summary = '';
            if($income_re->num_rows > 0){
                while($income_ro = $income_re->fetch_object()){
                    $income_summary = "<div style='height:10%; background: #f4f4f4; overflow:auto; text-align:left; font-weight:normal;'>
                    <div style='width: 8%; height: 8%;float:left;padding:1%;'>
                        <img src='images/".strtolower($income_ro->owner).".png' width='100%' style='border: 1px solid #ccc;'>
                    </div>
                    <div style='width: 60%;float:left;'>
                            <div style='font-size: 120%; padding: 2px 5px;'>".$income_ro->income_from." <span style='padding-left:2%;color: #aaa; font-size: 80%'> - ".date('D, d M, Y', $income_ro->modified)."</span></div>
                            <div style='font-size: 80%; padding: 2px 5px;'>".$income_ro->description."</div>
                        </div>
                        <div style='width: 29%; padding-right:1%;float:left; font-size: 200%; text-align:right;'>
                            <img src='images/rupee.png'>".$income_ro->amount."
                        </div>
                        </div>".$income_summary;
                }
                $income_summary = '<div style="font-size: 200%; background: #ddd; padding: 0 2%; text-align:left;font-weight:normal;">Income Summary</div>'.$income_summary;
            }
        /**
        * Income Summary: End
        */
        
        /**
        * Income Summary
        */
            $acc_summary = '';
            $q = "SELECT * FROM ci_finance_accounts ORDER BY owner DESC";
            $income_re = $db->querydb($q);
            $acc_summary = '';
            if($income_re->num_rows > 0){
                while($income_ro = $income_re->fetch_object()){
                    $acc_summary = "<div style='height:10%; background: #f4f4f4; overflow:auto; text-align:left; font-weight:normal;'>
                    <div style='width: 8%; height: 8%;float:left;padding:1%;'>
                        <img src='images/".strtolower($income_ro->owner).".png' width='100%' style='border: 1px solid #ccc;'>
                    </div>
                    <div style='width: 60%;float:left;'>
                            <div style='font-size: 120%; padding: 2px 5px;'>".$income_ro->type." </div>
                            <div style='font-size: 100%; padding: 2px 5px;'><span style='padding-left:2%;color: #aaa; font-size: 80%'>Last Transaction ".date('D, d M, Y', $income_ro->modified)."</span></div>
                        </div>
                        <div style='width: 29%; padding-right:1%;float:left; font-size: 200%; text-align:right;'>
                            <img src='images/rupee.png'>".$income_ro->balance."
                        </div>
                        </div>".$acc_summary;
                }
                $acc_summary = '<div style="font-size: 200%; background: #ddd; padding: 0 2%; text-align:left;font-weight:normal;">Accounts</div>'.$acc_summary;
            }
        /**
        * Income Summary: End
        */
        
        $body .= '<li>'.$income_summary.'<a href="?id=addincome">Add Income</a></li>';
        if($re->balance > 0){
            $body .= '<li>'.$expense_history.'<a href="?id=addexpenses">Add Expenses</a></li>';
            $body .= '<li>'.$debt_summary.'<a href="?id=adddebt">Add Debt</a></li>';
        }else{
            $body .= '<li>No funds present in any of the account add some funds first.</li>';
        }
    }else{
        $body .= '<li>Add atleast one account to start.</li>';
    }
    $body .= '<li>'.$acc_summary.'<a href="?id=addaccount">Add Account</a></li>';
    $body .= '    </ul>
</div>';
?>