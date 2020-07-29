<?php 
session_start();

if(isset($_SESSION['user'])){
	if(($_SESSION['role']) != 2){
		header("Location: ../index.php");
	}
else{

    if(isset($_GET['page'])){
    $page = $_GET['page'];


require "../inc/header.php";
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

elseif($page == "notifications") 
require "pages/notification.php";

elseif($page == "staffs") 
require "pages/staffs.php";

elseif($page == "reporting") 
require "pages/reporting.php";

elseif($page == "facility-report") 
require "pages/repo_page.php";

else
    require "pages/dashboard.php";

echo "</div></section>";

require "../inc/scriptsrc.php";
require "inc/scripts.php";
}

else
    header("Location: home");

}
}


else{
    header("Location: ../login.php");
}

 ?>