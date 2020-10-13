<?php
$active_page = "administrators";
$page_name = "Administrators";
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
                      <h4 class="card-title">Add An Administrator</h4>
                      <p class="card-category">Enter the needed information and priviledges of the administrator</p>
                    </div>
                    <div class="card-body">
                      <div class="row" style="display: none" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <form id="form">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Surname</label>
                          <input type="text" maxlength="55" name="admin_surname" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <p class="text-danger font-weight-bold">You have to inform the administrator that their password is their phone number and their PIN is the last 4 numbers of their phone number. Advice them to change it when they first sign in.</p>
                          
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Firstname</label>
                          <input type="text" maxlength="55" name="admin_firstname" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Othernames</label>
                          <input type="text" maxlength="55" name="admin_othernames" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Phone Number</label>
                          <input type="text" maxlength="10" name="admin_phone_number" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Email</label>
                          <input type="text" maxlength="100" name="admin_email" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin New Pin (Leave Empty If You Do Not Want To Change It)</label>
                          <input type="password" minlength="4" maxlength="8" name="new_admin_pin" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin New Password (Leave Empty If You Do Not Want To Change It)</label>
                          <input type="password" minlength="8" maxlength="30" name="password" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="admin_flagged">Flag Worker</label>
                          <select name="admin_flagged" class="form-control" id="admin_flagged"  required="required">
                            <option value="">Choose Flag Status</option>
                            <option value="1">Flag</option>
                            <option value="0">Un-Flag</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                      <p class="text-danger font-weight-bold">You should let the admin know the password and pin you set. If you left them empty, you have to inform the worker that their password is their phone number and their PIN is the last 4 numbers of their phone number. Advice them to change it when they first sign in.</p>
                      
                    </div>
                  </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="add_currency" value="add-currency"> Add Currency
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="view_currencies" value="view-currencies"> View Currencies List
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="get_one-currency" value="get-one-currency"> View One Currency
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="update_currency" value="update-currency"> Update Currency
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="add_rate" value="add-rate"> Add Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="view_rates" value="view-rates"> View Rates List
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="get_one_rate" value="get-one-rate"> View One Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="update_rate" value="update-rate"> Update Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="add_bureau" value="add-bureau"> Add Bureau
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="view_bureaus" value="view-bureaus"> View Bureaus List
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="get_one_bureau" value="get-one-bureau"> View One Bureau
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="update_bureau" value="update-bureau"> Update Bureau
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="add_admin" value="add-admin"> Add Admin
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="view_admins" value="view-admins"> View Admins
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="edit_admin" value="edit-admin"> Edit Admin
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="view_reports" value="view-reports"> View Reports
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
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

                      <span id="submit_button_form"></span>
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
    <!-- MY CUSTOM SCRIPTS FOR admin -->
    <script src="/js/admin/workers.js"></script>
    <script type="text/javascript">
      get_all_branches();
    </script>
  </body>
  </body>
  </html>
@endsection