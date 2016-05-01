<?php
// the try/catch for these actions is in the caller, index.php

function add_size($size_name)  
{
    global $db;
    $query = 'INSERT INTO pizza_size
                 (s_status, size_name)
              VALUES
                 (:s_status, :size_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':s_status', 1); // newly created topping is active
    $statement->bindValue(':size_name', $size_name);
    $statement->execute();
    $statement->closeCursor();
}
function get_available_sizes() {
    global $db;
    $query = 'SELECT * FROM pizza_size where s_status=1';
    $statement = $db->prepare($query);
    $statement->execute();
    $sizes = $statement->fetchAll();
    return $sizes;    
}

?>