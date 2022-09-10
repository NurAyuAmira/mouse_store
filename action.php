<?php

    include 'database.php';

    $email=$_POST['email'];

    $message=$_POST['message'];

    $sql="INSERT INTO contact_us(Email,Message) VALUES ('$email','$message')";

    $result=mysqli_query($conn, $sql);

    if($result)
    {
        header('Location: ./index.php');
    }

?>