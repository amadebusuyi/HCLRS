<script type="text/javascript" src="js/fac-repo.js"></script>

<!--<script type="text/javascript">
//declare a global variable for the facility in question
var FACID = getFacid();
if(FACID === "error"){
 var curr_location = window.location;
 var checkSearch = String(curr_location).search("facility-report");
 if(checkSearch !== -1){
  window.location.assign("reporting");
 }
 else{}
}

//get Name of facility with report
function getFacid(){
var facInfo = JSON.parse(localStorage.getItem("logged"));
if(facInfo !== "" && facInfo !== undefined && facInfo !== null){
 // alert(200);
var facid = facInfo[0].facid;
facname = facInfo[0].facname;
faclga = facInfo[0].faclga;
$(".fac-name").html(facname);
$(".fac-lga").html("("+faclga+" LGA)");
$(".submit-fac-coms").attr("fac-data-id", facid);
return facid;
}
else{
  return "error";
}
}

//handles commodity fetch from either database or localstorage

 var loader = '<div class="preloader" style="height: 25px; width: 25px; float: left"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';

var checkCom = localStorage.getItem("commodities");
if(checkCom == "" || checkCom == undefined){
  $(".wait-loader").html(loader);
        getCom();        
}

else{
    $(".wait-loader").html(loader);
    loadCom(checkCom);
}

//function storeRadio() stores the com-availabilty state of each of the commodities locally pending other times

function storeRadio(id, value){
  var newStore = {cid: id, value: value};
  var radioStore = JSON.parse(localStorage.getItem("comAvailability-"+FACID));
  if(radioStore !== null && radioStore !== undefined && radioStore !== ""){
   var  exist = -1;
    for(var i = 0; i < radioStore.length; i++){
      if(radioStore[i].cid == id){
        exist = i;
        break;
      } 
      else{}
    }

  if(exist !== -1){
    radioStore[exist] = newStore;
    localStorage.setItem("comAvailability-"+FACID, JSON.stringify(radioStore));
//    sendNote("Existing and updated");
  }
  else{
      radioStore.push(newStore);
      localStorage.setItem("comAvailability-"+FACID, JSON.stringify(radioStore));
//      sendNote("Added to radio list");
    }
  }

  else{
    var storeNew = [];
    storeNew[0] = newStore;
      localStorage.setItem("comAvailability-"+FACID, JSON.stringify(storeNew));
//      sendNote("First Item to be added to radio list");
    }
}

//function getStoredRadio fetch information on com-availability from local storage

function getStoredRadio(id){
  var radioStore = JSON.parse(localStorage.getItem("comAvailability-"+FACID));
  if(radioStore !== null && radioStore !== undefined && radioStore !== ""){
   var  exist = -1;
    for(var i = 0; i < radioStore.length; i++){
      if(radioStore[i].cid == id){
        exist = radioStore[i].value;
        break;
      } 
      else{}
    }

  if(exist !== -1){
    //set the radio click status to either show or hidden as the case may be using radioClick()
    if(exist === false){radioClick(id, "com-not-available", 1)}
      else{radioClick(id, "com-available", 1)}
        return exist;
  }
  else{radioClick(id, "com-not-available", 1); return false;}

}

else{radioClick(id, "com-not-available", 1); return false;}
}

//Update the com-availability state of each commodity

function radioClick(id, value, state){
$("[name=com-availability-"+id+"]").prop("disabled", false);
//alert(id);
  if(value === "com-available"){
    if(state === 1){$(".stock-repo-form-"+id).show();}
    else{    
    $(".stock-repo-form-"+id).show();
    storeRadio(id, true); }
    $("#ra-"+id).prop("disabled", true);
    $("[data-save-id="+id+"]").removeClass("disable-save");
  }
  else{
    if(state === 1){$(".stock-repo-form-"+id).hide();}
    else{
 confirmAction("Please be sure to confirm that this commodity is not available as any entry on commodity will be lost!", "", "", id);
  }
  }
}

function confirmAction(message, btnText, confirm, id) {
  //preventDefault();
var confirm = false;
  if(btnText === "" || btnText === undefined){btnText = "Continue"}
    swal({
        title: "Are you sure?",
        text: message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: btnText,
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
      if (isConfirm) {
        swal("Done", "Your change has been effected", "success"); 
         $(".stock-repo-form-"+id).hide();
          storeRadio(id, false);
          delStoredComEntries(id);
          clearField(id);
          updateFormInfo();
          $("#rna-"+id).prop("disabled", true);
          $("[data-save-id="+id+"]").addClass("disable-save");}
          else{
           //swal("Canceled", "Intended action has been cancelled succesfully", "success");
          $("#ra-"+id).prop("checked", true);          
          $("#rna-"+id).prop("checked", false);
          $("#ra-"+id).prop("disabled", true);
           //radioClick(id, "com-available");
          }
    });
  //alert(confirm);
}

