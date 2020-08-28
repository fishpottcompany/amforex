<!-- INCLUDING THE FILE THAT HOLDS THE CORE STRUCTURE OF THE PAGE -->
<?php
$active_page = "transactions";
$page_name = "Transactions";
?>
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
                      <h4 class="card-title">Transactions</h4>
                      <p class="card-category">The table below shows all the stock of currencies.</p>
                    </div>
                    <div class="card-body table-responsive">

                    <form class="navbar-form" id="search_form">

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Search From</label>
                            <input type="date" min="1"name="currency_in_amount" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Search To</label>
                            <input type="date" min="1" name="currency_in_amount" class="form-control" required="required">
                          </div>
                        </div>
                      </div>
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
                          <th class="font-weight-bold">Currency-In</th>
                          <th class="font-weight-bold">Amt-In</th>
                          <th class="font-weight-bold">Currency-Out</th>
                          <th class="font-weight-bold">Amt-Paid-Out</th>
                          <th class="font-weight-bold">Date</th>
                          <th class="font-weight-bold">Worker Name</th>
                          <!--<th class="font-weight-bold">Edit</th>-->
                        </thead>
                        <tbody id="table_body_list">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="offset-lg-5 col-lg-4 offset-md-5 col-md-4" id="pagination_buttons">
                  <a id="previous_btn" class="btn btn-default" href="<?php echo url('/'); ?>/bureau/transactions/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 1){echo intval($_GET["page"])-1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_left</i></a>
                  <a id="next_btn" style="display: none" class="btn btn-default" href="<?php echo url('/'); ?>/bureau/transactions/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"])+1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_right</i></a>
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
    <script type="text/javascript">
      get_trades_for_page('<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"]);} else {echo "1"; } ?>');
    </script>
  </body>
  </body>
  </html>
@endsection