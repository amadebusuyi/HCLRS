/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  _____________________________________ Hfs Scripts ____________________________________  
  ______________________________________________________________________________________
                                                                                         */


$(function () {

     $('.loaded').html('<div class="preloader" style="height: 25px; width: 25px; float: left"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
      var table = '<thead><tr>'+
                       '<th>Facility Name</th>'+
                       '<th>LGA</th>'+
                      '<th>OIC Name</th>'+
                      '<th>OIC Phone</th>'+
                    '</tr></thead>'+
                  '<tbody>';

    
    var get = localStorage.getItem("hfs");
    
    if(get == "" || get == undefined){

    $.get("pages/dbconn.php?fetch_hfs", function(data){
        //var hfs = JSON.parse(data);
        localStorage.setItem("hfs", data);
        console.log("HFs stored locally for easy access");
        //alert("HFs stored locally for easy access");
        getFac();
    })         
}

else{
    getFac();
    //localStorage.removeItem("hfs");
}

function getFac(){

    var facilities = JSON.parse(localStorage.getItem("hfs"));


    for(var i = 0; i < facilities.length; i++){
        var facility = facilities[i];
        var output = "<tr><td>"+facility.name+"</td>"+
                    "<td>"+facility.lga+"</td>"+
                    "<td>-</td>"+
                    "<td>-</td>" +
                    '</tr>';
        table = table + output;
    }

    $('.table-hfs').html('<table class="table table-bordered table-striped table-hover hfs-table dataTable"></table>');
    table = table +  '</tbody>';
      $('.hfs-table').html(table).DataTable({responsive: true});
       $('.loaded').remove();
   }
})


/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  ___________________________________ Staff Scripts ____________________________________  
  ______________________________________________________________________________________
                                                                                         */

  $(function () {

    $('.st-loader').html('<div class="preloader" style="height: 25px; width: 25px; float: left"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');


    var table = '<thead><tr>'+
                       '<th>Name</th>'+
                       '<th>Position</th>'+
                      '<th>Office</th>'+
                      '<th>Phone</th>'+
                      '<th>Email</th>'+
                    '</tr></thead>'+
                  '<tbody class="staff-table-rows">';

                                        
    $.get("pages/dbconn.php?fetch", function(data){

    $('.table-staffs').html('<table class="table table-bordered table-striped table-hover staffs-table dataTable"></table>');

      data = JSON.parse(data);
      for(var i = 0; i<data.length; i++){
        
        var content = '<tr><td>'+data[i].fname+' '+data[i].lname+'</td>'+
                      '<td>'+data[i].designation+'</td>'+
                      '<td>'+data[i].address+'</td>'+
                      '<td>'+data[i].phone+''+
                      '<td>'+data[i].email+'</td>'+
                      '</tr>'; 
                      table = table+content; 
      }
      table = table +  '</tbody>';
      $('.staffs-table').html(table).DataTable({responsive: true});
      $('.st-loader').remove();
    })
  

if(checkLoc("notifications") !== -1){
  var store = "notifications-"+userInfo[0].id;
  if(isEmpty(store) === false){
  //sendNote(store);
    var check = JSON.parse(localStorage.getItem(store));
    for(var i = 0; i < check.length; i++){
    var noMsg = '<p class="no-msg">'+check[i].msg+'</p><p class="no-time"><i class="material-icons">access_time</i> '+formatDate(check[i].time)+'\
                  </p>';

                $(".notifications").prepend("<div class='alert no-display'>"+noMsg+"</div>");
              }
}
}

  });


