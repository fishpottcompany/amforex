<?php
$active_page = "currencies";
$page_name = "Currencies";
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
                      <h4 class="card-title">Currencies</h4>
                      <p class="card-category">These are all the currencies that are set on the system. Click any list item to edit it.</p>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover">
                        <thead class="text-warning">
                          <th class="font-weight-bold">ID</th>
                          <th class="font-weight-bold">Name</th>
                          <th class="font-weight-bold">Short-Name</th>
                          <th class="font-weight-bold">Symbol</th>
                          <th class="font-weight-bold">Updated-On</th>
                          <th class="font-weight-bold">Tradable</th>
                          <th class="font-weight-bold">Administrator</th>
                        </thead>
                        <tbody>
                          @foreach($currencies as $key => $data)
                              <tr style="cursor: pointer;" class="currency" data-cid="{{$data->currency_id}}">    
                                <th style="font-weight: 5">{{$data->currency_id}}</th>
                                <th style="font-weight: 5">{{$data->currency_full_name}}</th>
                                <th style="font-weight: 5">{{$data->currency_abbreviation}}</th>
                                <th style="font-weight: 5">{{$data->currency_symbol}}</th>
                                <th style="font-weight: 5">{{$data->updated_at}}</th>  
                                <th style="font-weight: 5"><?php if($data->currency_flagged == 0){echo "Yes";} else {echo "No";} ?></th>   
                                <th style="font-weight: 5">{{$data->admin_surname}} {{$data->admin_firstname}}</th>                 
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
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
    <script src="/js/admin/currencies.js"></script>
  </body>
  </html>
@endsection