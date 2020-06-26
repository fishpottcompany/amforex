<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    AM
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <!-- CSS Files -->
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="stylesheet" href="/css/material-dashboard.css"/>
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="/demo/demo.css"/>
  <link rel="stylesheet" href="/css/custom.css"/>
</head>

<body class="dark-edition">
  <div class="wrapper ">

    <!-- START LEFT SIDE BAR -->
    @yield('left_side_bar')
    <!-- END LEFT SIDE BAR  -->
      
    <div class="main-panel">

      <!-- START NAVBAR -->
      @yield('navbar')
      <!-- END NAVBAR -->
      
      <!-- START MAIN CONTENT -->
      @yield('content')
      <!-- END MAIN CONTENT -->

      <!-- START FOOTER -->
      @yield('footer')
      <!-- END FOOTER -->

    </body>

</html>