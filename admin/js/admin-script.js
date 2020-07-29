/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  _____________________________________ Hfs Scripts ____________________________________  
  ______________________________________________________________________________________
                                                                                        */
$(function () {
    if(checkLoc("facilities") !== -1){

    $('.st-loader').html('<div class="preloader" style="height: 25px; width: 25px; float: left"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');

    var get = localStorage.getItem("hfs");
    if(isEmpty(get) === true){
      fetchFac();
}

else{
  getFac();
}
}
});

function fetchFac(){

    $.get("pages/dbconn.php?fetch_hfs", function(data){
        if(xhrError(data) === 200){
        localStorage.setItem("hfs", data);
        console.log("HFs stored locally for easy access");
        //alert("HFs stored locally for easy access");
        getFac();}
        else{
          console.log("Challenges with connecting to database "+ data);
        }
    })
}

function getFac(){

    var facilities = JSON.parse(localStorage.getItem("hfs"));

    var table = '<thead><tr>'+
                       '<th>Facility Name</th>'+
                       '<th>LGA</th>'+
                      '<th>OIC Name</th>'+
                      '<th>OIC Phone</th>'+
                      '<th>Actions</th>'+
                    '</tr></thead>'+
                  '<tbody>';

    for(var i = 0; i < facilities.length; i++){
        var facility = facilities[i];
        var output = "<tr id='staff-"+facility.id+"'><td style='cursor: pointer' onclick='facRepo("+facility.id+", \""+facility.name+"\", \""+facility.lga+"\")'>"+facility.name+"</td>"+
                    "<td>"+facility.lga+"</td>"+
                    "<td>-</td>"+
                    "<td>-</td>" +
                    '<td class="action-btn"><button type="button" data-toggle="modal" data-target="#edit-fac-modal" id="edit-fac" onclick="editFac('+facility.id+', \''+facility.name+'\', \''+facility.lga+'\')" data-id="'+facility.id+'" class="btn btn-info btn-sm m-t-15 waves-effect">'+
                      '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;'+
                      '<button type="button" id="delete-fac" onclick="deleteFac('+facility.id+', \''+facility.name+'\')" data-id="'+facility.id+'" class="btn btn-danger btn-sm m-t-15 waves-effect">'+
                      '<i class="glyphicon glyphicon-trash"></i></button></td></tr>';
        table = table + output;
    }

    $('.table-hfs').html('<table class="table table-bordered table-striped table-hover hfs-table dataTable"></table>');
    table = table +  '</tbody>';
      $('.hfs-table').html(table).DataTable({dom: 'Bfrtip', responsive: true, buttons: ['copy', 'csv', 'excel', 'pdf', 'print']});
      $('.st-loader').empty();
   }



