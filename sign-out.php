<?php 

session_start();

require_once "inc/conn.php";

$conn = $pdo->open();


try{
	$query = $conn->prepare("UPDATE users set status = 0 where id = :id");
	$query->execute(['id'=>$_SESSION['user']]);
}

catch(PDOexception $e){

}


$pdo->close();

session_destroy();
header("Location: index.php");

 ?>