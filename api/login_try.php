<?php


  //include_once '../config/headers.php';
  // required headers
  header("Access-Control-Allow-Origin: http://localhost/store_manager/");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  // database connection will be here
  // files needed to connect to database
  include_once '../config/db_env.php';
  include_once '../objects/user.php';

  // get database connection
  $database = new Database();
  $db = $database->getConnection();

  // instantiate user object
  $user = new User($db);

  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  // set product property values
  $user->user_id = $data->user_id;
  $user->email = $data->email;
  $user->password = $data->password;

  //set the variable
  $user_exists = $user->userExists();

  if ($user_exists)
  {
    http_response_code(200);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "status" => "logged in"
            )
        );
  }
  else{
    echo json_encode("Fuck");
  }
?>
