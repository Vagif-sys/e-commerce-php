<?php
session_start();

include('connection.php');


if(isset($_GET['transaction_id'])  && isset($_GET['order_id'])){

            $order_id = $_GET['order_id'];
            $order_status = "paid";
            $transaction_id = $_GET['transaction_id'];
            $user_id = $_SESSION['user_id'];
            $payment_date = date('Y-m-d H:i:s');

           

            //change order_status to paid
            $stmt = $pdo->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
            $stmt->execute([$order_status,$order_id]);

            

            //store payment info
            $stmt1 = $pdo->prepare("INSERT INTO payments (order_id,user_id,transaction_id,payment_date)
                                    VALUES (?,?,?,?); ");

            $stmt1->execute([$order_id,$user_id,$transaction_id,$payment_date]);

            

            //go to user account
            header("location: ../account.php?payment_message=paid successfully, thanks for your shopping with us");

} else{

    header("location: index.php");
    exit;
}




?>