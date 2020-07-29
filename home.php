<?php 
session_start();

if(isset($_SESSION['user'])){
    if($_SESSION['role'] !== "3")
   header("Location: pages/reporting.php");

    else{
//  header("Location: home");

    if(isset($_GET['page'])){
    $page = $_GET['page'];


require "inc/header.php";
require "inc/navbar.php";
require "inc/sidebar.php";

echo '<section class="content">
        <div class="container-fluid display-point">';

if($page == "home")
require "pages/dashboard.php";

elseif($page == "facilities") 
require "pages/facilities.php";

elseif($page == "profile") 
require "pages/profile.php";

elseif($page == "staffs") 
require "pages/staffs.php";

elseif($page == "form") 
require "pages/form.html";

else
    require "pages/dashboard.php";

echo "</div></section>";

require "inc/scriptsrc.php";
}

else
    header("Location: home");
}
}

else{
    header("Location: login.php");
}

 ?>