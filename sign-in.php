<?php 

session_start();

if(isset($_POST['user'])){
	require "inc/functions.php";
	require_once "inc/conn.php";
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from users where (pass = :pass and email = :email or pass = :pass and phone = :phone) AND deleted = 0");
	$query->execute(['email'=> $user, 'phone'=> $user,'pass'=> $pass]);
	
	while($rows = $query->fetch())

	{

		if($rows === ""){
			$content = 404;
			array_push($feed, $content);
		}

		else{
			
		$content['id'] = $rows['id']; 
		$content["fname"] = $rows['fname'];
		$content["lname"] = $rows['lname'];
		$content["email"] = $rows['email'];
		$content["phone"] = $rows['phone'];
		$content["designation"] = $rows['designation'];
		$content["gender"] = $rows['gender'];
		$content["address"] = $rows['address'];
		$content["role"] = $rows['role'];
		$content["lga"] = $rows['lga'];
		$content["img"] = $rows['img'];
		if($rows['facid'] !== null){
		$check = $conn->prepare("SELECT name, lga from hfs where id=:id");
		$check->execute([ 'id'=>$rows['facid'] ]);
		$find = $check->fetch();
		$content["facname"] = $find['name'];
		$content["faclga"] = $find['lga'];
	}
		$content["facid"] = $rows['facid'];
		
		$getRP = $conn->prepare("SELECT * from reporting_period where status = 1");
		$getRP->execute();
		$rpInfo = $getRP->fetch();
		$rpid = $rpInfo["id"];
		$content["rpid"] = $rpid;
		$content["rpname"] = $rpInfo["period"]." ".$rpInfo["year"];

		
	$_SESSION['user'] = $content['id'];
	$_SESSION['role'] = $content['role'];
	$_SESSION['rpid'] = $rpid;

		array_push($feed, $content); 
}

	}

	try{
		$query = $conn->prepare("UPDATE users set status = 1 where email = :email or phone = :phone and pass = :pass");
		$query->execute(['email'=> $user, 'phone'=> $user, 'pass'=> $pass]);
	}

	catch(PDOexception $e){
		$error['error'] = "Unable to update user".$e;
		array_push($feed, $error);
	}

	if(count($feed) !== 0)
		echo json_encode($feed);

	else
		echo 404;


	
	$pdo->close();	
}

 ?>