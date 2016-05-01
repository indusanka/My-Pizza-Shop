<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/topping_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_toppings';
    }
}
if ($action == 'list_toppings') {
  try {
    $toppings = get_available_toppings();
    include('topping_list.php');
  } catch (PDOException $e) {
    $error_message = $e->getMessage(); 
    include('errors/database_error.php');
    exit();
  }
} 
else if ($action == 'show_add_form') {
    include('topping_add.php');    
} 
else if ($action == 'add_topping') {
    $topping_name = filter_input(INPUT_POST, 'topping_name');
    if ($topping_name == NULL || $topping_name == FALSE) {
        $error = "Invalid product data. Check all fields and try again.";
        include('errors/error.php');
        exit();
    } 
    else { 
      try {
        add_topping($topping_name);
      } catch (PDOException $e) {
      $error_message = $e->getMessage(); 
      include('errors/database_error.php');
      exit();
    }
        header("Location: .");
    }
}    
?>