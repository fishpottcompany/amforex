<!-- INCLUDING THE FILE THAT HOLDS THE CORE STRUCTURE OF THE PAGE -->
<?php
$active_page = "workers";
$page_name = "Workers";
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
                      <h4 class="card-title">Workers</h4>
                      <p class="card-category">These are all the workers in the bureau. To change a workers information or permissions, simply click on a lit item in the table to edit</p>
                    </div>
                    <div class="card-body table-responsive">
                      <div class="row" id="loader">
                        <div class="col-md-12 my-2 d-flex justify-content-center">
                          <div class="dot-spin"></div>
                        </div>
                      </div>
                      <table class="table table-hover" id="list_table" style="display: none;">
                        <thead class="text-warning">
                          <th class="font-weight-bold">ID</th>
                          <th class="font-weight-bold">Fullname</th>
                          <th class="font-weight-bold">Phone</th>
                          <th class="font-weight-bold">Email</th>
                          <th class="font-weight-bold">Branch</th>
                          <th class="font-weight-bold">Flagged</th>
                          <th class="font-weight-bold">Added-By</th>
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
                  <a id="previous_btn" class="btn btn-default" href="<?php echo url('/'); ?>/bureau/workers/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 1){echo intval($_GET["page"])-1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_left</i></a>
                  <a id="next_btn" style="display: none" class="btn btn-default" href="<?php echo url('/'); ?>/bureau/workers/list/?page=<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"])+1;} else {echo "1"; } ?>"><i class="material-icons">keyboard_arrow_right</i></a>
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
      get_workers_for_page('<?php if(isset($_GET["page"]) && intval($_GET["page"]) > 0){echo intval($_GET["page"]);} else {echo "1"; } ?>');
    </script>
  </body>
  </body>
  </html>
@endsection