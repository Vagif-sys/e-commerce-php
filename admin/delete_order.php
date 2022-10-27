<?php
 include('../server/connection.php');

if(isset($_GET['order_id'])){

    $order_id = $_GET['order_id'];
    $del_order = $pdo->prepare("DELETE FROM orders WHERE order_id=?");
    $del_order->execute([$order_id]);

    if($del_order){
        header('location: index.php?deleted_successfully=Order has been deleted successfully');
  
    }else{
        header('location: index.php?deleted_failure=Could not delete order');
    }
}