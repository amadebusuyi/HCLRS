<?php 
require "../inc/functions.php";
if(isset($_POST["addStaff"])){
	$gender = $_POST["gender"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$designation = $_POST["designation"];
	$role = $_POST["role"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];
	$lga = $_POST["lga"];
	$pass = randGen(6);

	require_once "../inc/conn.php";

	$conn = $pdo->open();

	try{
	$query = $conn->prepare("INSERT into users (email, pass, fname, lname, gender, designation, role, phone, address, lga) values(:email, :pass, :fname, :lname, :gender, :designation, :role, :phone, :address, :lga)");
	$query->execute(['email'=>$email, 'pass'=>$pass, 'fname'=>$fname, 'lname'=>$lname, 'gender'=>$gender, 'designation'=>$designation, 'role'=>$role, 'phone'=>$phone, 'address'=>$address, 'lga'=>$lga]);

	echo "Registration successful";
	}
	catch(PDOException $e){
		echo "failed to save data ".$e;
	}

	$pdo->close();

}

if(isset($_GET["fetch"])){
	require_once "../inc/conn.php";
	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from users");
	$query->execute();
	while($rows = $query->fetch())
	{
		$content['fname'] = $rows['fname']; 
		$content["lname"] = $rows['lname'];
		$content["id"] = $rows['id'];
		$content["email"] = $rows['email'];
		$content["phone"] = $rows['phone'];
		$content["designation"] = $rows['designation'];
		$content["gender"] = $rows['gender'];
		$content["address"] = $rows['address'];
		$content["role"] = $rows['role'];
		$content["lga"] = $rows['lga'];
		array_push($feed, $content); 
	}

	echo json_encode($feed);
	
		$pdo->close();	
		
}

if(isset($_GET["fetch_hfs"])){
	require_once "../inc/conn.php";
	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from hfs");
	$query->execute();
	while($rows = $query->fetch())
	{
		$content['id'] = $rows['id']; 
		$content["name"] = $rows['name'];
		$content["lga"] = $rows['lga'];
		array_push($feed, $content); 
	}

	echo json_encode($feed);
	
		$pdo->close();	
		
}



if(isset($_GET["hfs"])){
	$name = singleQuote($_GET["hfs"]);
	$lga = singleQuote($_GET["lga"]);

	require_once "../inc/conn.php";

	$conn = $pdo->open();

	try{
	$query = $conn->prepare("INSERT into hfs (name, lga) values(:name, :lga)");
	$query->execute(['name'=>$name, 'lga'=>$lga]);

	echo "$name added to hfs";
	}
	catch(PDOException $e){
		echo "failed to save data ".$e;
	}

	$pdo->close();

}

if (isset($_GET['rand'])) {
	echo randGen(6);
}

if (isset($_GET['checker'])) {
	include "../inc/conn.php";
	echo "Hello world";
	try{
		
	}

	catch(PDOException $e){
		echo $e. "gshshshshshshshs";
	}
}


 ?>