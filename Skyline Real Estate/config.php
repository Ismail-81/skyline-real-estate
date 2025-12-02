<?php
    $sn = 'localhost';
    $un = 'root';
    $pw = '';
    $db = 'realestate_db';

    $conn = mysqli_connect($sn, $un, $pw, $db);

    if(!$conn){
        die("Connection Failed: " . mysqli_connect_errno());
    }
    // echo "<script>alert('Database Connected Successfully');</script>";
          
?>