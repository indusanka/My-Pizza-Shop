-- Clean out orders and arrange for first orderID to be 1
delete from orderItems;
delete from orders;
ALTER TABLE orders AUTO_INCREMENT = 0;
