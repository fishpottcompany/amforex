<?php
$active_page = "workers";
$page_name = "Workers";
?>
<!-- INCLUDING THE FILE THAT HOLDS THE CORE STRUCTURE OF THE PAGE -->
@extends('layouts.app')

@section('customscripts')
<!-- CONFIG AND AUTH CHECK -->
<script src="/js/bureau/config.js"></script>
<script src="/js/bureau/check_auth.js"></script>
@endsection()

@section('navbar')
  @include('bureau.navbar')
@endsection

@section('left_side_bar')
  @include('bureau.left_side_bar')
@endsection

<!-- SETTING THE CONTENT AS REQUIRED BY THE CORE STRUCTURE OF THE PAGE -->
@section('content')
    <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-header card-header-warning">
                      <h4 class="card-title">Update Worker</h4>
                      <p class="card-category">Enter the needed update information and priviledges of the worker</p>
                    </div>
                    <div class="card-body">
                      <div class="row" style="display: none" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <form id="form" style="display: none;">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="text-danger font-weight-bold">You have to inform the bureau worker that their password is their phone number and their PIN is the last 4 numbers of their phone number. Advice them to change it when they first sign in.</p>
                          
                          <div class="form-group">
                            <label for="branch_id">Branch<span id="branch_name_label"></span></label>
                            <select name="branch_id" class="form-control" id="branch_id"  required="required">
                              <option value="">Choose Branch</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Surname</label>
                          <input type="text" maxlength="55" id="worker_surname" name="worker_surname" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Firstname</label>
                          <input type="text" maxlength="55" id="worker_firstname" name="worker_firstname" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Othernames</label>
                          <input type="text" maxlength="55" id="worker_othernames" name="worker_othernames" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Home GPS Address</label>
                          <input type="text" maxlength="50" id="worker_home_gps_address" name="worker_gps_address" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Home Address/Location</label>
                          <input type="text" maxlength="300" id="worker_home_location" name="worker_location" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Position(Eg: CEO, Director)</label>
                          <input type="text" maxlength="100" id="worker_position" name="worker_position" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row" style="display: none;">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Phone Number</label>
                          <input type="text" maxlength="10" id="worker_phone_number" name="worker_phone_number" readonly="readonly" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker Email</label>
                          <input type="text" maxlength="100" id="worker_email" name="worker_email" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker New Pin (Leave Empty If You Do Not Want To Change It)</label>
                          <input type="password" minlength="4" maxlength="8" id="notset" name="new_worker_pin" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bureau Worker New Password (Leave Empty If You Do Not Want To Change It)</label>
                          <input type="password" minlength="8" maxlength="30" id="notset" name="password" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="worker_flagged">Flag Worker<span id="worker_flagged_label"></span></label>
                          <select id="notset" name="worker_flagged" class="form-control" id="worker_flagged"  required="required">
                            <option value="">Choose Flag Status</option>
                            <option value="1">Flag</option>
                            <option value="0">Un-Flag</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                      <p class="text-danger font-weight-bold">You should let the worker know the password and pin you set. If you left them empty, you have to inform the worker that their password is their phone number and their PIN is the last 4 numbers of their phone number. Advice them to change it when they first sign in.</p>
                      
                    </div>
                  </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_customer" value="worker_add-customer"> Add Customer
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_customers" value="worker_view-customers"> View Customers' List
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_get_one_customer" value="worker_get-one-customer"> View One Customer
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_rate" value="worker_add-rate"> Add Rate
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
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_rates" value="worker_view-rates"> View Rates
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_get_one_rate" value="worker_get-one-rate"> View One Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_update_rate" value="worker_update-rate"> Update Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_stock" value="worker_add-stock"> Add Currency Stock
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
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_stocks" value="worker_view-stocks"> View Currencies' Stock
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_trade" value="worker_add-trade"> Make Trades
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <!--
                        <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_edit-trade" value="worker_edit-trade"> View Currency Stock
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      -->
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_trades" value="worker_view-trades"> View Trades
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
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_branch" value="worker_add-branch"> Add Branch
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_branches" value="worker_view-branches"> View Branches
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_add_worker" value="worker_add-worker"> Add Worker
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
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_edit_worker" value="worker_edit-worker"> Edit Worker
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_currencies" value="worker_view-currencies"> View Currencies
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="notset" name="worker_view_workers" value="worker_view-workers"> View Workers
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
                            <input type="password" id="notset" name="worker_pin" maxlength="10" class="form-control" required="required">
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
    <!-- MY CUSTOM SCRIPTS FOR bureau -->
    <script src="/js/bureau/workers.js"></script>
    <script type="text/javascript">
      get_this_worker('<?php echo intval($worker_id); ?>');
    </script>
  </body>
  </body>
  </html>
@endsection