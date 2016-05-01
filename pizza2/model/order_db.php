<?php
function get_preparing_orders() {
    global $db;
    $query = 'SELECT * FROM pizza_orders where status=1';
    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;  
}
function get_baked_orders() {
    global $db;
    $query = 'SELECT * FROM pizza_orders where status=2';
    $statement = $db->prepare($query);
    $statement->execute(); 
    $orders = $statement->fetchAll();
    $statement->closeCursor();    
    return $orders;  
}
function get_preparing_orders_of_room($room) {
    global $db;
    $query = 'SELECT * FROM pizza_orders where status=1 and room_number=:room';
    $statement = $db->prepare($query);
    $statement->bindValue(':room',$room);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor(); 
    $orders = add_toppings_to_orders($orders);
    return $orders;    
}

function get_baked_orders_of_room($room) {
    global $db;
    $query = 'SELECT * FROM pizza_orders where status=2 and room_number=:room';
    $statement = $db->prepare($query);
    $statement->bindValue(':room',$room);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor(); 
    $orders1 = add_toppings_to_orders($orders);     
    return $orders1;    
}
// helper to above two functions
function add_toppings_to_orders($orders) {
      for ($i=0; $i<count($orders);$i++) {
        $toppings = get_orders_toppings($orders[$i]['id']);
        $orders[$i]['toppings'] = $toppings; // add toppings to order 
    } 
    return $orders;
}
// helper to above function
function get_orders_toppings($order_id) {
    global $db;
    $query = 'select T.topping_name from toppings T,order_topping OT where OT.topping_id=T.id and OT.order_id=:order_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':order_id',$order_id);
    $statement->execute();
    $toppings = $statement->fetchAll();
    $statement->closeCursor();
    return $toppings;
}
function change_to_baked($id) {
    global $db;
    $query = 'UPDATE pizza_orders SET status=2 WHERE status=1 and id=:id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id',$id);
    $statement->execute();
    $statement->closeCursor();     
}

function get_oldest_preparing_id() {
    global $db;
    $query = 'SELECT min(id) id FROM pizza_orders where status=1';
    $statement = $db->prepare($query);
    $statement->execute();
    $id = $statement->fetch()['id'];
    $statement->closeCursor();
    return $id;     
}

function get_todays_orders($day) {
    global $db;
    $query = 'SELECT * FROM pizza_orders where day=:day';
    $statement = $db->prepare($query);
    $statement->bindValue(':day',$day);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();   
    return $orders;
}

function get_current_day() {
    global $db;
    $query = 'SELECT * FROM pizza_sys_tab';    
    $statement = $db->prepare($query);
    $statement->execute();    
    $currentday = $statement->fetch();
    $statement->closeCursor();    
    $current_day = $currentday['current_day'];
    return $current_day;
}

function update_next_day($next_day){
    global $db;
    $query = 'UPDATE pizza_sys_tab SET current_day=:next_day';    
    $statement = $db->prepare($query);
    $statement->bindValue(':next_day', $next_day);
    $statement->execute();    
    $statement->closeCursor();    
}

function change_to_finished($current_day) {
    global $db;
    $query = 'UPDATE pizza_orders SET status=3 WHERE day=:current_day';
    $statement = $db->prepare($query);
    $statement->bindValue(':current_day',$current_day);
    $statement->execute();
    $statement->closeCursor(); 
}

function update_to_finished($room) {
    global $db;
    $query = 'UPDATE pizza_orders SET status=3 WHERE status = 2 and room_number = :room';
    $statement = $db->prepare($query);
    $statement->bindValue(':room',$room);
    $statement->execute();
    $statement->closeCursor();        
}

function get_order_id() {
    global $db;
    $query = 'SELECT * FROM pizza_sys_tab';    
    $statement = $db->prepare($query);
    $statement->execute();    
    $toppingid = $statement->fetch();
    $statement->closeCursor();    
    $next_order_id = $toppingid['next_order_id'];
    return $next_order_id;
}

function add_order($room,$size_id,$current_day,$status, $toppings) {
    global $db;
    $query = 'INSERT INTO pizza_orders(room_number, size_id, day, status) VALUES (:room,:size_id,:current_day,:status)';
    $statement = $db->prepare($query);
    $statement->bindValue(':room',$room);
    $statement->bindValue(':size_id',$size_id);
    $statement->bindValue(':current_day',$current_day);
    $statement->bindValue(':status',$status);
    $statement->execute();
    $statement->closeCursor(); 
    foreach ($toppings as $t) {
        add_order_topping($t);
    }
}
// helper to add_order: uses last_insert_id() to pick up auto_increment value
function add_order_topping($topping_id) {
    global $db;
    $query = 'INSERT INTO order_topping(order_id, topping_id) VALUES (last_insert_id(),:topping_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':topping_id', $topping_id);
    $statement->execute();
    $statement->closeCursor();
}