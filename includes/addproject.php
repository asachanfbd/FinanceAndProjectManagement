<?php
  /**
  * name
  * desc
  * scope of the project
  * proposal
  * budget
  * invoices
  * start date
  * end date
  * expected end date
  * expected start date
  * 
  */
  $data['pagetitle'] = 'Add Projects';
    $accounts = '';
    $accounts .= $view->getformfields('Name of the Project', 'text', 'project_name', 'Enter the name Project.');
    $accounts .= $view->getformfields('Description', 'textarea', 'project_desc', 'Define the project.');
    $accounts .= $view->getformfields('Scope of the project', 'textarea', 'project_scope', 'Define the scope of the project.');
    $accounts .= $view->getformfields('Expected Start Date', 'date', 'expected_start_date', 'Enter the expected start date of the project [DD-MM-YY]');
    $accounts .= $view->getformfields('Expected End Date', 'date', 'expected_end_date', 'Enter the expected end date of the project [DD-MM-YY]');
    $accounts .= $view->getformfields('', 'submit', 'addnewaccount', '', 'Save');
    $accounts = $view->getform($subpage, 'addproject', $accounts);
    $body .= $view->getcmsbox('Add New Project', $accounts, '');
        
?>
