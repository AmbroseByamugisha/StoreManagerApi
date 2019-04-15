<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/store_manager/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
include_once '../config/db_env.php';
// link to the User model
include_once '../objects/user.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate product object
$user = new User($db);

// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));

?>
