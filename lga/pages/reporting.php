           <div class="block-header">
                <h2>STOCK REPORTING</h2>
            </div>

            <div class="card report-stat-lga hidden">
                <div class="header">
                    <h2 class="col-deep-orange"><b>Report Statistics for <span class="repo-lga-name"></span><span class="rep-period pull-right"></span></b></h2>
                </div>
                <div class="body">
                    <div class="sort-div">
                        <button class="btn-default btn" onclick="toggleStat()">Back</button>
                    </div>
                    <div class="stat-display">
                        <p class="alert stat-total-lga" style="text-align: center"></p>
                        <table class="table table-bordered table-hover">
                            <thead style="background: #d9501e; color: whitesmoke">
                                <th style="text-align: center">S/N</th>
                                <th>Facility Name</th>
                                <th>Total products reported</th>
                                <th>Status</th>
                            </thead>
                            <tbody class="fac-reported-lga"></tbody>
                    </table>
                    </div>
                </div>
            </div>

                    <div class="card report-card">
                        <div class="header">
                            <h2 class="col-deep-orange rep-period" style="font-weight: bold;"></h2>
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
                                <div class="col-md-4">
                                    <div class="report-progress" style="text-align: centre;">
                                    <input type="text" class="knob" value="0" data-width="200" data-height="200" data-thickness="0.3" data-fgColor="#F44336" readonly>
                                    </div>
                                    <br>
                                    <div class="report-info alert"></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control fac-search" autofocus>
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