<?php

// file that connects to the header
include_once '../config/headers.php';
  
// set user property values
$user->user_name = $data->user_name;
$user->email = $data->email;
$user->password = $data->password;
 
// use the create() method here
// create the user
if($user->create()){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>