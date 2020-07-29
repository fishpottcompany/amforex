<!-- INCLUDING THE FILE THAT HOLDS THE CORE STRUCTURE OF THE PAGE -->
<?php
$active_page = "rates";
$page_name = "Rates";
?>
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
                      <h4 class="card-title">Rates</h4>
                      <p class="card-category">These are all the rates that are set on the system. To set a new rate for a list item, simply enter your pin and set the rate in the popup that shows</p>
                    </div>
                    <div class="card-body table-responsive">

                    <form class="navbar-form" id="search_form">
                      <div class="input-group no-border">
                        <input type="text" id="search_form_input" value="" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn btn-default btn-round btn-just-icon">
                          <i class="material-icons">search</i>
                          <div class="ripple-container"></div>
                        </button>
                      </div>
                    </form>
                      <div class="row" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <table class="table table-hover" id="list_table" style="display: none;">
                        <thead class="text-warning">
                          <th class="font-weight-bold">ID</th>
                          <th class="font-weight-bold">From</th>
                          <th class="font-weight-bold">To</th>
                          <th class="font-weight-bold">Rate</th>
                          <th class="font-weight-bold">Update-On</th>
                          <th class="font-weight-bold">Administrator</th>
                          <th class="font-weight-bold">New Rate</th>
                        </thead>
                        <tbody id="table_body_list">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="offset-lg-5 col-lg-4 offset-md-5 col-md-4">
                  <a id="previous_btn" class="btn btn-default" href="<?php echo url('/'); ?>/admin/rates/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 1){echo intval($_GET["page"])-1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_left</i></a>
                  <a id="next_btn" style="display: none" class="btn btn-default" href="<?php echo url('/'); ?>/admin/rates/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"])+1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_right</i></a>
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
    <script src="/js/admin/rates.js"></script>
    <script type="text/javascript">
      get_rates_for_page('<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"]);} else {echo "1"; } ?>');
    </script>
  </body>
  </body>
  </html>
@endsection