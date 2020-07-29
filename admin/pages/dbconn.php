<?php 
require "../../inc/functions.php";

function note($msg, $conn){
	session_start();

	$uid = $_SESSION["user"];
	$getName = $conn->prepare("SELECT fname, lname from users where id = :uid");
	$getName->execute(["uid"=>$uid]);
	$row = $getName->fetch();

	$uname = $row["lname"]." ". $row["fname"];
	$msg = $uname." ".$msg;
	
	//echo $msg;

		try{
		$query = $conn->prepare("INSERT into notifications (msg) values (:msg)");
		$query->execute(["msg"=>$msg]);
	}

	catch(PDOException $e){
		$error = $e;
//		echo $error;
	}
}

if(isset($_GET["commodities"])){
	require_once "../../inc/conn.php";
	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from commodities where deleted = 0 order by name asc");
	$query->execute();
	while($rows = $query->fetch())
	{
		$content['id'] = $rows['id'];
		$content["name"] = $rows['name'];
		$content["unit"] = $rows['unit'];
		array_push($feed, $content);
	}

	echo json_encode($feed);
	
		$pdo->close();	
		
}

elseif(isset($_POST["upload_report"])){
	session_start();
	$cid = $_POST["cid"];
	$fid = $_POST["fid"];
	$uid = $_SESSION["user"];
	$prevBal = $_POST["prevBal"];
	$received = $_POST["received"];
	$issued = $_POST["issued"];
	$posAdjust = $_POST["posAdjust"];
	$negAdjust = $_POST["negAdjust"];
	$balance = $_POST["balance"];
	$del = $_POST["del"];
	$expiry = $_POST["expiry"];
	$expiry = str_replace("/", "-", $expiry);
	$remark = $_POST["remarks"];
	$rpid = $_SESSION["rpid"];
	require_once "../../inc/conn.php";
	$conn = $pdo->open();
	$query = $conn->prepare("SELECT max(id) as rid, count(id) as numrows from report where cid = :cid and rpid = :rpid and fid = :fid");
	$query->execute(['cid'=>$cid, 'rpid'=>$rpid, 'fid'=>$fid]);
	$row = $query->fetch();
	$rid = $row['rid'];	
	if($row['numrows'] < 1 && $del == 0){
	try{
		$query = $conn->prepare("INSERT into report (cid, fid, rpid, userid, prevBal, received, issued, posAdjust, negAdjust, balance, expiry, remark) values(:cid, :fid, :rpid, :uid, :prevBal, :received, :issued, :posAdjust, :negAdjust, :balance, :expiry, :remark)");
		$query->execute(['cid'=>$cid, 'fid'=>$fid, 'rpid'=>$rpid, 'uid'=>$uid, 'prevBal'=>$prevBal, 'received'=>$received, 'issued'=>$issued, 'posAdjust'=>$posAdjust, 'negAdjust'=>$negAdjust, 'balance'=>$balance, 'expiry'=>$expiry, 'remark'=>$remark]);
		echo "successful";
	}
	catch(PDOException $e){
		echo $e;
	} 
}
	else{
		$query = $conn->prepare("UPDATE report set userid=:uid, prevBal=:prevBal, received=:received, issued=:issued, posAdjust=:posAdjust, negAdjust=:negAdjust, balance=:balance, expiry=:expiry, remark=:remark, deleted = :del where id=:rid");
		$query->execute(['rid'=>$rid, 'uid'=>$uid, 'prevBal'=>$prevBal, 'received'=>$received, 'issued'=>$issued, 'posAdjust'=>$posAdjust, 'negAdjust'=>$negAdjust, 'balance'=>$balance, 'expiry'=>$expiry, 'remark'=>$remark, 'del'=> $del]);
		echo "successful";
	}

$pdo->close();
}

