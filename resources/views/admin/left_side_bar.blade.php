    <div class="sidebar" data-color="purple" data-background-color="black" data-image="/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          AM Forex
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item <?php if(isset($active_page) && $active_page == ''){ echo 'active'; } ?>">
            <a class="nav-link" href="./user.html">
              <i class="material-icons"></i>
              <p></p>
            </a>
          </li>
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'rates'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">rate_review</i>
              <p>Rates</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/rates/list">View Rates</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/rates/add">Add/Update Rate</a>
            </div>
          </li>
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'bureaus'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">business</i>
              <p>Bureaus</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/bureaus/list">View Bureaus</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/bureaus/add">Add Bureau</a>
            </div>
          </li>
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'transactions'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">wysiwyg</i>
              <p>Transactions</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/rates/list">View All</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/rates/list">Search</a>
            </div>
          </li>
          <!--
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'receipts'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">receipt</i>
              <p>Receipts</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/rates/list">View All</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/rates/list">Search</a>
            </div>
          </li>
        </li>
        -->
        <li class="nav-item dropdown  <?php if(isset($active_page) && $active_page == 'reports'){ echo 'active'; } ?>">
          <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">library_books</i>
            <p>Reports</p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/rates/list">View All</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/rates/list">Search</a>
          </div>
        </li>
        <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'currencies'){ echo 'active'; } ?>">
          <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">monetization_on</i>
            <p>Currencies</p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/currencies/list">View Currencies</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/currencies/add">Add Currency</a>
          </div>
        </li>
        <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'administrators'){ echo 'active'; } ?>">
          <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">admin_panel_settings</i>
            <p>Administrators</p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/admin/admins/list">View Admins</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/admins/add">Add Admin</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/admin/admins/edit">Edit Admin</a>
          </div>
        </li>
        <li class="nav-item <?php if(isset($active_page) && $active_page == 'security'){ echo 'active'; } ?>">
          <a class="nav-link" href="<?php echo url('/'); ?>/admin/security/change">
            <i class="material-icons">security</i>
            <p>Change Password</p>
          </a>
        </li>
        </ul>
      </div>
    </div>
