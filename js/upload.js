//Viewing of entered commodities for facility pending confirmation and upload

$(".submit-fac-coms").click(function(){
  var facid = $(this).attr("fac-data-id");
  if(facid === "" || facid === null || facid === undefined){
    return false;
  }
  else{
  var getStoredRepo = JSON.parse(localStorage.getItem("comReport-"+facid));
  //alert(getStoredRepo);
  var facname = JSON.parse(localStorage.getItem("facRepoInfo")).facname;

  if(getStoredRepo !== null && getStoredRepo !== "" && getStoredRepo !== undefined){
  $(".com-reporting-block").hide();
  $(".submit-com-table").show();
      var table = '<table class="table table-bordered table-responsive table-striped table-condensed table-report"><thead class="bg-amber" width="100%"><h2>'+facname+'<span style="text-align: center;" class="font-16 pull-right">('+getStoredRepo.length+' products reported)</span></h2></thead>'+
  '<tr class="bg-blue-grey"><th style="width: 200px">Products</th><th style="text-align:center">Beginning balance</th><th style="text-align:center">Quantity received</th><th style="text-align:center">Quantity dispensed</th><th style="text-align:center">Positive (+ve) adjustment</th><th style="text-align:center">Negative (-ve) adjustment</th><th style="text-align:center">Closing balance</th><th style="text-align:center">Nearest expiry</th><th style="text-align:center">Remarks</th></tr><tbody>';

  if(getStoredRepo.length > 1){
  for(var i = 0; i < getStoredRepo.length; i++){
    table = table + getComRow(i, facid);
  }
  table = table + "</tbody></table><div class='row bg-grey' style='padding: 10px;'><div><a href='javascript:void(0);' class='btn btn-default waves-effect pull-left' onclick='submitComCancel()'><i class='material-icons' style='color: #d9501e !important; width: 20px; font-size: 16px !important; margin: 0'>arrow_backward</i><span class='font-14'>Back</span></a><a href='javascript:void(0);' class='btn btn-default waves-effect pull-right' onclick='submitFacCom("+facid+")'><i class='material-icons' style='color: #d9501e !important; width: 20px; font-size: 16px !important; margin: 0'>cloud_upload</i><span class='font-14'>Confirm</span></a></div><div class='progress hidden com-upload-progress'><div class='progress-bar progress-bar-striped active' role='progressbar'\
  aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width:0%'></div></div><p class='progressCount'></p>";
}
else{
    table = table + getComRow(0, facid);
  table = table + "</tbody></table><div class='row bg-indigo' style='padding: 10px;'><div><a href='javascript:void(0);' class='btn btn-default waves-effect btn-lg pull-left' onclick='submitComCancel()'><i class='material-icons' style='color: red !important; width: 20px; font-size: 20px !important; margin: 0'>arrow_backward</i><span class='font-16'>Back to products</span></a><a href='javascript:void(0);' class='btn btn-default waves-effect btn-lg pull-right' onclick='submitFacCom("+facid+")'><i class='material-icons' style='color: red !important; width: 20px; font-size: 20px !important; margin: 0'>cloud_upload</i><span class='font-16'>Confirm submission</span></a></div><div class='progress hidden com-upload-progress'><div class='progress-bar progress-bar-striped active' role='progressbar'\
  aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width:0%'></div></div><p class='progressCount'></p>";
}
$(".submit-com-table").addClass("card").html("<div class='body'>"+table+ "</div>");
}
else{
  swal("No entries yet for product", "Please note that you can not submit report on commodity without filling the input fields", "warning");
  return false;
}
}
})

function getComRow(i, fid){
  var store = JSON.parse(localStorage.getItem("comReport-"+fid));
  var cid = store[i].cid;
  var product = getComName(cid);
  var tr = '<tr><td>'+product+'</td>'+
                '<td style="text-align:center">'+store[i].prevBal+'</td>'+
                '<td style="text-align:center">'+store[i].received+'</td>'+
                '<td style="text-align:center">'+store[i].issued+'</td>'+
                '<td style="text-align:center">'+store[i].posAdjust+'</td>'+
                '<td style="text-align:center">'+store[i].negAdjust+'</td>'+
                '<td style="text-align:center">'+store[i].balance+'</td>'+
                '<td style="text-align:center">'+store[i].expiry+'</td>'+
                '<td>'+store[i].remarks+'</td>'+
            '</tr>';
  return tr;
}

function getComName(cid){
  var checkCommodities = JSON.parse(localStorage.getItem("commodities"));
  var name = "";
 for(var i = 0; i < checkCommodities.length; i++){
  if(cid === checkCommodities[i].id){
    name = checkCommodities[i].name;
    break;
  }
  else{}
 }
return name;
}

function submitComCancel(){
$(".com-reporting-block").show();
$(".submit-com-table").hide();
}

function submitFacCom(fid){
  status = navigator.onLine;
  if(String(status) !== "true"){
    swal("You are offline", "Kindly connect to internet or move to an area where the network service is better to upload reports", "warning");
    return false;
  }
else{
var no = 0;
var store = JSON.parse(localStorage.getItem("comReport-"+fid));
var uploadCount = 0;
for(var a = 0; a < store.length; a++){
  if(store[a].status !== "uploaded"){
    uploadCount++;
  }
}

if(uploadCount === 0){
  swal("File Already Uploaded", "You have successfully uploaded the report for all your products", "warning");
  return false;
}


for(var i = 0; i < store.length; i++){
  if(store[i].status !== "uploaded"){
$(".com-upload-progress").removeClass("hidden");

//store[i].status = "uploaded";
$.post("pages/dbconn.php", 
{
upload_report: true,
cid: store[i].cid,
fid: fid,
prevBal: store[i].prevBal,
received: store[i].received,
issued: store[i].issued,
posAdjust: store[i].posAdjust,
negAdjust: store[i].negAdjust,
balance: store[i].balance,
expiry: store[i].expiry,
remarks: store[i].remarks,
}, function(data){
if(xhrError(data) === 200){
  no++;
  var width = parseInt(no/uploadCount*100);
var widthp = width + "%";
$(".progress-bar").attr({
"style": "width: "+widthp,
"aria-valuenow": width,
}).html(widthp);

//$(".progressCount").html("("+no+" of "+uploadCount+")");
if(no === uploadCount){
  $(".progressCount").html("Upload completed!");
  //to send notification to database
  var facInfo = JSON.parse(localStorage.getItem("facRepoInfo"));
  facname = facInfo.facname;
  var msg = userInfo[0].lname + " "+ userInfo[0].fname+ " updated the report for "+ compressName(facname);
  $.get("pages/dbconn.php?send_note="+msg, function(data){
    console.log(data);
  });
}

}
else{
  console.log(data);
  $(".progressCount").html("Upload failed!");
  return false;
}
});

}
changeStatus(i);
}

function changeStatus(i){
store[i].status = "uploaded";
}

localStorage.setItem("comReport-"+fid, JSON.stringify(store));
updateFormInfo();
}

}