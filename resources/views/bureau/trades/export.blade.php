<?php
$active_page = "trades";
$page_name = "Trades";
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
                      <h4 class="card-title">Export Trades</h4>
                      <p class="card-category">Export transactions to PDF, EXCEL</p>
                    </div>
                    <div class="card-body">
                      <div class="row" style="display: none" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <form class="navbar-form" id="exportform">
  
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="bmd-label-floating">Export From(Earliest Date)</label>
                              <input type="date" min="1"name="end_date" class="form-control" required="required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="bmd-label-floating">Export To(Latest Date)</label>
                              <input type="date" min="1" name="start_date" class="form-control" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="search_with" id="tradable_input_label">Search With</label>
                              <select name="search_with"class="form-control" id="search_with" required="required">
                                <option value="0">Trade ID</option>
                                <option value="1">Currency-In Abbreviation</option>
                                <option value="2">Currency-In Amount</option>
                                <option value="3">Currency-Out Amount</option>
                                <option value="4">Customer ID</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="export_format_type">Choose Export Format</label>
                              <select name="export_format_type" class="form-control" id="export_format_type"  required="required">
                                <option value="">Choose Export Format</option>
                                <option value="PDF">PDF</option>
                                <option value="Excel">Excel</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group no-border">
                                <input type="text" id="search_form_input" name="kw" value="" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn btn-default btn-round btn-just-icon">
                                  <i class="material-icons">search</i>
                                  <div class="ripple-container"></div>
                                </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    
                    <div class="card-body">
                      <iframe style="width: 100%; height: 500px;" src="https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf" frameborder="0"></iframe>
                    </div>
                  </div>;
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
    <script src="/js/bureau/trades.js"></script>
  </body>
  </body>
  </html>
@endsection