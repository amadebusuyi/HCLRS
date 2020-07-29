<?php 
session_start();

if(isset($_SESSION['user'])){
	if(($_SESSION['role']) != 0){
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

if($page == "report")
require "pages/repo_page.php";

elseif($page == "notifications") 
require "pages/notifications.php";

elseif($page == "profile") 
require "pages/profile.php";

elseif($page == "tabs") 
require "tabs.html";

else
    require "pages/repo_page.php";

echo "</div></section>";

require "../inc/scriptsrc.php";
require "inc/scripts.php";
}

else
    header("Location: report");
}

}

else{
    header("Location: ../login.php");
}

 ?>