    <div class="sidebar" data-color="purple" data-background-color="black" data-image="/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a class="simple-text logo-normal">
          AM Forex
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item <?php if(isset($active_page) && $active_page == 'trades'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('/'); ?>/bureau/trades/add">
              <i class="material-icons">swap_vertical_circle</i>
              <p>Make A Trade</p>
            </a>
          </li>
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'stocks'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">source</i>
              <p>Currencies Stock</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/stocks/list">View Stocks</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/stocks/add">Add/Update Stocks</a>
            </div>
          </li>  
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'rates'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">rate_review</i>
              <p>Rates</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/rates/list">View Rates</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/rates/add">Add/Update Rate</a>
            </div>
          </li>   
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'transactions'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">wysiwyg</i>
              <p>Transactions</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/transactions/list">Search</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/transactions/export">Export</a>
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/transactions/import">Import</a>
            </div>
          </li>       
          <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'customers'){ echo 'active'; } ?>">
            <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">supervised_user_circle</i>
              <p>Customers</p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <!--
                <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/bureau/customers/list">View Customers</a>
              -->
              <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/customers/add">Add Customer</a>
            </div>
          </li>
        <li class="nav-item dropdown <?php if(isset($active_page) && $active_page == 'administrators'){ echo 'active'; } ?>">
          <a class="nav-link" href="javscript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">admin_panel_settings</i>
            <p>Workers</p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-dark mt-0" href="<?php echo url('/'); ?>/bureau/rates/list">View Admins</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/rates/list">Add Admin</a>
            <a class="dropdown-item text-dark my-0" href="<?php echo url('/'); ?>/bureau/rates/list">Edit Admin</a>
          </div>
        </li>
        </ul>
      </div>
    </div>
