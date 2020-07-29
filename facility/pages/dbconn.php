<?php 
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
	$remark = $_POST["remarks"];
	$rpid = $_SESSION["rpid"];
	if($rpid === null){
		echo "<b>Warning</b>: This document cannot be uploaded exception 'PDOException'";
		return;
	}
	require_once "../../inc/conn.php";
	$conn = $pdo->open();
	$query = $conn->prepare("SELECT max(id) as rid, count(id) as numrows from report where cid = :cid and rpid = :rpid and fid = :fid");
	$query->execute(['cid'=>$cid, 'rpid'=>$rpid, 'fid'=>$fid]);
	$row = $query->fetch();
	$rid = $row['rid'];	
	if($row['numrows'] < 1){
	try{
		$query = $conn->prepare("INSERT into report (cid, fid, rpid, userid, prevBal, received, issued, posAdjust, negAdjust, balance, remark) values(:cid, :fid, :rpid, :uid, :prevBal, :received, :issued, :posAdjust, :negAdjust, :balance, :remark)");
		$query->execute(['cid'=>$cid, 'fid'=>$fid, 'rpid'=>$rpid, 'uid'=>$uid, 'prevBal'=>$prevBal, 'received'=>$received, 'issued'=>$issued, 'posAdjust'=>$posAdjust, 'negAdjust'=>$negAdjust, 'balance'=>$balance, 'remark'=>$remark]);

		echo "successful";

	}
	catch(PDOException $e){
		echo $e;
	} 
}
	else{
		$query = $conn->prepare("UPDATE report set userid=:uid, prevBal=:prevBal, received=:received, issued=:issued, posAdjust=:posAdjust, negAdjust=:negAdjust, balance=:balance, remark=:remark where id=:rid");
		$query->execute(['rid'=>$rid, 'uid'=>$uid, 'prevBal'=>$prevBal, 'received'=>$received, 'issued'=>$issued, 'posAdjust'=>$posAdjust, 'negAdjust'=>$negAdjust, 'balance'=>$balance, 'remark'=>$remark]);
		echo "successful";
	}

$pdo->close();
}

 elseif(isset($_GET['send_note'])){

 		$msg = $_GET['send_note'];

 		require_once "../../inc/conn.php";
		$conn = $pdo->open();
		try{
		$query = $conn->prepare("INSERT into notifications (msg) values (:msg)");
		$query->execute(["msg"=>$msg]);
	}

	catch(PDOException $e){
		echo $e;
	}

		$pdo->close();
}

?>