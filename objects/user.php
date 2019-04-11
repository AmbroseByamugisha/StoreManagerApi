<?php
    // 'user' object
    class User{
    
        // database connection and table name
        private $conn;
        private $table_name = "users";
    
        // object properties
        public $user_id;
        public $user_name;
        public $email;
        public $password;
        public $role;
    
        // constructor
        public function __construct($db){
            $this->conn = $db;
        }
    
    // create() method will be here

    // create new user record
    function create(){
    
        // insert query
        $query = "INSERT INTO " . $this->table_name . "
        SET user_name = :user_name, email = :email,
        password = :password;
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
    
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }    
// emailExists() method will be here
}