<?php  include('layouts/header.php'); ?>


<?php



include('server/connection.php');

 if(isset($_SESSION['loggedIn'])){

    header('location: account.php');
    
} 

if(isset($_POST['login_btn'])){

        
        $email = $_POST['email'];
        //var_dump($email);
        $password = md5($_POST['password']);
        //var_dump($password);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_email =:email AND user_password=:password ");
        //var_dump($stmt);
        $stmt->execute(array(':email'=> $email,':password'=>$password));
       /*  if(!$result){

            echo 'QUERY FAILED';
        } */
        $count = $stmt->rowCount();
       
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($row);
        $user_id = $row['user_id'];
        $name = $row['user_name'];
        
        if($count > 0){

           

                $_SESSION['user_id'] = $user_id;   
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['loggedIn'] = true; 

                header('location: account.php?login_success=You logged in succesfully');
           
            
        }else{
                    
            header('location: login.php?error=could not verify your account');
        } 

  }











?>









      <!--Login-->
      <section class="my-5 py-5">
          <div class="container text-center mt-3 pt-5">
              <h2 class="form-weight-bold">Login</h2>
              <hr class="mx-auto">
          </div>
          <div class="mx-auto container">
              <form id="login-form" method="POST" action="login.php">
                <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" />
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>
                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
                </div>
              </form>
          </div>
      </section>






      <?php include('layouts/footer.php'); ?>