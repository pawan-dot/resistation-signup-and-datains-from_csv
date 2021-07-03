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
    <title>Login</title>
</head>

<body>
    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
                <div class="div-container">

                    <form class="form-container" method="POST" action="welcome.php">
                        <div>
                            <p class="bg-success text-white px-3">
                                <?php 
                                 if(isset($_SESSION['msg'])){
                                     echo $_SESSION['msg'];
                                 }else{
                                     echo $_SESSION['msg']="You are logged out please login Again!!";
                                 }
                                ?>
                            </p>

                        </div>

                        <h1>Login</h1>
                        <p>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter email" require>
                        </div>
                        </p>

                        <p>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                            minlength="6"  placeholder="Password" require>
                        </div>
                        </p>
                        <p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit">Login Now</button>
                        </div>
                        </p>
                        <p>
                   <div class="flex items-center justify-between">
                       You Don't have account?
                   <a class="inline-block align-baseline font-bold text-sm " href="signup.php">
                   Signup
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
    $email=($_POST['email']);
    $password=($_POST['password']);

    $email_search="SELECT * FROM `admine`WHERE `email`='$email' and $status='active' ";

    $query= mysqli_query($con,$email_search);

    $emailcount=mysqli_num_rows( $query);
    if($emailcount){
        //fetch password from db
        $email_pass=mysqli_fetch_assoc($query);
        $db_pass=$email_pass['password'];
        $_SESSION['username']=$email_pass['username'];

        $pass_decode=password_varify($password,$db_pass);
        if($pass_decode){
            echo "Login successfull!!";
            ?>
            <script>
                location.replace('home.php');
            </script>
            <?php
        }else{
            echo "Password incorrect..";
        }
        }else{
            echo "invalide email.";
        }

    }
?>