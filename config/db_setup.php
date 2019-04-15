<?php // Example 26-1: functions.php
  $dbhost  = 'localhost';    // Unlikely to require changing
  $dbname  = 'storedb';   // Modify these...
  $dbuser  = 'root';   // ...variables according
  $dbpass  = '';   // ...to your installation

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  // function that creates tables
  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }

  createTable('users',
              'user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
              user_name VARCHAR(16),
              email VARCHAR(25),
              password VARCHAR(100),
              role VARCHAR(16) DEFAULT "user"');

  createTable('stock',
              'stock_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              stock_name VARCHAR(16),
              price VARCHAR(16),
              category VARCHAR(16),
              user_id INT REFERENCES users(user_id)');

  createTable('transactions',
              'trans_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              trans_name VARCHAR(16),
              done_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              stock_id INT REFERENCES stock(stock_id),
              user_id INT REFERENCES users(user_id)');


  ?>