// function delStoredComEntries() deletes the entries in local storage for com-availability = false when already stored locally

function delStoredComEntries(id){  
    var comGet = localStorage.getItem("comReport-"+FACID);
    if(comGet !== null && comGet !== undefined && comGet !== ""){
      var comStoreList = JSON.parse(comGet);
      var exist = -1;
      for (var i = 0; i <comStoreList.length; i++) {
        var comCheck = comStoreList[i].cid.indexOf(id);
        if (comCheck !== -1){
          exist = i;
          break;
        }
        else{}
      }
  
    if(exist !== -1){
      comStoreList.splice(exist, 1);
       localStorage.setItem("comReport-"+FACID, JSON.stringify(comStoreList)); 
//          sendNote("Entries removed for this item!");
    }
    else{}
  }
else{}

}

//This onclick function makes navigation from one commodity to another and transfer of relevant information possible

$(".com-link-load").click(function(){
  var pos = $(this).attr("arrayPos");

  displayComRepo(pos);
})

 function displayComRepo(pos){
    var commodities = JSON.parse(checkCom);
  var newName = commodities[pos].name + " - ("+commodities[pos].unit+")";
  var newId = commodities[pos].id;
  $(".com-li-display-sm [com-li-id]").removeClass("com-active");
  $(".com-li-display-xs [com-li-id]").removeClass("active com-active");
  $(".com-li-display-sm [com-li-id="+newId+"]").addClass("com-active");
  $(".com-li-display-xs [com-li-id="+newId+"]").addClass("com-active");
  $('.com-li-display-sm').scrollTop(0);
  var d = $('.com-active').offset().top;

  $('.com-li-display-sm').scrollTop(d-450);
  var prev = pos-1;
  var next = prev+2;
  if(prev === -1){
    $('.com-prev').addClass("hidden");
  }
  else if(prev === (commodities.length - 2)){
    $('.com-next').addClass("hidden");
  }
  else{
    $('.com-prev').removeClass("hidden");
    $('.com-next').removeClass("hidden");
  }
  var content = '<h2>'+newName+'</h2>';
  $('.com-header').html(content);
  $('.com-prev').attr({
          "arrayPos": prev,
          "href": "#menu"+pos,
      });

  $('.com-next').attr({
          "arrayPos": next,
          "href": "#menu"+pos,
      });

  $('.com-link-save').attr({
          "data-save-id": newId
      }).text("Save");

  var radio = getRadio(newId);
  $('.com-radio').html(radio)
  $('#ra-'+newId).attr("data-id", newId);
  $('#rna-'+newId).attr("data-id", newId);
  $('.com-radio').removeClass("hidden");
  $('.com-footer').removeClass('hidden');

  $(".stock-repo-form-"+newId+" .prev-balance").focus();
 }


$(function(){
  //Just to load the form for the first element on the com list
 function comStart(){
  var pos = 0;
  if(checkCom === null){
    setTimeout(function(){
    window.location.assign("reporting");}, 1000);
  }
  updateFormInfo();
  displayComRepo(pos);
 }
 comStart();

 })


