<?
include('layouts/header.php');
session_start();

include('server/connection.php');

 if(isset($_SESSION['loggedIn'])){

    header('location: account.php');
    
}  

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password != $confirmPassword){

        header('location: register.php?error=Passwords dont match');
    }elseif(strlen($password)<6){

        header('location: register.php?error=Password must be at least 6 character');

    // if there is no error 
    }else{

        // check there is a user with this email or not 
        $checkmail = $pdo->prepare('SELECT * FROM users WHERE user_email= ?');
        $checkmail->execute([$email]);
        $row = $checkmail->rowCount();
        if($row !=0){

            header('location: register.php?error=user with this email already exists');
        // if no user  registered with this email before
        }else{


            // create a new user 
            $reg = $pdo->prepare("INSERT INTO users(user_name,user_email,user_password)
                                 VALUES(?,?,?)");
            
            $reg->execute([$name,$email,md5($password)]);
            
            if($reg){
                
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['loggedIn']  = true;
                header('location: account.php?register=You registered successfully');
                
                
            }else{

                header('location: register.php?error=Could not create an account at the moment');
            }
        }
    }
}


?>

      <!--Resgister-->
      <section class="my-5 py-5">
          <div class="container text-center mt-3 pt-5">
              <h2 class="form-weight-bold">Register</h2>
              <hr class="mx-auto">
          </div>
          <div class="mx-auto container">
              <form id="register-form" method="POST"  action="register.php">
                <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
                </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you have an account? Login</a>
                </div>
              </form>
          </div>
      </section>






      <?php include('layouts/footer.php'); ?>