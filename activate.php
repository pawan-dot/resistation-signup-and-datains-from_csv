<?php
session_start();

 include('dbcon.php');
 if(isset($_GET['token'])){
     $token=$_GET['token'];

     $update_query="update my_users set status='active'where token='$token' ";

     $query=mysqli_query($con,$update_query);
     if($query){
         if(isset($_SESSION['msg'])){
            $_SESSION['msg']="Account updated successfully.."
            header('location:login.php')

         }else{
            $_SESSION['msg']="You are logged out.."
            header('location:login.php')
         }else{
            $_SESSION['msg']="Account not updated !!"
            header('location:signup.php')
         }
     }
    }
 
 ?>