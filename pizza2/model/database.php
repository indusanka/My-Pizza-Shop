<?php
// set up to execute on XAMPP or at topcat.cs.umb.edu
// set up a mysql user named pizza_user on your own system
if (gethostname() === 'topcat') {
    $username = 'xxxxx';  // mysql username on topcat is UNIX username
    $password = $username;
    $location = '/cs637/' . $username;  // where on server: student dir
   
    $dsn = 'mysql:host=localhost;dbname='. $username . 'db';

} else {  // dev machine, can create pizzadb
    $dsn = 'mysql:host=localhost;dbname=pizzadb';
    $username = 'pizza_user';
    $location = '';
    $password = 'pa55word';  // or your choice
}


try {
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('errors/database_error.php');
    exit();
}
?>