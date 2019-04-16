<?php
// 'user' object
class Stock{

    // database connection and table name
    private $conn;
    private $table_name = "stock";

    // object properties
    public $stock_id;
    public $stock_name;
    public $price;
    public $category;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // method to create stock
    function create_stock(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    stock_name = :stock_name,
                    price = :price,
                    category = :category";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->stock_name=htmlspecialchars(strip_tags($this->stock_name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->category=htmlspecialchars(strip_tags($this->category));

        // bind the values
        $stmt->bindParam(':stock_name', $this->stock_name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    function stockExists(){

        // query to check if email exists
        $query = "SELECT stock_id, price, category
                FROM " . $this->table_name . "
                WHERE stock_name = ?
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->stock_name=htmlspecialchars(strip_tags($this->stock_name));

        // bind given email value
        $stmt->bindParam(1, $this->stock_name);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->stock_id = $row['stock_id'];
            $this->stock_name = $row['stock_name'];
            $this->price = $row['price'];
            $this->category = $row['category'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }
  }
?>
