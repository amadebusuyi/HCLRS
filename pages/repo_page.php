<?php 

if(isset($_GET['facid'])){
	$facid = $_GET['facid'];	
	$facname = $_GET['facname'];

	echo '<div class="card">
                    <div class="card">
                        <div class="header">
                            <h2 class="col-deep-purple">'.$facname.' ('.$facid.')</h2>
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
                        <div class="body fac-repo">
                            <div class="row">
                            <div class="col-md-5"
                            	<ul>
                            	<li>Arthemeter/Lumefantrine</li>
                            	<li>Sulphadoxine/Lumefantrine</li>
                            	</ul>
                            </div>
                    </div>
                </div>
            </div>';
}

 ?>