<?php 
    include('db_config/connect.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date = date('Y-m-d H:i:s');

    $query="insert into users (name,email,pass,date) values ('$username','$email','$password','$date')";
    mysqli_query($con,$query);

    header('location:login.php')


?>