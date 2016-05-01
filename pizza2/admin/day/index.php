<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/order_db.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_orders';
    }
}

if ($action == 'list_orders') {
    try{
    $current_day= get_current_day();
    $todays_orders =  get_todays_orders($current_day);
    } catch (PDOException $e) {
    $error_message = $e->getMessage(); 
    include('errors/database_error.php');
    exit();
    }
    
    include('order_list.php');
} else if ($action == 'change_to_nextday') {
    try{
    $current_day=  get_current_day();
    $next_day= $current_day+1;
    change_to_finished($current_day);
    update_next_day($next_day);
    header("Location: .");
    } catch (PDOException $e) {
    $error_message = $e->getMessage(); 
    include('errors/database_error.php');
    exit();
    }
    
} 
?>