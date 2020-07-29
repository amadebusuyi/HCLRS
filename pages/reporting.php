<?php 
session_start();

if(!isset($_SESSION['user'])){
     header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>HCLRS | Health commodities logistics and reporting system</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />    

    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/custom.css">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/theme-deep-purple.css" rel="stylesheet" />
</head>

<body class="theme-deep-purple">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">HCLRS</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 new staffs added</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Facility name changed</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Wale</b> updated facilities</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Stock out
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-red" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Reporting Errors
                                                <small>5%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Reporting Rate
                                                <small>95%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Commodity drop
                                                <small>2%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Adebusuyi Adebowale</div>
                    <div class="email">heclassy@gmail.com</div>

                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" class="profile-link"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="../sign-out.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>

                    </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="/hclrs/home">
                            <i class="material-icons col-deep-purple">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                   
                    <li>
                        <a href="reporting.php" class="stock-repo">
                            <i class="material-icons col-deep-purple">border_color</i>
                            <span>Stock Reporting</span>
                        </a>
                    </li>

                    <li>
                        <a href="analytics">
                            <i class="material-icons col-deep-purple">trending_up</i>
                            <span>Analytics</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2019 - 2020 <a href="javascript:void(0);">HoopNg</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.1
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        
    </section>

    <section class="content">
        <div class="container-fluid">
           <div class="block-header">
                <h2>STOCK REPORTING</h2>
            </div>
<!-- <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
                    <div class="card">
                        <div class="header">
                            <h2 class="col-deep-purple">REPORTING PERIOD: NOVEMBER - DECEMBER, 2019</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-5" style="text-align: Centre;">
                                    <input type="text" class="knob" value="20" data-width="200" data-height="200" data-thickness="0.3" data-fgColor="#F44336"
                                       readonly>
                        
                                </div>
                                <div class="col-md-7" style="border-left: 1px solid #f6f6f6;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control fac-search">
                                            <label class="form-label label-search"><i class="glyphicon glyphicon-search"></i> Search Facility</label>                                         
                                        </div>
                                    </div>
                                    <div class="search-result">
                                        <div class="search-heading"><h4><i class="glyphicon glyphicon-search"></i> Search results <span class="search-count"></span></h4></div>
                                        <ul class="list">
                                            <div class="list-point"></div>
                                        </ul>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <!-- Jquery Knob Plugin Js -->
    <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
    <script src="../js/pages/charts/jquery-knob.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="../js/demo.js"></script>

    <script type="text/javascript">

    function facRepo(facid, facname){ 
           $.get('repo_page.php?facid='+facid+'&facname='+facname, function(data){
              $('.content .container-fluid').html(data);
            });
        }

    </script>
    <script type="text/javascript">

$(function () {

    var userInfo = JSON.parse(localStorage.getItem("logged"));
    $('.name').text(userInfo[0].lname + " "+ userInfo[0].fname);
    $('.email').text(userInfo[0].email);

    $('.knob').knob(); 

    var get = localStorage.getItem("hfs");
    if(get == "" || get == undefined){

    $.get("staffdb.php?fetch_hfs", function(data){
        //var hfs = JSON.parse(data);
        localStorage.setItem("hfs", data);
        alert("HFs stored locally");
    })         
}

var facilities = JSON.parse(localStorage.getItem("hfs"));

 
    $('.fac-search').keyup(function(e){
        e.preventDefault();
        var n = 0;
        $('.list-point').html('');
        var searchText = $(this).val();
        if(searchText.toLowerCase() == "chc"){
            searchText = "Comprehensive Health Centre";
        }
        else if(searchText.toLowerCase() == "bhc" || searchText.toLowerCase() == "phc"){
            searchText = "Basic Health Centre";
        }
        for (var i = 0; i < facilities.length + 1; i++){
                var search = searchText;
                var se = new RegExp(search, "i");
            var fetch = facilities[i].name.search(se);
            if(fetch !== -1){
                var content = facilities[i].name;
                var id = facilities[i].id;
                var lga = "<p class='search-info'>" +facilities[i].lga + "</p>";

                var output = "<li><a onclick='facRepo("+id+", \""+content+"\")'>"+content+lga+"</a></li>";
                $('.list-point').append(output);
                n++;
            }
            else{}
        $('.search-count').html("("+n+" results)");
        }         
    })


        $('.profile-link').click(function(e){
            e.preventDefault();
            $.get('profile.php', function(data){
                $('.content .container-fluid').html(data);
            })
        })

});

</script>
</body>

</html>