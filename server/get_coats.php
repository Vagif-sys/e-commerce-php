<?php

include('connection.php');
 

$get_coats = $pdo->prepare("SELECT * FROM products WHERE product_category='coats' LIMIT 4");

$get_coats->execute();


//$coats_products = $stmt->get_result();//[] 





?>