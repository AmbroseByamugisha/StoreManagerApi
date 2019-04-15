<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// files needed to connect to database
include_once '../config/db_env.php';
include_once '../objects/user.php';

//call the validator module
include_once '../config/validators.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate product object
$user = new User($db);

// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->user_name = $data->user_name;
$user->email = $data->email;
$user->password = $data->password;
$user->role = $data->role;
$email_exists = $user->emailExists();
$email_in_right_format = is_email_in_right_format($data->email);

// use the create() method here
// create the user
// create the user
if($email_exists)
{
  // display message: user already exists
  echo json_encode(array("message" => "Manager already exists."));
}
if(!$email_in_right_format)
{
  // display message: email not in right format
  echo json_encode(array("message" => "Enter a valid email address."));
}
elseif(!$email_exists && $email_in_right_format)
{
    $user->create_manager();
    // set response code
    http_response_code(200);
    // display message: user was created
    echo json_encode(array("message" => "Manager created successfully."));
}

// message if unable to create user
else{

    // set response code
    http_response_code(400);

    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create manager."));
}
?>
