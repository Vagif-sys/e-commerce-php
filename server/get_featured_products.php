<?php

 include('connection.php');


$stmt=$pdo->prepare("SELECT * FROM products LIMIT 4");

$stmt->execute();


//$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);//[] 





?>