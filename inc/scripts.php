
<!--
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  __________________________________ General Scripts ___________________________________  ______________________________________________________________________________________
                                                                                      -->
<script type="text/javascript">
  
const error_notice = "<b>Notice</b>:";
                    
const error_warning = "<b>Warning</b>:";
                    
const error_fatal = "<b>Fatal error</b>:";

const error_pdo = "exception 'PDOException'";

function xhrError($this){
  if($this.indexOf(error_fatal) > 0 || $this.indexOf(error_warning) > 0 || $this.indexOf(error_notice) > 0 || $this.indexOf(error_pdo) > 0 )
    return 404;
  else 
    return 200;
}

//____________________________------ User info scripts -------_________________________

    var userInfo = JSON.parse(localStorage.getItem("logged"));
    $('.name').text(userInfo[0].lname + " "+ userInfo[0].fname);
    $('.email').text(userInfo[0].email);

//____________________________------ fac repo scripts -------_________________________


/*
  ______________________________________________________________________________________
  ______________________________________________________________________________________
  ___________________________________ Profile Scripts __________________________________  ______________________________________________________________________________________
                                                                                        
                                                                                        */

                var userInfo = JSON.parse(localStorage.getItem("logged"));
                $('.name').text(userInfo[0].lname + " "+ userInfo[0].fname);
                $('.designation').text(userInfo[0].designation);
                $('.address').text(userInfo[0].address);
                $('.gender').text('('+userInfo[0].gender+')');
                $('.phone').text(userInfo[0].phone);
                $('.email').text(userInfo[0].email);

                if(userInfo[0].role === '3') var role = "Administrator";
                
                else if(userInfo[0].role === "2") var role = "State LMCU Officer";
                
                else if(userInfo[0].role === "1") var role = "LGA LMCU officer";
                
                else var role = "Health Facility officer";
                
                $('.role').text(role);

                if(userInfo[0].img === null) var img = '<img src="images/user.png" height="150" width="150" alt="Profile Image" />';
                else var img = '<img src="images/'+userInfo[0].img+'" height="150" width="150" alt="Profile Image" />';
                $('.image-area').html(img);

                $('#NameSurname').val(userInfo[0].lname + " "+ userInfo[0].fname);
                $('#Email').val(userInfo[0].email);
                $('#Phone').val(userInfo[0].phone);
                $('#InputAddress').val(userInfo[0].address);
  </script>