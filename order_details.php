<?php include('layouts/header.php'); ?>


<?php


/*
  not paid
  shipped
  delivered
*/

include('server/connection.php');


if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id =:order_id");
   

    $stmt->execute(array(':order_id'=> $order_id));
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
     
   
}else{
    
   header('location: account.php');
   exit;

}




 function calculateTotalOrderPrice($result){

   $total = 0;

  foreach($result as $row){  
 
  $product_price = $row['product_price'];
  var_dump($product_price);
  $product_quantity = $row['product_quantity'];
  
  $total  =  $total  + ($product_price * $product_quantity);
  var_dump("tota".$total);
  } 
   return $total;
}   

$order_total_price=calculateTotalOrderPrice($result);

    
  

?>




       <!--Order details-->
       <section id="orders" class="orders container my-5 py-3">
            <div class="container mt-5">
                <h2 class="font-weight-bold text-center">Order details</h2>
                <hr class="mx-auto">
            </div>

            <table class="mt-5 pt-5 mx-auto">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
 
                </tr>


               <?php foreach($result  as $row){  ?>
                  
                          <tr>
                              <td>
                                <div class="product-info">
                                    <img src="assets/imgs/<?php echo $row['product_image'];?>"/>
                                    <div>
                                        <p class="mt-3"><?php echo $row['product_name'];?></p>
                                    </div>
                                </div> 
                                
                              </td>

                              <td>
                                <span>$<?php echo $row['product_price'];?></span>
                              </td>

                              <td>
                                <span><?php echo $row['product_quantity'];?></span>
                              </td>
                          </tr>
                  <?php } ?>
            </table>
                <?php
                  if($order_status == 'not paid'){?>
                    <form style='float:right;' action='payment.php' method='POST'>
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"/>
                      <input type='' name='order_total_price' value="<?php echo $order_total_price;?>">
                      <input type='hidden' name='order_status' value='<?php echo $order_status;?>'>
                      <input type='submit' name='order_pay_btn' class='btn btn-primary' value='Pay Now'>
                    </form>
                <? }?>
        </section>
  <?php include('layouts/footer.php'); ?>