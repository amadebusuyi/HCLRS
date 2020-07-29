<?php 
session_start();

if(isset($_SESSION['user'])){
    if($_SESSION['role'] === "0")
        header("Location: facility/index.php");

    elseif($_SESSION['role'] === "1")
        header("Location: lga/index.php");

    elseif($_SESSION['role'] === "2")
        header("Location: state/index.php");

    elseif($_SESSION['role'] === "3")
        header("Location: admin/index.php");

    else{
        session_destroy();
        header("Location: login.php");
    }
}

else
    header("Location: login.php");

 ?>
 <div><h1>Hello Planet Earth</h1></div>