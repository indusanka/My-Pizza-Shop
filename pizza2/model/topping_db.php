<?php
// the try/catch for these actions is in the caller, index.php

function add_topping($topping_name)  
{
    global $db;
    $query = 'INSERT INTO toppings
                 (t_status, topping_name)
              VALUES
                 (:t_status, :topping_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':t_status', 1); // newly created topping is active
    $statement->bindValue(':topping_name', $topping_name);
    $statement->execute();
    $statement->closeCursor();
}

function get_available_toppings() {
    global $db;
    $query = 'SELECT * FROM toppings where t_status=1';
    $statement = $db->prepare($query);
    $statement->execute();
    $toppings = $statement->fetchAll();
    return $toppings;    
}

?>