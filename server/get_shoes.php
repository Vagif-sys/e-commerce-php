<?php

include('connection.php');


$shoes = $pdo->prepare("SELECT * FROM products WHERE product_category='shoes' LIMIT 4");

$shoes->execute();


//$shoes = $stmt->get_result();//[]





?>