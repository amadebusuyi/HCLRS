<div class="card">
                        <div class="header">
                            <h2 class="col-deep-purple" style="text-align: left;">Health Facilities </h2>
                             
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

                             <span class="st-loader pull-right" style="position: absolute; right: 50px; top: 20px;">Load</span>
                        </div>
                        <div class="body">
                            <style type="text/css">
    .add-button{
      margin-bottom: 20px;
      margin-top: -20px;
    }
  </style>
  <div class="add-button"><button type="button" class="btn bg-grey m-t-15 waves-effect" data-toggle="modal" data-target="#addOfficer"><i class="glyphicon glyphicon-plus"></i> Add Health facility</button></div>

                            <div class="table-responsive table-hfs">
                            
                            </div>
          A                </div>
                 <div class="modal fade" id="edit-fac-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="edit-fac-label">Edit facility information</h3>
                        </div>
                        <div class="modal-body">
                            <form>
                              <div class="row clearfix">
                                <div class="col-sm-6">
                                <label for="fac_name">Facility Name: </label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="fac_name" class="form-control" placeholder="Enter your email address">
                                    </div>
                                </div>
                              </div>
                                <div class="col-sm-6">
                                <label for="fac_lga">Facility LGA: </label>
                                <div class="form-line">
                                    <select class="form-control show-tick" name="lga" id="fac_lga" placeholder="LGA" required>
                                          <option value="">Select LGA</option>
                                          <option value="Akoko North East">Akoko North East</option>
                                          <option value="Akoko North West">Akoko North West</option>
                                          <option value="Akoko South East">Akoko South East</option>
                                          <option value="Akoko South West">Akoko South West</option>
                                          <option value="Akure North">Akure North</option>
                                          <option value="Akure South">Akure South</option>
                                          <option value="Ese Odo">Ese Odo</option>
                                          <option value="Idanre">Idanre</option>
                                          <option value="Ifedore">Ifedore</option>
                                          <option value="Ilaje">Ilaje</option>
                                          <option value="Ile-Oluji-Okeigbo">Ile-Oluji-Okeigbo</option>
                                          <option value="Irele">Irele</option>
                                          <option value="Odigbo">Odigbo</option>
                                          <option value="Okitipupa">Okitipupa</option>
                                          <option value="Ondo East">Ondo East</option>
                                          <option value="Ondo West">Ondo West</option>
                                          <option value="Ose">Ose</option>
                                          <option value="Owo">Owo</option>
                                        </select>   
                                  </div>
                                </div>
                              </div>
                              <div class="row clearfix">
                              <hr>
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="lname"  id="lname" placeholder="Surname of OIC" required>
                                    </div>
                                </div>
                              </div>
                                
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First name of OIC" required>
                                    </div>
                                </div>
                              </div>
                            </div>
                                
                            <div class="row clearfix">

                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="phone" class="form-control" name="phone" id="phone" placeholder="Phone number" required>                                        
                                    </div>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="radio" name="gender" id="male" value="male" class="with-gap">
                                    <label for="male">Male</label>

                                    <input type="radio" name="gender" id="female" value="female" class="with-gap">
                                    <label for="female" class="m-l-20">Female</label>
                                </div>
                              </div>

                            </div>
                            </form>
                        </div>
                        <div class="modal-footer" style="background:#d9501e;">
                            <button type="button" class="btn btn-default waves-effect fac-edit-save">SAVE CHANGES</button>
                            <button type="button" class="btn btn-warning waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>

               <div class="modal fade" id="addOfficer" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                            <form id="add_staff_form" name="add_hf" action="pages/hfdb.php" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Add new Facility</h4>
                        </div>
                        <div class="modal-body">
                          <p class="add_staff_log"></p>

                            <div class="row clearfix">
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="lname"  id="lname" placeholder="Surname of OIC" required>
                                    </div>
                                </div>
                              </div>
                                
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First name of OIC" required>
                                    </div>
                                </div>
                              </div>
                            </div>
                                
                            <div class="row clearfix">

                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="phone" class="form-control" name="phone" id="phone" placeholder="Phone number" required>                                        
                                    </div>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="radio" name="gender" id="male" value="male" class="with-gap">
                                    <label for="male">Male</label>

                                    <input type="radio" name="gender" id="female" value="female" class="with-gap">
                                    <label for="female" class="m-l-20">Female</label>
                                </div>
                              </div>

                            </div>

                            <div class="row clearfix">
                              <hr>
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fac-name" id="fac-name" placeholder="Facility Name" required>
                                    </div>
                                </div>
                              </div>

                                
                              <div class="col-sm-6">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="lga" id="lga" placeholder="LGA" required>
                                          <option value="">Select LGA</option>
                                          <option value="Akoko North East">Akoko North East</option>
                                          <option value="Akoko North West">Akoko North West</option>
                                          <option value="Akoko South East">Akoko South East</option>
                                          <option value="Akoko South West">Akoko South West</option>
                                          <option value="Akure North">Akure North</option>
                                          <option value="Akure South">Akure South</option>
                                          <option value="Ese Odo">Ese Odo</option>
                                          <option value="Idanre">Idanre</option>
                                          <option value="Ifedore">Ifedore</option>
                                          <option value="Ilaje">Ilaje</option>
                                          <option value="Ile-oluji/Okeigbo">Ile-Oluji/Okeigbo</option>
                                          <option value="Irele">Irele</option>
                                          <option value="Odigbo">Odigbo</option>
                                          <option value="Okitipupa">Okitipupa</option>
                                          <option value="Ondo East">Ondo East</option>
                                          <option value="Ondo West">Ondo West</option>
                                          <option value="Ose">Ose</option>
                                          <option value="Owo">Owo</option>
                                        </select>   
                                  </div>
                              </div>
                            </div>

                            <!-- <div class="row clearfix">
                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                                        
                                    </div>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" required>
                                    </div>
                                </div>
                              </div>
                            </div> -->

                            <!-- <div class="row clearfix"> -->
                            <!--  <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="image" id="image" placeholder="Upload an image">
                                    </div>
                                </div>
                              </div> -->

                             <!--  <div class="col-sm-6">
                                  <select class="form-control" name="role" id="role" placeholder="LGA" required>
                                    <option value="">Select category/level</option>
                                    <option value="0">Facility level</option>
                                    <option value="1">LGA level</option>
                                    <option value="2">State Level</option>
                                    <option value="3">Administrator</option>
                                  </select> 
                              </div>
                            </div> -->

                      <!--          <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox">I have read and accept the terms</label>
                                </div> -->
                 <!--               <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button> -->
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer bg-grey">
                            <button type="submit" name="addStaff" class="btn bg-deep-orange waves-effect add-officer">SAVE CHANGES</button>
                            <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
