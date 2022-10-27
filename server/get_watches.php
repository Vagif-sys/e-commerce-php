<?php

include('connection.php');


$watches = $pdo->prepare("SELECT * FROM products WHERE product_category='watches' LIMIT 4");

$watches->execute();


//$watches = $stmt->get_result();//[]





?>