//To start the process of saving commodity entries to local storage

 $('.com-link-save').click(function(){
  var id = $(this).attr("data-save-id");
var check = $(this).hasClass("disable-save");
if(check === true){
    swal("Cannot save product", "Please note that you can not save products that are set as \"Not Available\". Kindly change product to available in order to save. Click next/prev or the name of product to select another product", "warning");
      return false;
}
else{verAndSave(id);}

 })

 //update fields by clearing entries
 function clearField(cid){
   //set all fields to empty
        $('#prev-balance-'+cid).val("");
        $('#received-'+cid).val("");
        $('#issued-'+cid).val("");
        $('#pos-adjust-'+cid).val("");
        $('#neg-adjust-'+cid).val("");
        $('#balance-'+cid).val("");
        $('#remarks-'+cid).val("");
 }

 //Update previous form entries from locally stored entries especially in cases of page reload to the form with updateFormInfo()

 function updateFormInfo(){
  //Update each field as necessary
  var comGet = localStorage.getItem("comReport-"+FACID);
    if(comGet !== null && comGet !== undefined && comGet !== ""){
      var comStoreList = JSON.parse(comGet);
      var totalStored = 0; 
      for(var a = 0; a < comStoreList.length; a++){
        if(comStoreList[a].status !=="uploaded"){
          totalStored++;
        }
      }
      var facname = userInfo[0].facname;
      if(totalStored < 1){var noText = "";}
      else if(totalStored === 1){
        var noText = totalStored + " product pending upload for "+compressName(facname);}
      else{var noText = totalStored + " products pending upload for "+compressName(facname);}
      $(".repo-info-note .com-status").html(" "+ noText).removeClass("hidden");
//      sendNote(noText);
      for(var i = 0; i < comStoreList.length; i++){
        var id = comStoreList[i].cid;
        $('#prev-balance-'+id).val(comStoreList[i].prevBal);
        $('#received-'+id).val(comStoreList[i].received);
        $('#issued-'+id).val(comStoreList[i].issued);
        $('#pos-adjust-'+id).val(comStoreList[i].posAdjust);
        $('#neg-adjust-'+id).val(comStoreList[i].negAdjust);
        $('#balance-'+id).val(comStoreList[i].balance);
        $('#remarks-'+id).val(comStoreList[i].remarks);
      }
}
else{}

 }

// function sendNote is used to connect with the bootstrap notification js function to send notifications to user

function sendNote(text, bgcolor){
  if(bgcolor === "" || bgcolor === undefined){bgcolor = "bg-black";}
      showNotification(bgcolor, text, "bottom", "right", "animated bounceInRight", "animated bounceOutRight");
  }


// function verAndSave verifies each form entry and saves it in the local storage and online as the case may be

 function verAndSave(id){
  //get form data
  var prevBal = $('#prev-balance-'+id).val();
  var received = $('#received-'+id).val();
  var issued = $('#issued-'+id).val();
  var posAdjust = $('#pos-adjust-'+id).val();
  var negAdjust = $('#neg-adjust-'+id).val();
  var balance = $('#balance-'+id).val();
  var remarks = $('#remarks-'+id).val();

//screen form data for empty fields and replace with 0s
  if(prevBal === "" || prevBal === undefined){
    prevBal = 0;
    $('#prev-balance-'+id).val(0);
  }

  if(received === "" || received === undefined){
    received = 0;
    $('#received-'+id).val(0);
  }

  if(issued === "" || issued === undefined){
    issued = 0;
    $('#issued-'+id).val(0);
  }

  if(posAdjust === "" || posAdjust === undefined){
    posAdjust = 0;
    $('#pos-adjust-'+id).val(0);
  }

  if(negAdjust === "" || negAdjust === undefined){
    negAdjust = 0;
    $('#neg-adjust-'+id).val(0);
  }

  if(balance === "" || balance === undefined){
    balance = 0;
    $('#balance-'+id).val(0);
  }
//verify submission of absolute stock out

  if(Number(prevBal) === 0 && Number(received) === 0 && Number(issued) === 0 && Number(posAdjust) === 0 && Number(negAdjust) === 0 && Number(balance) === 0){
    swal({
        title: "Are you sure?",
        text: "Your entries indicate stock out on commodity. Please cancel and click not available if commodity is not been used in your facility else click on proceed to confirm submission.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
    }, function () {
        storageHandler();
        swal("Done!", "Your entries have been submitted", "success"); 
        //return;
    });
    return;
  }

//verify that the entries and closing balance is correct, notify user if it isn't
  var bal = Number(prevBal) + Number(received) - Number(issued) + Number(posAdjust) - Number(negAdjust);
  if(bal !== Number(balance)){
  $('.bal-alert-'+id).removeClass("hidden bg-light-blue").addClass("alert-warning").text("Your balance is not correct. Kindly check your entries (bal: "+bal+")");
  $('#balance-'+id).focus();
  return false;
}
  else{
    storageHandler();
  }
  function storageHandler(){
    var comInfo = {uid: userInfo[0].id, cid: id, prevBal: prevBal, received: received, issued: issued, posAdjust:  posAdjust, negAdjust:  negAdjust, balance: balance, remarks: remarks};

    var comGet = localStorage.getItem("comReport-"+FACID);

    if(comGet !== null && comGet !== undefined && comGet !== ""){

      var comStoreList = JSON.parse(comGet);
      var exist = -1;
      for (var i = 0; i <comStoreList.length; i++) {
        var comCheck = comStoreList[i].cid.indexOf(id);
        if (comCheck !== -1){
          exist = i;
          break;
        }
        else{}
      }
      if(exist === -1){
        comStoreList.push(comInfo);
          localStorage.setItem("comReport-"+FACID, JSON.stringify(comStoreList)); 
          updateFormInfo();
          sendNote("Entries saved for commodity!");
        }
        else{
          comStoreList[exist] = comInfo;
          localStorage.setItem("comReport-"+FACID, JSON.stringify(comStoreList)); 
          updateFormInfo();          
          sendNote("Entries modified for commodity!");
        }     
    }

    else{
      var comStoreList = [comInfo];
      localStorage.setItem("comReport-"+FACID, JSON.stringify(comStoreList));
      updateFormInfo();
      sendNote("Entries saved for commodity!");
    }
  }
 }

