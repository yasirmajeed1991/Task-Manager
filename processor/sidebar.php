  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="dropdown">
          <a href="./" class="brand-link">

              <?php $user_type = array('',"Admin","Processor","Loan Coordinator"); ?>
              <h5 class="text-center p-0 m-0"><b><?php echo $user_type[$_SESSION['login_type']]; ?></b></h5>


          </a>

      </div>
      <div class="sidebar pb-4 mb-4">
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                  data-accordion="false">

                  <li class="nav-item">
                      <a href="./" class="nav-link nav-home">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>


                 

                  <li class="nav-item">
                      <a href="#" class="nav-link nav-edit_loan nav-edit_loan">
                          <i class="nav-icon fas fa-layer-group"></i>
                          <p>
                              Loan Details
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">


                          <li class="nav-item">
                              <a href="./index.php?page=new_loan_number" class="nav-link nav-new_loan_number tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Add New Loan No#</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="./index.php?page=loan_number_list"
                                  class="nav-link nav-loan_number_list tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Loan No List</p>
                              </a>
                          </li>


                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link nav-edit_user">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Borrowers
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="./index.php?page=new_borrower" class="nav-link nav-new_borrower tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Add New Borrower</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="./index.php?page=borrower_list" class="nav-link nav-borrower_list tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Borrower List</p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  <li class="nav-item">
                      <a href="#" class="nav-link nav-edit_loan nav-edit_loan">
                          <i class="nav-icon fas fa-layer-group"></i>
                          <p>
                              Loan Scrub Files
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="./index.php?page=new_scrub" class="nav-link nav-new_scrub tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Start New Scrub</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="./index.php?page=scrub_list" class="nav-link nav-scrub_list tree-item">
                                  <i class="fas fa-angle-right nav-icon"></i>
                                  <p>Scrub List</p>
                              </a>
                          </li>


                      </ul>

                  </li>
                 




              </ul>
          </nav>
      </div>
  </aside>
  <script>
$(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    if (s != '')
        page = page + '_' + s;
    if ($('.nav-link.nav-' + page).length > 0) {
        $('.nav-link.nav-' + page).addClass('active')
        if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
            $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
            $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
            $('.nav-link.nav-' + page).parent().addClass('menu-open')
        }

    }

})
  </script>