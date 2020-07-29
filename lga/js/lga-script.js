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
    
    if(isEmpty(get) === true){

    $.get("pages/staffdb.php?fetch_hfs", function(data){
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
        if(facility.lga == userInfo[0].lga){
        var output = "<tr><td>"+facility.name+"</td>"+
                    "<td>"+facility.lga+"</td>"+
                    "<td>-</td>"+
                    "<td>-</td>" +
                    '</tr>';
        table = table + output;
      }
      else{}
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

                                        
    $.get("pages/staffdb.php?fetch", function(data){

    $('.table-staffs').html('<table class="table table-bordered table-striped table-hover staffs-table dataTable"></table>');

      data = JSON.parse(data);
      for(var i = 0; i<data.length; i++){
       
        if(data[i].lga == userInfo[0].lga){
        
        var content = '<tr><td>'+data[i].fname+' '+data[i].lname+'</td>'+
                      '<td>'+data[i].designation+'</td>'+
                      '<td>'+data[i].address+'</td>'+
                      '<td>'+data[i].phone+''+
                      '<td>'+data[i].email+'</td>'+
                      '</tr>'; 
                      table = table+content; 
      }
      else{}
    }
      table = table +  '</tbody>';
      $('.staffs-table').html(table).DataTable({responsive: true});
      $('.st-loader').remove();
    })

  });

/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  ______________________________ Facility Search Scripts _______________________________  
  ______________________________________________________________________________________
                                                                                      */

$(function () {

//listFacilitiesLga();

//____________________________------ fac repo scripts -------_________________________
    $(".fac-search").val("");
 
    $('.fac-search').keyup(function(e){
        e.preventDefault();
        var n = 0;
        $('.list-point').html('');
        var searchText = $(this).val();
        searchText = searchText.toLowerCase().replace("chc", "Comprehensive Health Centre");
        searchText = searchText.toLowerCase().replace("bhc", "Basic Health Centre");
        searchText = searchText.toLowerCase().replace("phc", "Primary Health Centre");

        var facilities = JSON.parse(localStorage.getItem("hfs"));
        
        for (var i = 0; i < facilities.length; i++){
          if(facilities[i].lga == userInfo[0].lga){
                var search = searchText;
                var se = new RegExp(search, "i");
            var fetch1 = facilities[i].name.search(se);
            var fetch2 = facilities[i].lga.search(se);
            if(fetch1 !== -1 || fetch2 !== -1){
                var facname = facilities[i].name;
                var facid = facilities[i].id;
                var faclga = "<p class='search-info'>" +facilities[i].lga + "</p>";

                var output = "<li><a onclick='facRepo("+facid+", \""+facname+"\", \""+facilities[i].lga+"\")'>"+facname+faclga+"</a></li>";
                $('.list-point').append(output);
                n++;
            }
            else{}
          }
        }
        $('.search-count').html("("+n+" results)");         
    })

});