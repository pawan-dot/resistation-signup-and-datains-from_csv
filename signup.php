

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="design.css">
  <title>Sign Up</title>
</head>

<body>
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-4">
        <div class="div-container">

          <form class="form-container" method="POST" action="signup.php">
            <h1>Sign Up</h1>
            <p>
            <div class="form-group">
              <input type="name" name="name" class="form-control" id="exampleInputPassword1" minlength="2" placeholder="Full Name" Required>
            </div>
            </p>

             <p>
            <div class="form-group">
              <input type="email"name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Enter email" Required>
            </div>
            </p>

            <p>
            <div class="form-group">
              <input type="password" name="password" class="form-control" id="exampleInputPassword1" minlength="6"
                placeholder="Password ( 6 or more charector)" required>
            </div>
            </p>
            <p>
            <div class="form-group"> 
              <input type="password" name="cpassword" class="form-control" id="exampleInputPassword1" minlength="6"
                placeholder="Confirm Password" required>
            </div>
            </p>
            
            <p>
            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit" name="submit">CREATE ACCOUNT</button>
            </div>
            </p>

            
             <p>
            <div class="flex items-center justify-between">
            Already have account?
            <a class="inline-block align-baseline font-bold text-sm " href="login.php">
             login
            </a>
          </div>
         </p>


          </form>
        </div>
      </section>
    </section>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>

<?php
include('dbcon.php');
if(isset($_POST['submit'])){
    $Username=mysqli_real_escape_string($con,$_POST['name']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    $cpassword=mysqli_real_escape_string($con,$_POST['cpassword']);
     
    $pass=password_hash($password,PASSWORD_BCRYPT);
    $cpass=password_hash($cpassword,PASSWORD_BCRYPT);

    $token=bin2hex(random_bytes(15));

    $emailqry="SELECT * FROM `my_users`WHERE `email`='$email' ";
    $query= mysqli_query($con,$emailqry);

    $emailcount=mysqli_num_rows( $query);

   if($emailcount>0){
    
?>
   <script>
    alert('email already exits!!!');
     window.open('signup.php', '_self');
    </script>
    <?php
   }
   else{
     if($password==$cpassword){
       $insertquery="INSERT INTO `admine` (`name`, `email`, `password`, `cpassword`, `token`, `status`) VALUES ('$Username', '$email', '$pass', '$cpass','$token','inactive')";
       $iquery= mysqli_query($con,$insertquery);
       if($iquery){
         $subject="Email Activation";
         $body="hi,$Username,Click here to activate your account
         http://localhost/login/activate.php?token=$token";

         $sender_email="from:pk02.verma@gmail.com";

         if(mail($email,$subject,$body,$sender_email)){
           //echo "email sent $to_email..";
            $_SESSION['msg']="check your mail to activateyour accaunt $email";
            header('location:login.php');

         }else{
           "email sending failed...";
         }
    
       }else{
         ?>
         <script>
          alert(' NOT inserted !!!');
     </script>
     <?php
       }
     }else{
       ?>
        <script>
          alert('password is not matching!!!');
     </script>
     <?php
     }
    }
     
}
?>