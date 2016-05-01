<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/order_db.php');
require('../../model/initial_db.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_orders';
    }
}

if ($action == 'list_orders') {
    try{
    $baked_orders = get_baked_orders();
    $preparing_orders = get_preparing_orders();
    include('order_list.php');
    }catch (PDOException $e){
        $error_message = $e->getMessage();
        include ('errors/database_error.php');
        exit();
    }
} else if ($action == 'change_to_baked') {
    try{
    $next_id= get_oldest_preparing_id();
    change_to_baked($next_id);
    header("Location: .");
    } catch (PDOException $e){
        $error_message = $e->getMessage();
        include ('errors/database_error.php');
        exit();
    }
} else if ($action == 'initial_db') {
    $message = 'DB successfully initialized';
    try {
        initial_db();
        header("Location: .");
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include ('errors/database_error.php');
        exit();
    }
}
?>