/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  ___________________________________ Staff Scripts ____________________________________  
  ______________________________________________________________________________________
                                                                                        */
  function getStaff(){

    $.get("pages/dbconn.php?fetch", function(data){

    if(xhrError(data) === 200){
      localStorage.setItem("staffs", data); 
      loadStaff(data);
      console.log("Staffs added to local storage");
    }
 })
  }

  function loadStaff(data){
    var table = '<thead><tr>'+
                       '<th>Name</th>'+
                       '<th>Position</th>'+
                      '<th>Office</th>'+
                      '<th>Phone</th>'+
                      '<th>Email</th>'+
                      '<th>Actions</th>'+
                    '</tr></thead>'+
                  '<tbody class="staff-table-rows">';

    $('.table-staffs').html('<table class="table table-bordered table-striped table-hover staffs-table dataTable"></table>');

      data = JSON.parse(data);
      for(var i = 0; i<data.length; i++){

        var content = '<tr><td>'+data[i].fname+' '+data[i].lname+'</td>'+
                      '<td>'+data[i].designation+'</td>'+
                      '<td>'+data[i].address+'</td>'+
                      '<td>'+data[i].phone+''+
                      '<td>'+data[i].email+'</td>'+
                      '<td><button type="button" id="edit-staff" data-d="'+data[i].id+'" class="btn btn-info btn-sm m-t-15 waves-effect">'+
                      '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;'+
                      '<button type="button" id="delete-staff" onclick="deleteUser('+data[i].id+', \''+data[i].fname+' '+data[i].lname+'\')" data-id="'+data[i].id+'" class="btn btn-danger btn-sm m-t-15 waves-effect">'+
                      '<i class="glyphicon glyphicon-trash"></i></button></td></tr>'; 
                      table = table+content; 
      }
      table = table +  '</tbody>';
      $('.staffs-table').html(table).DataTable({dom: 'Bfrtip', responsive: true, buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]});
      $('.loader-st').empty();
}

  $(function () {
if(checkLoc("staffs") !== -1){

      $('.loader-st').html('<div class="preloader" style="height: 25px; width: 25px; float: left"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
      
      var data = localStorage.getItem("staffs");
      if (isEmpty(data) === false){
        loadStaff(data);
      }

        else{
          getStaff();
        }
    }


//____________________________------ Add Staff Script -------_________________________

function removeAlert(formRef, domRef, el){

    $(formRef + " input").keydown(function(){
      $(domRef).removeClass(el).empty();
    })

    $(formRef +" select").click(function(){
      $(domRef).removeClass(el).empty();
    })

    $(formRef +" [type='radio']").click(function(){
      $(domRef).removeClass(el).empty();
    })

    $(formRef +" [type='file']").click(function(){
      $(domRef).removeClass(el).empty();
    })
  }

function emptyForm(formRef){
    $(formRef + " input").val("");
    $(formRef + " textarea").html("");
    $(formRef + " select").val("");
    $(formRef + " [type='file']").val("");
}
removeAlert("#add_staff_form", ".add_staff_log", "alert alert-warning alert-success");

    $('.add-officer').click(function(e){
      e.preventDefault();
      var lname = $('#lname').val();
      var fname = $('#fname').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var gender = $('input[name=gender]:checked', '#add_staff_form').val();
      
      var role = $('#role').val();
      var designation = $('#designation').val();
      var address = $('#address').val();
      var lga = $('#lga').val();

      if(lname === "" || fname === "" || phone === "" || role === "" || gender === undefined){
        $(".add_staff_log").addClass("alert alert-warning").text("All important field must be filled!");
        return false;
      }

      $.post("pages/dbconn.php", {
        addStaff: true,
        lname: lname,
        fname: fname,
        email: email,
        phone: phone,
        gender: gender,
        role: role,
        designation: designation,
        address: address,
        lga: lga
      }, function(data){
        if(xhrError(data) !== 404){
        $(".add_staff_log").addClass("alert alert-success").text(data);
        getStaff();
        emptyForm("#add_staff_form");}
        else{
          $(".add_staff_log").addClass("alert alert-warning").text("All important field must be filled!");
        }
      })
    })

});

function deleteFac(id, name){

      var facilities = JSON.parse(localStorage.getItem("hfs"));
      var  exist = -1;

    //first of all, confirm deletion

    swal({
        title: "Are you sure?",
        text: "You are about to delete "+name + " from database.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
      if (isConfirm) {
        del();        
        }
    })

    //then delete this from database with function del()

    function del() {
//sendNote("I got here");

    for(var i = 0; i < facilities.length; i++){
      if(facilities[i].id == id){
        //sendNote(i);
        exist = i;
        break;
      } 
      else{}
    }

  if(exist !== -1){
    $.get("pages/dbconn.php?del_fac="+id, function(data){
      if(xhrError(data) === 200 && isEmpty(data) !== true){
//        sendNote(exist);
        facilities.splice(exist, 1);
        localStorage.setItem("hfs", JSON.stringify(facilities));
        swal("Done", name+" has been removed", "success"); 
        getFac();
        }
        else{
          swal("Delete Failed", name+" could not be removed due to database connection error", "warning");
        }
      
  });
  }

}

}

function editFac(id, name, lga){
    console.log(name+id);
    $("#fac_name").val(name);
    $("#fac_lga option").each(function(){
      var value = $(this).attr("value");
      if(value == lga){
        $(this).attr("selected", true);
      }
    });
    $(".fac-edit-save").attr("data-id", id);
}

$(".fac-edit-save").click(function(){
  var id = $(this).attr("data-id");
  var name = $("#fac_name").val();
  var lga = $("#fac_lga").val();

  //first of all, confirm Edit

    swal({
        title: "Are you sure?",
        text: "You are about to modify this facility's information",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
      if (isConfirm) {
          changeFac(id, name, lga);   
        }
    })
})

function changeFac(id, name, lga){
  var facilities = JSON.parse(localStorage.getItem("hfs"));
  var  exist = -1;
    for(var i = 0; i < facilities.length; i++){
      if(facilities[i].id == id){
        //sendNote(i);
        exist = i;
        break;
      } 
      else{}
    }

  if(exist !== -1){
  //  sendNote("I got here");
  $.get("pages/dbconn.php?edit_fac="+id+"&name="+name+"&lga="+lga, function(data){
    if(xhrError(data) === 200 && isEmpty(data) === false){
    facilities[exist].name = name;
    facilities[exist].lga = lga;
    localStorage.setItem("hfs", JSON.stringify(facilities));
    getFac();
    swal("Done", "Facility information has been modified", "success");
    $("#edit-fac-modal").modal("hide");
  }
  else{
    swal("Failed!", name+" information cannot be changed due to error in connection to database", "warning");
  }
  });
  } 
}

function deleteUser(id, name){

      var staffs = JSON.parse(localStorage.getItem("staffs"));
     var  exist = -1;

    //first of all, confirm deletion

    swal({
        title: "Are you sure?",
        text: "You are about to delete "+name + " from database.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
      if (isConfirm) {
        del();        
        }
    })

    //then delete this from database with function del()

    function del() {
//sendNote("I got here");

    for(var i = 0; i < staffs.length; i++){
      if(staffs[i].id == id){
 //       sendNote(i);
        exist = i;
        break;
      } 
      else{}
    }

  if(exist !== -1){ 
    $.get("pages/dbconn.php?del_user="+id, function(data){
      if(xhrError(data) === 200 && isEmpty(data) !== true){
//        sendNote(exist);
        staffs.splice(exist, 1);
        localStorage.setItem("staffs", JSON.stringify(staffs));
        swal("Done", name+" has been removed", "success"); 
        loadStaff(JSON.stringify(staffs));
        }
        else{
          swal("Delete Failed", name+" could not be removed due to database connection error", "warning");
        }
      
  });
  }

}

}

function editUser(id, name, lga){
    console.log(name+id);
    $("#fac_name").val(name);
    $("#fac_lga option").each(function(){
      var value = $(this).attr("value");
      if(value == lga){
        $(this).attr("selected", true);
      }
    });
    $(".user-edit-save").attr("data-id", id);
}

$(".user-edit-save").click(function(){
  var id = $(this).attr("data-id");
  var name = $("#fac_name").val();
  var lga = $("#fac_lga").val();

  //first of all, confirm Edit

    swal({
        title: "Are you sure?",
        text: "You are about to modify user information",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
      if (isConfirm) {
          changeUser(id, name, lga);   
        }
    })
})

function changeUser(id, name, lga){
  var facilities = JSON.parse(localStorage.getItem("hfs"));
  var  exist = -1;
    for(var i = 0; i < facilities.length; i++){
      if(facilities[i].id == id){
        //sendNote(i);
        exist = i;
        break;
      } 
      else{}
    }

  if(exist !== -1){
  //  sendNote("I got here");
  $.get("pages/dbconn.php?edit_fac="+id+"&name="+name+"&lga="+lga, function(data){
    if(xhrError(data) === 200 && isEmpty(data) === false){
    facilities[exist].name = name;
    facilities[exist].lga = lga;
    localStorage.setItem("hfs", JSON.stringify(facilities));
    getFac();
    swal("Done", "Facility information has been modified", "success");
    $("#edit-fac-modal").modal("hide");
  }
  else{
    swal("Failed!", name+" information cannot be changed due to error in connection to database", "warning");
  }
  });
  } 
}

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
