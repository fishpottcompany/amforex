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
                      <h4 class="card-title">Add A Worker</h4>
                      <p class="card-category">Enter the needed information and priviledges of the worker</p>
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
                          <p class="text-danger font-weight-bold">You have to inform the bureau worker that their password is their phone number and their PIN is the last 4 numbers of their phone number. Advice them to change it when they first sign in.</p>
                          
                          <div class="form-group">
                            <label for="branch_id">Branch</label>
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
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option1"> Make Trade
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> View Trades
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option3"> Export Trades
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option1"> Add Currency Stock
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> View Currency Stock
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="worker_add-customer"  value="worker_add-customer"> Add Customers
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option1"> Add Rate
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> View Rates
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> Add Branches
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> Add Workers
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option1"> View Workers
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"  value="option2"> Edit Worker
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
                            <input type="password" name="worker_pin" maxlength="10" class="form-control" required="required">
                          </div>
                        </div>
                      </div>
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
      get_all_branches();
    </script>
  </body>
  </body>
  </html>
@endsection