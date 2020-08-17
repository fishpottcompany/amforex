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
                      <h4 class="card-title">Add Bureau</h4>
                      <p class="card-category">Add a bureau that has been licensed to operate</p>
                    </div>
                    <div class="card-body">
                      <div class="row" style="display: none" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <form id="add_bureau_form">
                        <div class="row">
                          <div class="col-md-12">
                          <p class="text-warning">Enter the needed information of the bureau.</p>
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Legally Registered Name</label>
                              <input type="text" name="bureau_name" maxlength="200" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau GPS Address</label>
                              <input type="text" maxlength="50" name="bureau_hq_gps_address" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Address/Location</label>
                              <input type="text" maxlength="300" name="bureau_hq_location" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau TIN</label>
                              <input type="text" maxlength="20" name="bureau_tin" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau License Number</label>
                              <input type="text" maxlength="20" name="bureau_license_no" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Business Registration Number</label>
                              <input type="text" maxlength="20" name="bureau_registration_num" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Phone 1</label>
                              <input type="text" maxlength="10" name="bureau_phone_1" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Phone 2</label>
                              <input type="text" maxlength="10" name="bureau_phone_2" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Email 1</label>
                              <input type="text" maxlength="100" name="bureau_email_1" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Contact Email 2</label>
                              <input type="text" maxlength="100" name="bureau_email_2" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <p class="text-warning">Enter a bureau worker's needed information. This worker will have the priviledges to add other workers and manage the bureau. Generally, this worker should be the bureau owner or C.E.O</p>
                            <p class="text-danger font-weight-bold">You have to inform the bureau worker that their password is the business TIN and their PIN is the last 4 numbers of the bureau tin. Advice them to change it when they first sign in.</p>
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Surname</label>
                              <input type="text" maxlength="55" name="worker_surname" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Firstname</label>
                              <input type="text" maxlength="55" name="worker_firstname" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Othernames</label>
                              <input type="text" maxlength="55" name="worker_othernames" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Home GPS Address</label>
                              <input type="text" maxlength="50" name="worker_gps_address" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Home Address/Location</label>
                              <input type="text" maxlength="300" name="worker_location" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Position(Eg: CEO, Director)</label>
                              <input type="text" maxlength="100" name="worker_position" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Phone Number</label>
                              <input type="text" maxlength="10" name="worker_phone_number" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Bureau Worker Email</label>
                              <input type="text" maxlength="100" name="worker_email" class="form-control" >
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
                        <button type="submit" class="btn btn-primary pull-right">Add</button>
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
  </body>
  </html>
@endsection