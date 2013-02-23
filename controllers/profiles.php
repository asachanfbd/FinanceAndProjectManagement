<?php
    if($_REQUEST['type'] == 'fullname'){
        if($user->setname($_POST['fname'], $_POST['lname'])){
            $result = 'Updated '.getRelativeTime(time());
        }else{
            $errorvar = 'Name not updated';
        }
    }
    elseif($_REQUEST['type'] == 'email'){
        if($user->setemail($_POST['email'])){
            $result = $_POST['email'];
        }else{
            $errorvar = 'E-Mail not updated';
        }
    }
    //TODO: make changes below for checking error and result so that success can be determied later.
    elseif($_REQUEST['type'] == 'password'){
        if(md5($_POST['pass']) == $user->getpassword()){
            if($_POST['npass'] == $_POST['cpass']){
                $user->setpassword($_POST['npass']);
                $success = "Password changed successfully.";
                $result = 'Updated '.getRelativeTime(time());
            }else{
                $errorvar = "Confirmed password must match to new password.";
            }
        }else{
            $errorvar = "Current password didn't match.";
        }
    }
    elseif($_REQUEST['type'] == 'userreset'){
        if($user->resetpassword($_GET['id'])){
            
            $success = "User reset successfully. A mail has been sent to the user with new password.";
        }else{
            $errorvar = "User reset successfully. But mail can't be sent to the user.";
        }
    }
    elseif($_REQUEST['type'] == 'userdel'){
        if($user->deluser($_GET['id'])){
            $usernew = new user();
            $result = 'There are '.count($usernew->getusers()).' registered user'.plural(count($usernew->getusers()));
        }else{
            $errorvar = "User delete failed.";
        }
    }
    elseif($_REQUEST['type'] == 'newuser'){
        if($result = $user->setuser($_REQUEST['fname'], $_REQUEST['lname'], $_REQUEST['email'])){
            $success = "User added successfully. A mail has been sent to the user with login details.";
        }else{
            $errorvar = "Problem creating user";
        }
    }

?>
