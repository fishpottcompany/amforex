@extends('layouts.app')
@section('customscripts')
  <!-- CONFIG AND AUTH CHECK -->
  <script src="/js/admin/config.js"></script>
  <script src="/js/admin/check_auth_pc_pg.js"></script>
@endsection()
@section('content')
<!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-warning text-center">
                  <h4 class="card-title font-weight-bold">PASSCODE</h4>
                  
                  <p class="text-center">Enter the verification code sent to your email. Check your SPAM also</p>
                </div>
                <div class="card-body">
                  <div class="row" style="display: none" id="loader">
                    <div class="col-md-12 my-2 d-flex justify-content-center">
                      <div class="dot-spin"></div>
                    </div>
                  </div>
                  <form id="otpform">
                    <div class="row">
                      <div class="offset-md-2 col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Passcode</label>
                          <input type="text" name="passcode" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="offset-md-2 col-md-8">
                        <button type="submit" class="btn btn-block btn-primary">Verify</button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="offset-md-2 col-md-8 my-2">
                        <p id="resendurl" class="text-center" style="cursor: pointer;">Resend Passcode</p>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection()

@section('footer')
      <footer class="footer">
        <div class="container-fluid">
            
          </div>
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
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/js/material-dashboard.js?v=2.1.0"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="/demo/demo.js"></script>
  <!-- MY CUSTOM SCRIPTS FOR ADMIN -->
  <script src="/js/admin/ps_verify.js"></script>
@endsection