elseif(isset($_GET["not_available"])){
	session_start();
	$fid = $_GET["fid"];
	$cid = $_GET["cid"];

	require_once "../../inc/conn.php";
	$conn = $pdo->open();

	$query = $conn->prepare("UPDATE report set deleted = :val where rpid = :rpid and fid = :fid and cid = :cid");
		$query->execute(['fid'=>$fid, 'cid'=>$cid, 'rpid'=>$_SESSION['rpid'], 'val'=> 1]);
		echo "successful";

		$pdo->close();
}

elseif(isset($_POST["addStaff"])){
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

	require_once "../../inc/conn.php";

	$conn = $pdo->open();

	try{
	$query = $conn->prepare("INSERT into users (email, pass, fname, lname, gender, designation, role, phone, address, lga) values(:email, :pass, :fname, :lname, :gender, :designation, :role, :phone, :address, :lga)");
	$query->execute(['email'=>$email, 'pass'=>$pass, 'fname'=>$fname, 'lname'=>$lname, 'gender'=>$gender, 'designation'=>$designation, 'role'=>$role, 'phone'=>$phone, 'address'=>$address, 'lga'=>$lga]);

	$uid = mysql_insert_id($conn);

	$msg = "$fname $lname was added to LMCU officers";
	echo $msg;
	note("added $fname $lname to database", $conn);
	}
	catch(PDOException $e){
		if ($error !== undefined || $error !== null)
		echo "failed to generate send notification due to error " .$error;
		else echo $e;
	}

	$pdo->close();

}

