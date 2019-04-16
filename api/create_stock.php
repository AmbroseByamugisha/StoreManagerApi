<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// database connection will be here
// files needed to connect to database
include_once '../config/db_env.php';
include_once '../objects/stock.php';

//call the validator module
include_once '../config/validators.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate product object
$stock = new Stock($db);

// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$stock->stock_name = $data->stock_name;
$stock->price = $data->price;
$stock->category = $data->category;
$stock_exists = $stock->stockExists();

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// decode jwt here
// if jwt is not empty
if($jwt){

    // if decode succeed, show user details
    try {

        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // set user property values here
        // set user property values
        $stock->stock_name = $data->stock_name;
        $stock->price = $data->price;
        $stock->category = $data->category;
        $stock->stock_id = $decoded->data->stock_id;

        // update user will be here
        // create the product
        if($stock_exists)
        {
          // display message: user already exists
          echo json_encode(array("message" => "Stock already exists."));
        }
        elseif(!$stock_exists )
        {
            $stock->create_stock();
            // set response code
            http_response_code(200);
            // display message: user was created
            echo json_encode(array("message" => "Stock is created."));
        }

        // message if unable to update user
        else{
            // set response code
            http_response_code(401);

            // show error message
            echo json_encode(array("message" => "Unable to create stock."));
        }
    }

    // catch failed decoding will be here
    // if decode fails, it means jwt is invalid
    catch (Exception $e){

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }


}

// error message if jwt is empty will be here
// show error message if jwt is empty
else{

    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
?>
