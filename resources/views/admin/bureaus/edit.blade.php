<?php
$active_page = "bureaus";
$page_name = "Bureaus";
?>
<!-- INCLUDING THE FILE THAT HOLDS THE CORE STRUCTURE OF THE PAGE -->
@extends('layouts.app')

@section('customscripts')
<!-- CONFIG AND AUTH CHECK -->
<script src="/js/admin/config.js"></script>
<script src="/js/admin/check_auth.js"></script>
@endsection()

@section('navbar')
  @include('admin.navbar')
@endsection

@section('left_side_bar')
  @include('admin.left_side_bar')
@endsection

<!-- SETTING THE CONTENT AS REQUIRED BY THE CORE STRUCTURE OF THE PAGE -->
@section('content')
    <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-header card-header-warning">
                      <h4 class="card-title">Edit Bureau</h4>
                      <p class="card-category">Edit a bureau that has been licensed to operate</p>
                    </div>
                    <div class="card-body">
                      <div class="row" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <form id="edit_bureau_form" style="display:none">
                        <div class="row">
                          <div class="col-md-12">
                          <p class="text-warning">Bureau information.</p>
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Legally Registered Name</label>
                              <input type="text" id="bureau_name" name="bureau_name" maxlength="200" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="tradable_input" id="tradable_input_label">Tradable Status</label>
                              <select name="currency_flagged"class="form-control" id="tradable_input" required="required">
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau GPS Address</label>
                              <input type="text" id="bureau_hq_gps_address" name="bureau_hq_gps_address" maxlength="50" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Address/Location</label>
                              <input type="text" id="bureau_hq_location" name="bureau_hq_location" maxlength="300" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row"  style="display: none" >
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau TIN</label>
                              <input  type="hidden" style="display: none" id="bureau_tin" name="bureau_tin" maxlength="20" class="form-control" required="required" readonly="readonly">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau License Number</label>
                              <input type="text" id="bureau_license_no" name="bureau_license_no" maxlength="20" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Business Registration Number</label>
                              <input type="text" id="bureau_registration_num" name="bureau_registration_num" maxlength="20" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Phone 1</label>
                              <input type="text" id="bureau_phone_1" name="bureau_phone_1" maxlength="10" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Phone 2</label>
                              <input type="text" id="bureau_phone_2" name="bureau_phone_2" maxlength="10" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Email 1</label>
                              <input type="text" id="bureau_email_1" name="bureau_email_1" maxlength="100" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Email 2</label>
                              <input type="text" id="bureau_email_2" name="bureau_email_2" maxlength="100" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <p class="text-warning">This is the first worker of the bureau who has all the priviledges to manage the bureau. Generally, this worker is the bureau owner or C.E.O</p>
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Surname</label>
                              <input type="text" id="worker_surname" name="worker_surname" maxlength="55" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Firstname</label>
                              <input type="text" id="worker_firstname" name="worker_firstname" maxlength="55" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Othernames</label>
                              <input type="text" id="worker_othernames" name="worker_othernames" maxlength="55" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Home GPS Address</label>
                              <input type="text" id="worker_gps_address" name="worker_gps_address" maxlength="50" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Home Address/Location</label>
                              <input type="text" id="worker_location" name="worker_location" maxlength="300" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Position(Eg: CEO, Director)</label>
                              <input type="text" id="worker_position" name="worker_position" maxlength="100" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Phone Number</label>
                              <input type="text" id="worker_phone_number" name="worker_phone_number" maxlength="10" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Email</label>
                              <input type="text" id="worker_email" name="worker_email" maxlength="100" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">PIN</label>
                              <input type="password" name="admin_pin" maxlength="10" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <span id="submit_button_holder"></span>
                        <div class="clearfix"></div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('footer');
        <footer class="footer">
          <div class="container-fluid">
            <nav class="float-left">
              <ul>
                <li>
                  <a class="copyright" id="date">
                      
                  </a>
                </li>
                <li>
                  <a>
                    AM Forex
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </footer>
        <script>
          const x = new Date().getFullYear();
          let date = document.getElementById('date');
          date.innerHTML = '&copy; ' + x + date.innerHTML;
        </script>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="/js/core/jquery.min.js"></script>
    <script src="/js/core/popper.min.js"></script>
    <script src="/js/core/bootstrap-material-design.min.js"></script>
    <script src="https://unpkg.com/default-passive-events"></script>
    <script src="/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Chartist JS -->
    <script src="/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/js/material-dashboard.js?v=2.1.0"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="/demo/demo.js"></script>
    <!-- MY CUSTOM SCRIPTS FOR ADMIN -->
    <script src="/js/admin/bureaus.js"></script>
    <script type="text/javascript">
      get_this_bureau('<?php echo intval($bureau_id); ?>');
    </script>
  </body>
  </html>
@endsection