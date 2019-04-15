<?php
// email regex
function is_email_in_right_format($user_input){
   // regex for email
   if (!filter_var($user_input, FILTER_VALIDATE_EMAIL))
    {
        return false;
    }
   else
   {
       // Return Success - Valid Email
       //$msg = 'Your account has been made, <br /> please verify it by clicking
       //the activation link that has been send to your email.';
       return true;
   }
}

?>