elseif(isset($_GET["fetch"])){
	require_once "../../inc/conn.php";
	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from users where deleted = 0");
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

elseif(isset($_GET["fetch_hfs"])){
	require_once "../../inc/conn.php";
	$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT * from hfs where deleted = 0");
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

elseif(isset($_GET["hfs"])){
	$name = singleQuote($_GET["hfs"]);
	$lga = singleQuote($_GET["lga"]);

	require_once "../../inc/conn.php";

	$conn = $pdo->open();

	try{
	$query = $conn->prepare("INSERT into hfs (name, lga) values(:name, :lga)");
	$query->execute(['name'=>$name, 'lga'=>$lga]);

	$fid = $conn->lastInsertId();

	echo "$name added to hfs <br> $fid";

	note("added ".$name." to database. <a href='javascript:void(0);' onclick='updateFac()'>Click here</a> for updated health facilities list.", $conn);
	}
	catch(PDOException $e){
		echo "failed to save data ".$e;
	}

	$pdo->close();

}

elseif(isset($_GET['pro_record'])){
	session_start();
	$fid = $_GET["fid"];
	require_once "../../inc/conn.php";

	$feed = array();

	$conn = $pdo->open();

	$query = $conn->prepare("SELECT MAX(rpid) as RPid from report where fid = :fid");
	$query->execute(["fid"=> $fid]);
	$row = $query->fetch();
	$RPid = $row['RPid'];
	$del = 0;

	$query2 = $conn->prepare("SELECT * from report where fid = :fid and rpid = :rpid and deleted = :del");
	$query2->execute(["fid"=> $fid, "rpid"=>$RPid, "del"=>$del]);
	
	while($rows = $query2->fetch()){
		$content["uid"] = $rows["userid"];
		$content["cid"] = $rows["cid"];
		$content["value"] = true;
		if($_SESSION['rpid'] !== null){
			if($_SESSION['rpid'] !== $rows["rpid"] && $_SESSION['rpid'] > $rows["rpid"]){
				$content["prevBal"] = $rows["balance"];
				$content["received"] = "";
				$content["issued"] = "";
				$content["posAdjust"] = "";
				$content["negAdjust"] = "";
				$content["balance"] = "";
				$content["remarks"] = "";
				$content["expiry"] = "";
				$content["prev"] = true;
				$content["status"] = "pending";
			}
			else{
				if($_SESSION['rpid'] === $rows["rpid"]){
				$getPrev = $conn->prepare("SELECT MAX(reporting_period.id) as mid from reporting_period where id < :rpid");
				$getPrev->execute(["rpid" => $RPid]);
				$fetch = $getPrev->fetch();

				$check = $conn->prepare("SELECT count(id) as count from report where rpid = :lrpid and cid = :cid and fid = :fid");
				$check->execute(["lrpid" => $fetch["mid"], "cid" => $rows["cid"], "fid" => $fid]);
				$count = $check->fetch()["count"];
				if($count > 0){
					$content["prev"] = true;
				}
				else{
					$content["prev"] = false;
				}
			}

				$content["prevBal"] = $rows["prevBal"];
				$content["received"] = $rows["received"];
				$content["issued"] = $rows["issued"];
				$content["posAdjust"] = $rows["posAdjust"];
				$content["negAdjust"] = $rows["negAdjust"];
				$content["balance"] = $rows["balance"];
				$content["remarks"] = $rows["remark"];
				if($rows["expiry"] == null){
					$content["expiry"] = "";
				}
				else{	
				$content["expiry"] = $rows["expiry"];
				}
				$content["status"] = "uploaded";			
			}
		}
		
		array_push($feed, $content);
	}
	
echo json_encode($feed);
	$pdo->close();
}

elseif(isset($_GET['upload_progress'])){
	session_start();
require_once "../../inc/conn.php";

$conn = $pdo->open();

	$feed = array();

	$query = $conn->prepare("SELECT COUNT(*) as total from hfs");
	$query->execute();
	$feed[0] = $query->fetch()["total"];

	$query1 = $conn->prepare("SELECT MAX(rpid) as RPid from report");
	$query1->execute();
	$RPid = $query1->fetch()['RPid'];

	if($RPid === $_SESSION["rpid"]){
	$query2 = $conn->prepare("SELECT count(DISTINCT fid) as rcount from report where rpid = :rpid");
	$query2->execute(["rpid"=> $RPid]);
	$row = $query2->fetch();
	$feed[1] = $row['rcount'];
	}

	echo json_encode($feed);


$pdo->close();

}

 elseif(isset($_GET['send_note'])){

 		$msg = $_GET['send_note'];

 		require_once "../../inc/conn.php";
		$conn = $pdo->open();
		try{
		$query = $conn->prepare("INSERT into notifications (msg) values (:msg)");
		$query->execute(["msg"=>$msg]);
		echo "notification sent";
	}

	catch(PDOException $e){
		echo $e;
	}

		$pdo->close();
}

elseif(isset($_GET['get_note'])){

 		$lnid = $_GET['get_note'];

 		require_once "../../inc/conn.php";
 		$conn = $pdo->open();

 		$feed = array();

 		if($lnid !== null && $lnid !== ""){

 			$query = $conn->prepare("SELECT * from notifications where id > :lnid and deleted = 0 order by id asc");
 			$query->execute(["lnid"=>$lnid]);

 			while($row = $query->fetch()){
 				$c["msg"] = $row["msg"];
 				$c["time"] = $row["date_added"];
 				$c["id"] = $row["id"];
 				array_push($feed, $c);
 			}
 		}

 		else{
 			$query = $conn->prepare("SELECT * from notifications where deleted = 0 order by id asc");
 			$query->execute();

 			while($row = $query->fetch()){
 				$c["msg"] = $row["msg"];
 				$c["time"] = $row["date_added"];
 				$c["id"] = $row["id"];
 				array_push($feed, $c);
 			}
 		}

 		if(count($feed) !== 0){
 			echo json_encode($feed);
 		}
 		else{
 			echo 300;
 		}
		
		

		$pdo->close();
}

elseif(isset($_GET["edit_fac"])){
	require_once "../../inc/conn.php";
	$id = $_GET["edit_fac"];
	$name = $_GET["name"];
	$lga = $_GET["lga"];

 		$conn = $pdo->open();

$query = $conn->prepare("UPDATE hfs set name = :name, lga = :lga where id = :id");
 			$query->execute(["id"=>$id, "name"=>$name, "lga"=>$lga]);
 			echo "successful";
 			note("updated ".$name."'s information in the database. <a href='facilities' onclick='fetchFac()'>Click here</a> for updated list.", $conn);
		$pdo->close();
}

elseif(isset($_GET["del_fac"])){
	$id = $_GET["del_fac"];
	require_once "../../inc/conn.php";
 		$conn = $pdo->open();
$query = $conn->prepare("UPDATE hfs set deleted = 1 where id = :id ");
 			$query->execute(["id"=>$id]);
 			echo "successful";
 			$getName = $conn->prepare("SELECT name from hfs where id = :id");
	$getName->execute(["id"=>$id]);
	$name = $getName->fetch()['name'];
 			note("deleted ".$name." from database. <a href='facilities' onclick='fetchFac()'>Click here</a> for updated list.", $conn);
		$pdo->close();
}

elseif(isset($_GET["edit_user"])){
	require_once "../../inc/conn.php";
	$id = $_GET["edit_user"];
	$name = $_GET["name"];
	$lga = $_GET["lga"];

 		$conn = $pdo->open();

$query = $conn->prepare("UPDATE users set name = :name, lga = :lga where id = :id");
 			$query->execute(["id"=>$id, "name"=>$name, "lga"=>$lga]);
 			echo "successful";

		$pdo->close();
}

elseif(isset($_GET["del_user"])){
	$id = $_GET["del_user"];
	require_once "../../inc/conn.php";
 		$conn = $pdo->open();

$query = $conn->prepare("UPDATE users set deleted = 1 where id = :id");
 			$query->execute(["id"=>$id]);
 			echo "successful";

 	$getName = $conn->prepare("SELECT fname, lname from users where id = :id");
	$getName->execute(["id"=>$id]);
	$row = $getName->fetch();
	$name = $row["lname"]." ". $row["fname"];
 			note("deleted ".$name." from the database. <a href='staffs' onclick='getStaff()'>Click here</a> for updated list.", $conn);

		$pdo->close();
}

elseif(isset($_GET['upload_progress_lga'])){
	session_start();
require_once "../../inc/conn.php";

$conn = $pdo->open();

	$feed = array();

	$query1 = $conn->prepare("SELECT MAX(rpid) as RPid from report");
	$query1->execute();
	$RPid = $query1->fetch()['RPid'];

	$RPid = $_SESSION["rpid"];
	$query = $conn->prepare("SELECT DISTINCT(lga) as lga from hfs");
	$query->execute();
	foreach ($query as $key) {
		$lga = $key['lga'];
		$content["lga"] = $lga;
		$check = array();

	$query = $conn->prepare("SELECT COUNT(*) as total from hfs where lga = :lga AND deleted = 0");
	$query->execute(["lga"=>$lga]);
	$check[0] = $query->fetch()["total"];

	$query2 = $conn->prepare("SELECT DISTINCT report.fid as fid, hfs.id from hfs right join report on report.fid = hfs.id where rpid = :rpid AND lga = :lga");
	$query2->execute(["rpid"=> $RPid, "lga"=> $lga]);
	$n = 0;
	$fid = array();
	foreach ($query2 as $key ) {
		$facid = $key['fid'];
	$query3 = $conn->prepare("SELECT cid from report where rpid = :rpid and fid = :fid");
	$query3->execute(["rpid"=> $RPid, "fid"=> $facid]);
//	$comNum = $query3->fetch()["comNum"];
		$send["fid"] = $facid;
		$cids = array();
		$num = 0;
		foreach ($query3 as $key) {
			$num++;
			array_push($cids, $key["cid"]);
		}
		$send["cids"] = $cids;
		$send["comNum"] = $num;
		array_push($fid, $send);
		$n++;
	}
	$check[1] = $n;

	$content["fid"] = $fid;
	$content["report"] = $check;
	array_push($feed, $content);
	}
//}

	echo json_encode($feed);


$pdo->close();

}
/*$ph = "08065348492";
echo createPass($ph); */

?>