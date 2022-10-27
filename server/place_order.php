<?php
ob_start();
session_start(); 
include 'connection.php';


//include('layouts/header.php');

if(!isset($_SESSION['loggedIn'])){

    header('location: ../checkout.php?message=Please login/register to place order');
    exit();
}

if(isset($_POST['place_order'])){

    // 1.get user info and store it 
       $name = $_POST['name'];
       $email = $_POST['email'];
       $phone = $_POST['phone'];
       $city = $_POST['city'];
       $address = $_POST['address'];
       $order_cost = $_SESSION['total'];
       $order_status = 'not paid';
       $user_id = $_SESSION['user_id'];
       $order_date = date('Y:m:d H:m:s');

       $stmt = $pdo->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                      VALUES(?,?,?,?,?,?,?)");
        
        $stmt_status = $stmt->execute([$order_cost,$order_status,$user_id,$phone,$city,$address,$order_date]);
        
        if(!$stmt_status){

            header('location: index.php');
            exit();
        }
        //2.issue new order and store order info in db 
        $order_id = $pdo->lastInsertId();
        

        

    //3.get products from cart(from session) 

       foreach($_SESSION['cart'] as $key=> $value){
           var_dump($_SESSION['cart']);
           $product = $_SESSION['cart'][$key];
           var_dump($product);
           $product_id = $product['product_id'];
           //echo $product_id;
           $product_name = $product['product_name'];
           $product_price = $product['product_price'];
           $product_image = $product['product_image'];
           $product_quantity = $product['product_quantity'];

            //4.store each single item in order_items  db
           $stmt1 = $pdo->prepare('INSERT INTO order_items(order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date)
           
                                 VALUES(?,?,?,?,?,?,?,?)');
            $stmt1->execute([$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date]);

       }
        //5.remove everything from cart ->delay until the payment is done 
        //unset($_SESSION['cart']);


        //6.inform user whether everything is fine  or there is a problem 
       header('location: ../payment.php?order_status=Payment placed successfully');
    

}