//just to make sure a negative value is not entered and to ensure that alerts are removed
//This actually needs updating so that it can actually serve its purpose
$("[type=number]").keyup(function(){
  if(Number($(this).val()) < 0){
    $(this).val(0);
  }
  $('.bal-alert').addClass("hidden");
});

//checks whether user is online every 2seconds
setInterval(function(){
 var status = navigator.onLine;
 if(String(status) !== "true")
 $(".repo-info-note .status").html("<font color='#f0f0f0'>You are offline</font>");
else
 $(".repo-info-note .status").html("online");}, 2000);

//to get the com-availabilty information and update as neccessary
function getRadio(newId){
  var check = getStoredRadio(newId);
  var radio1 = "";
  var radio2 = "";
  if(check === true)
    {
      radio1 = "checked disabled"
      $(".com-link-save").removeClass("disable-save");
    }
  else
  {
    radio2 = "checked disabled";
  $(".com-link-save").addClass("disable-save");
  }

  return '<div class="col-xs-6">\
              <input name="com-availability-'+newId+'" type="radio" id="ra-'+newId+'" class="with-gap radio-col-amber" data-id="" onclick = "radioClick('+newId+', \'com-available\')" value="com-available" '+radio1+' />\
              <label for="ra-'+newId+'">Available</label></div>\
              <div class="col-xs-6">\
              <input name="com-availability-'+newId+'" type="radio" id="rna-'+newId+'" class="with-gap radio-col-deep-orange" data-id="" onclick = "radioClick('+newId+', \'com-not-available\')" value="com-not-available" '+radio2+' />\
              <label for="rna-'+newId+'">Not available</label></div>';
}

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
  '<tr class="bg-blue-grey"><th style="width: 200px">Products</th><th style="text-align:center">Beginning balance</th><th style="text-align:center">Quantity received</th><th style="text-align:center">Quantity dispensed</th><th style="text-align:center">Positive (+ve) adjustment</th><th style="text-align:center">Negative (-ve) adjustment</th><th style="text-align:center">Closing balance</th><th style="text-align:center">Remarks</th></tr><tbody>';

  if(getStoredRepo.length > 1){
  for(var i = 0; i < getStoredRepo.length; i++){
    table = table + getComRow(i, facid);
  }
  table = table + "</tbody></table><div class='row bg-indigo' style='padding: 10px;'><div><a href='javascript:void(0);' class='btn btn-default waves-effect pull-left' onclick='submitComCancel()'><i class='material-icons' style='color: red !important; width: 20px; font-size: 16px !important; margin: 0'>arrow_backward</i><span class='font-14'>Back to products</span></a><a href='javascript:void(0);' class='btn btn-default waves-effect pull-right' onclick='submitFacCom("+facid+")'><i class='material-icons' style='color: red !important; width: 20px; font-size: 16px !important; margin: 0'>cloud_upload</i><span class='font-14'>Confirm submission</span></a></div><div class='progress hidden com-upload-progress'><div class='progress-bar progress-bar-striped active' role='progressbar'\
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
}

}
else{
  console.log(data);
  return false;
}
});

}
}
for(var i = 0; i < store.length; i++){
  if(store[i].status !== "uploaded"){
store[i].status = "uploaded";
}
}
localStorage.setItem("comReport-"+fid, JSON.stringify(store));
updateFormInfo();
}

}

if(userInfo[0].rpid === null || userInfo[0].rpid === undefined){
  $(".stock-repo-form input").prop("disabled", true);
  $(".com-link-save, .submit-layer").hide();
  setInterval(function(){   
  $("[type=radio]").prop("disabled", true);
  }, 50);
}

</script> -->