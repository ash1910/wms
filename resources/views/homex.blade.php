<!doctype html>
<html lang="en" class="light-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="assets/css/font-roboto.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">


  <!--Theme Styles-->
  <link href="assets/css/dark-theme.css" rel="stylesheet" />
  <link href="assets/css/light-theme.css" rel="stylesheet" />
  <link href="assets/css/semi-dark.css" rel="stylesheet" />
  <link href="assets/css/header-colors.css" rel="stylesheet" />

  <title>Workshop Management System</title>
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      <header class="top-header">        
        <nav class="navbar navbar-expand">
          <div class="mobile-toggle-icon d-xl-none">
              <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar d-none d-xl-block">
            
            </div>
            
            <form class="searchbar d-none d-xl-flex ms-auto">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
                <input class="form-control" type="text" placeholder="Type here to search">
                <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>
            </form>
            <div class="top-navbar-right ms-3">
              <ul class="navbar-nav align-items-center">
              <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center gap-1">
                    <img src="assets/images/avatars/avatar-1.png" class="user-img" alt="">
                    <div class="user-name d-none d-sm-block">{{session('user');}}</div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">
                          <img src="assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="60" height="60">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">{{session('user');}}</h6>
                            <small class="mb-0 dropdown-user-designation text-secondary">{{session('role');}}</small>
                          </div>
                       </div>
                     </a>
                   </li>
                   
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="logout">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                           <div class="setting-text ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>
                </ul>
              </li>
              
              
              
              </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
              <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
              <h4 class="logo-text">WMS</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-house-door"></i>
                </div>
                <div class="menu-title">Dashboard</div>
              </a>
              <ul>
                <li> <a href="index.html"><i class="bi bi-arrow-right-short"></i>eCommerce</a>
                </li>
                <li> <a href="index2.html"><i class="bi bi-arrow-right-short"></i>Sales</a>
                </li>
                <li> <a href="index3.html"><i class="bi bi-arrow-right-short"></i>Analytics</a>
                </li>
                <li> <a href="index4.html"><i class="bi bi-arrow-right-short"></i>Project Management</a>
                </li>
                <li> <a href="index5.html"><i class="bi bi-arrow-right-short"></i>CMS Dashboard</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-grid"></i>
                </div>
                <div class="menu-title">Application</div>
              </a>
              <ul>
                <li> <a href="app-emailbox.html"><i class="bi bi-arrow-right-short"></i>Email</a>
                </li>
                <li> <a href="app-chat-box.html"><i class="bi bi-arrow-right-short"></i>Chat Box</a>
                </li>
                <li> <a href="app-file-manager.html"><i class="bi bi-arrow-right-short"></i>File Manager</a>
                </li>
                <li> <a href="app-to-do.html"><i class="bi bi-arrow-right-short"></i>Todo List</a>
                </li>
                <li> <a href="app-invoice.html"><i class="bi bi-arrow-right-short"></i>Invoice</a>
                </li>
                <li> <a href="app-fullcalender.html"><i class="bi bi-arrow-right-short"></i>Calendar</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">UI Elements</li>
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-award"></i>
                </div>
                <div class="menu-title">Widgets</div>
              </a>
              <ul>
                <li> <a href="widgets-static-widgets.html"><i class="bi bi-arrow-right-short"></i>Static Widgets</a>
                </li>
                <li> <a href="widgets-data-widgets.html"><i class="bi bi-arrow-right-short"></i>Data Widgets</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-bag-check"></i>
                </div>
                <div class="menu-title">eCommerce</div>
              </a>
              <ul>
                <li> <a href="ecommerce-products-list.html"><i class="bi bi-arrow-right-short"></i>Products List</a>
                </li>
                <li> <a href="ecommerce-products-grid.html"><i class="bi bi-arrow-right-short"></i>Products Grid</a>
                </li>
                <li> <a href="ecommerce-products-categories.html"><i class="bi bi-arrow-right-short"></i>Categories</a>
                </li>
                <li> <a href="ecommerce-orders.html"><i class="bi bi-arrow-right-short"></i>Orders</a>
                </li>
                <li> <a href="ecommerce-orders-detail.html"><i class="bi bi-arrow-right-short"></i>Order details</a>
                </li>
                <li> <a href="ecommerce-add-new-product.html"><i class="bi bi-arrow-right-short"></i>Add New Product</a>
                </li>
                <li> <a href="ecommerce-add-new-product-2.html"><i class="bi bi-arrow-right-short"></i>Add New Product 2</a>
                </li>
                <li> <a href="ecommerce-transactions.html"><i class="bi bi-arrow-right-short"></i>Transactions</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-bookmark-star"></i>
                </div>
                <div class="menu-title">Components</div>
              </a>
              <ul>
                <li> <a href="component-alerts.html"><i class="bi bi-arrow-right-short"></i>Alerts</a>
                </li>
                <li> <a href="component-accordions.html"><i class="bi bi-arrow-right-short"></i>Accordions</a>
                </li>
                <li> <a href="component-badges.html"><i class="bi bi-arrow-right-short"></i>Badges</a>
                </li>
                <li> <a href="component-buttons.html"><i class="bi bi-arrow-right-short"></i>Buttons</a>
                </li>
                <li> <a href="component-cards.html"><i class="bi bi-arrow-right-short"></i>Cards</a>
                </li>
                <li> <a href="component-carousels.html"><i class="bi bi-arrow-right-short"></i>Carousels</a>
                </li>
                <li> <a href="component-list-groups.html"><i class="bi bi-arrow-right-short"></i>List Groups</a>
                </li>
                <li> <a href="component-media-object.html"><i class="bi bi-arrow-right-short"></i>Media Objects</a>
                </li>
                <li> <a href="component-modals.html"><i class="bi bi-arrow-right-short"></i>Modals</a>
                </li>
                <li> <a href="component-navs-tabs.html"><i class="bi bi-arrow-right-short"></i>Navs & Tabs</a>
                </li>
                <li> <a href="component-navbar.html"><i class="bi bi-arrow-right-short"></i>Navbar</a>
                </li>
                <li> <a href="component-paginations.html"><i class="bi bi-arrow-right-short"></i>Pagination</a>
                </li>
                <li> <a href="component-popovers-tooltips.html"><i class="bi bi-arrow-right-short"></i>Popovers & Tooltips</a>
                </li>
                <li> <a href="component-progress-bars.html"><i class="bi bi-arrow-right-short"></i>Progress</a>
                </li>
                <li> <a href="component-spinners.html"><i class="bi bi-arrow-right-short"></i>Spinners</a>
                </li>
                <li> <a href="component-notifications.html"><i class="bi bi-arrow-right-short"></i>Notifications</a>
                </li>
                <li> <a href="component-avtars-chips.html"><i class="bi bi-arrow-right-short"></i>Avatrs & Chips</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-cloud-arrow-down"></i>
                </div>
                <div class="menu-title">Icons</div>
              </a>
              <ul>
                <li> <a href="icons-line-icons.html"><i class="bi bi-arrow-right-short"></i>Line Icons</a>
                </li>
                <li> <a href="icons-boxicons.html"><i class="bi bi-arrow-right-short"></i>Boxicons</a>
                </li>
                <li> <a href="icons-feather-icons.html"><i class="bi bi-arrow-right-short"></i>Feather Icons</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">Forms & Tables</li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-file-earmark-break"></i>
                </div>
                <div class="menu-title">Forms</div>
              </a>
              <ul>
                <li> <a href="form-elements.html"><i class="bi bi-arrow-right-short"></i>Form Elements</a>
                </li>
                <li> <a href="form-input-group.html"><i class="bi bi-arrow-right-short"></i>Input Groups</a>
                </li>
                <li> <a href="form-layouts.html"><i class="bi bi-arrow-right-short"></i>Forms Layouts</a>
                </li>
                <li> <a href="form-validations.html"><i class="bi bi-arrow-right-short"></i>Form Validation</a>
                </li>
                <li> <a href="form-wizard.html"><i class="bi bi-arrow-right-short"></i>Form Wizard</a>
                </li>
                <li> <a href="form-date-time-pickes.html"><i class="bi bi-arrow-right-short"></i>Date Pickers</a>
                </li>
                <li> <a href="form-select2.html"><i class="bi bi-arrow-right-short"></i>Select2</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-file-earmark-spreadsheet"></i>
                </div>
                <div class="menu-title">Tables</div>
              </a>
              <ul>
                <li> <a href="table-basic-table.html"><i class="bi bi-arrow-right-short"></i>Basic Table</a>
                </li>
                <li> <a href="table-advance-tables.html"><i class="bi bi-arrow-right-short"></i>Advance Tables</a>
                </li>
                <li> <a href="table-datatable.html"><i class="bi bi-arrow-right-short"></i>Data Table</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">Pages</li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-lock"></i>
                </div>
                <div class="menu-title">Authentication</div>
              </a>
              <ul>
                <li> <a href="authentication-signin.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Sign In</a>
                </li>
                <li> <a href="authentication-signup.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Sign Up</a>
                </li>
                <li> <a href="authentication-signin-with-header-footer.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Sign In with Header & Footer</a>
                </li>
                <li> <a href="authentication-signup-with-header-footer.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Sign Up with Header & Footer</a>
                </li>
                <li> <a href="authentication-forgot-password.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Forgot Password</a>
                </li>
                <li> <a href="authentication-reset-password.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Reset Password</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="pages-user-profile.html">
                <div class="parent-icon"><i class="bi bi-person-check"></i>
                </div>
                <div class="menu-title">User Profile</div>
              </a>
            </li>
            <li>
              <a href="pages-timeline.html">
                <div class="parent-icon"><i class="bi bi-collection-play"></i>
                </div>
                <div class="menu-title">Timeline</div>
              </a>
            </li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-error"></i>
                </div>
                <div class="menu-title">Errors</div>
              </a>
              <ul>
                <li> <a href="pages-errors-404-error.html" target="_blank"><i class="bi bi-arrow-right-short"></i>404 Error</a>
                </li>
                <li> <a href="pages-errors-500-error.html" target="_blank"><i class="bi bi-arrow-right-short"></i>500 Error</a>
                </li>
                <li> <a href="pages-errors-coming-soon.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Coming Soon</a>
                </li>
                <li> <a href="pages-blank-page.html" target="_blank"><i class="bi bi-arrow-right-short"></i>Blank Page</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="pages-faq.html">
                <div class="parent-icon"><i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="menu-title">FAQ</div>
              </a>
            </li>
            <li>
              <a href="pages-pricing-tables.html">
                <div class="parent-icon"><i class="bi bi-credit-card-2-front"></i>
                </div>
                <div class="menu-title">Pricing Tables</div>
              </a>
            </li>
            <li class="menu-label">Charts & Maps</li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-graph-down"></i>
                </div>
                <div class="menu-title">Charts</div>
              </a>
              <ul>
                <li> <a href="charts-apex-chart.html"><i class="bi bi-arrow-right-short"></i>Apex</a>
                </li>
                <li> <a href="charts-chartjs.html"><i class="bi bi-arrow-right-short"></i>Chartjs</a>
                </li>
                <li> <a href="charts-highcharts.html"><i class="bi bi-arrow-right-short"></i>Highcharts</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-pin-map"></i>
                </div>
                <div class="menu-title">Maps</div>
              </a>
              <ul>
                <li> <a href="map-google-maps.html"><i class="bi bi-arrow-right-short"></i>Google Maps</a>
                </li>
                <li> <a href="map-vector-maps.html"><i class="bi bi-arrow-right-short"></i>Vector Maps</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">Others</li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-list-task"></i>
                </div>
                <div class="menu-title">Menu Levels</div>
              </a>
              <ul>
                <li> <a class="has-arrow" href="javascript:;"><i class="bi bi-arrow-right-short"></i>Level One</a>
                  <ul>
                    <li> <a class="has-arrow" href="javascript:;"><i class="bi bi-arrow-right-short"></i>Level Two</a>
                      <ul>
                        <li> <a href="javascript:;"><i class="bi bi-arrow-right-short"></i>Level Three</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li>
              <a href="https://codervent.com/skodash/documentation/index.html" target="_blank">
                <div class="parent-icon"><i class="bi bi-file-earmark-code"></i>
                </div>
                <div class="menu-title">Documentation</div>
              </a>
            </li>
            <li>
              <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bi bi-headset"></i>
                </div>
                <div class="menu-title">Support</div>
              </a>
            </li>
          </ul>
          <!--end navigation-->
       </aside>
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">
              
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
              <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Total Orders</p>
                              <h4 class="my-1">4805</h4>
                              <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 5% from last week</p>
                          </div>
                          <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-basket2-fill"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Revenue</p>
                                <h4 class="my-1">$24K</h4>
                                <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 4.6 from last week</p>
                            </div>
                            <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-currency-exchange"></i>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Total Customers</p>
                              <h4 class="my-1">5.8K</h4>
                              <p class="mb-0 font-13 text-danger"><i class="bi bi-caret-down-fill"></i> 2.7 from last week</p>
                          </div>
                          <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-people-fill"></i>
                          </div>
                      </div>
                  </div>
               </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Bounce Rate</p>
                              <h4 class="my-1">38.15%</h4>
                              <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 12.2% from last week</p>
                          </div>
                          <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-bar-chart-line-fill"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
            </div><!--end row-->


            <div class="row">
              <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-body">
                     <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                          <h5 class="mb-0">Sales Figures</h5>
                        </div>
                        <div class="col">
                          <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                             <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Sales</span></div>
                             <div class="font-13"><i class="bi bi-circle-fill text-success"></i><span class="ms-2">Orders</span></div>
                          </div>
                        </div>
                     </div>
                     <div id="chart1"></div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Statistics</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                          <div class="dropdown">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="javascript:;">Action</a>
                              </li>
                              <li><a class="dropdown-item" href="javascript:;">Another action</a>
                              </li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                     </div>
                  </div>
                  <div class="card-body">
                    <div id="chart2"></div>
                  </div>
                  <ul class="list-group list-group-flush mb-0">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">New Orders<span class="badge bg-primary badge-pill">25%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Completed<span class="badge bg-orange badge-pill">65%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Pending<span class="badge bg-success badge-pill">10%</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div><!--end row-->

            <div class="row">
               <div class="col-12 col-lg-6 col-xl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Statistics</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                          <div class="dropdown">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="javascript:;">Action</a>
                              </li>
                              <li><a class="dropdown-item" href="javascript:;">Another action</a>
                              </li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                     </div>
                  </div>
                  <div class="card-body">
                    <div class="d-lg-flex align-items-center justify-content-center gap-4">
                      <div id="chart3"></div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="bi bi-circle-fill text-purple me-1"></i> Visitors: <span class="me-1">89</span></li>
                        <li class="list-group-item"><i class="bi bi-circle-fill text-info me-1"></i> Subscribers: <span class="me-1">45</span></li>
                        <li class="list-group-item"><i class="bi bi-circle-fill text-pink me-1"></i> Contributor: <span class="me-1">35</span></li>
                        <li class="list-group-item"><i class="bi bi-circle-fill text-success me-1"></i> Author: <span class="me-1">62</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col-12 col-lg-6 col-xl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-body">
                    <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Product Actions</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                           <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Views</span></div>
                           <div class="font-13"><i class="bi bi-circle-fill text-pink"></i><span class="ms-2">Clicks</span></div>
                        </div>
                      </div>
                     </div>
                      <div id="chart4"></div>
                    </div>
                  </div>
               </div>
            </div><!--end row-->


            <div class="row">
              <div class="col-12 col-lg-6 col-xl-4 d-flex">
                <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Top Categories</h5>
                     </div>
                     <div class="col">
                       <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                         <div class="dropdown">
                           <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                           </a>
                           <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="javascript:;">Action</a>
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Another action</a>
                             </li>
                             <li>
                               <hr class="dropdown-divider">
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                             </li>
                           </ul>
                         </div>
                       </div>
                     </div>
                    </div>
                 </div>
                  <div class="card-body">
                    <div class="categories">
                       <div class="progress-wrapper">
                         <p class="mb-2">Electronic <span class="float-end">85%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-purple" role="progressbar" style="width: 85%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Furniture <span class="float-end">70%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 70%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Fashion <span class="float-end">66%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 66%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Mobiles <span class="float-end">76%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 76%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Accessories <span class="float-end">80%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 80%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Watches <span class="float-end">65%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-voilet" role="progressbar" style="width: 65%;"></div>
                         </div>
                       </div>
                       <div class="my-3 border-top"></div>
                       <div class="progress-wrapper">
                         <p class="mb-2">Sports <span class="float-end">45%</span></p>
                         <div class="progress" style="height: 6px;">
                           <div class="progress-bar bg-gradient-royal" role="progressbar" style="width: 45%;"></div>
                         </div>
                       </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-4 d-flex">
               <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Best Products</h5>
                     </div>
                     <div class="col">
                       <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                         <div class="dropdown">
                           <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                           </a>
                           <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="javascript:;">Action</a>
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Another action</a>
                             </li>
                             <li>
                               <hr class="dropdown-divider">
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                             </li>
                           </ul>
                         </div>
                       </div>
                     </div>
                    </div>
                 </div>
                 <div class="card-body p-0">
                    <div class="best-product p-2 mb-3">
                      <div class="best-product-item">
                        <div class="d-flex align-items-center gap-3">
                          <div class="product-box border">
                             <img src="assets/images/products/01.png" alt="">
                          </div>
                          <div class="product-info">
                            <h6 class="product-name mb-1">White Polo T-Shirt</h6>
                            <div class="product-rating mb-0">
                             <i class="bi bi-star-fill text-warning"></i>
                             <i class="bi bi-star-fill text-warning"></i>
                             <i class="bi bi-star-fill text-warning"></i>
                             <i class="bi bi-star-fill text-warning"></i>
                             <i class="bi bi-star-fill text-warning"></i>
                            </div>
                          </div>
                          <div class="sales-count ms-auto">
                            <p class="mb-0">245 Sales</p>
                          </div>
                        </div>
                      </div>
                      <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/02.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Formal Coat Pant</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">325 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/03.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Blue Shade Jeans</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">189 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/04.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Yellow Winter Jacket</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">102 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/05.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Men Sports Shoes</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">137 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/06.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Fancy Home Sofa</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">453 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/07.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Sports Time Watch</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">198 Sales</p>
                         </div>
                       </div>
                     </div>
                     <div class="best-product-item">
                       <div class="d-flex align-items-center gap-3">
                         <div class="product-box border">
                            <img src="assets/images/products/08.png" alt="">
                         </div>
                         <div class="product-info">
                           <h6 class="product-name mb-1">Women Blue Heals</h6>
                           <div class="product-rating mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                           </div>
                         </div>
                         <div class="sales-count ms-auto">
                           <p class="mb-0">98 Sales</p>
                         </div>
                       </div>
                     </div>
                    </div>
                 </div>
               </div>
             </div>
             <div class="col-12 col-lg-12 col-xl-4 d-flex">
               <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Top Sellers</h5>
                     </div>
                     <div class="col">
                       <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                         <div class="dropdown">
                           <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                           </a>
                           <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="javascript:;">Action</a>
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Another action</a>
                             </li>
                             <li>
                               <hr class="dropdown-divider">
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                             </li>
                           </ul>
                         </div>
                       </div>
                     </div>
                    </div>
                 </div>
                 <div class="top-sellers-list p-2 mb-3">
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                      <img src="assets/images/avatars/avatar-1.png" class="rounded-circle" width="50" height="50" alt="">
                      <div>
                        <h6 class="mb-1">Thomas Hardy</h6>
                        <p class="mb-0 font-13">Customer ID #84586</p>
                      </div>
                       <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                         <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                       </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-2.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Pauline Bird</h6>
                       <p class="mb-0 font-13">Customer ID #86572</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-3.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Ralph Alva</h6>
                       <p class="mb-0 font-13">Customer ID #98657</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">4.8 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-4.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">John Roman</h6>
                       <p class="mb-0 font-13">Customer ID #78542</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">4.7 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-5.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">David Buckley</h6>
                       <p class="mb-0 font-13">Customer ID #68574</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-6.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Maria Anders</h6>
                       <p class="mb-0 font-13">Customer ID #86952</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">4.8 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-7.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Martin Loother</h6>
                       <p class="mb-0 font-13">Customer ID #83247</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-8.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Victoria Hardy</h6>
                       <p class="mb-0 font-13">Customer ID #67523</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">3.9 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-9.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">David Buckley</h6>
                       <p class="mb-0 font-13">Customer ID #94256</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">3.5 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                   <div class="d-flex align-items-center gap-3 sellers-list-item">
                     <img src="assets/images/avatars/avatar-10.png" class="rounded-circle" width="50" height="50" alt="">
                     <div>
                       <h6 class="mb-0">Victoria Hardy</h6>
                       <p class="mb-0 font-13">Customer ID #48759</p>
                     </div>
                     <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                       <p class="mb-0">3.4 <i class="bi bi-star-half text-warning"></i></p>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div><!--end row-->
            
            <div class="card radius-10">
               <div class="card-body">
                 <div class="row g-3">
                   <div class="col-12 col-lg-4 col-xl-4 d-flex">
                    <div class="card mb-0 radius-10 border shadow-none w-100">
                      <div class="card-body">
                        <h5 class="card-title">Top Sales Locations</h5>
                        <h4 class="mt-4">$36.2K <i class="flag-icon flag-icon-us rounded"></i></h4>
                        <p class="mb-0 text-secondary font-13">Our Most Customers in US</p>
                        <ul class="list-group list-group-flush mt-3">
                          <li class="list-group-item border-top">
                            <div class="d-flex align-items-center gap-2">
                               <div><i class="flag-icon flag-icon-us"></i></div>
                               <div>United States</div>
                               <div class="ms-auto">289</div>
                            </div>
                          </li>
                          <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-au"></i></div>
                              <div>Malaysia</div>
                              <div class="ms-auto">562</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-in"></i></div>
                              <div>India</div>
                              <div class="ms-auto">354</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-ca"></i></div>
                              <div>Indonesia</div>
                              <div class="ms-auto">147</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-ad"></i></div>
                              <div>Turkey</div>
                              <div class="ms-auto">652</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-cu"></i></div>
                              <div>Netherlands</div>
                              <div class="ms-auto">287</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-is"></i></div>
                              <div>Italy</div>
                              <div class="ms-auto">634</div>
                           </div>
                         </li>
                         <li class="list-group-item">
                           <div class="d-flex align-items-center gap-2">
                              <div><i class="flag-icon flag-icon-ge"></i></div>
                              <div>Canada</div>
                              <div class="ms-auto">524</div>
                           </div>
                         </li>
                        </ul>
                      </div>
                    </div>
                   </div>
                   <div class="col-12 col-lg-8 col-xl-8 d-flex">
                    <div class="card mb-0 radius-10 border shadow-none w-100">
                      <div class="card-body">
                        <div class="" id="geographic-map"></div>
                       </div>
                      </div>
                  </div>
                 </div><!--end row-->
               </div>
            </div>

            <div class="card radius-10">
              <div class="card-header bg-transparent">
                <div class="row g-3 align-items-center">
                  <div class="col">
                    <h5 class="mb-0">Recent Orders</h5>
                  </div>
                  <div class="col">
                    <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                      <div class="dropdown">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;">Action</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Another action</a>
                          </li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th>#ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>#89742</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/11.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Smart Mobile Phone</h6>
                            </div>
                          </div>
                        </td>
                        <td>2</td>
                        <td>$214</td>
                        <td>Apr 8, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#68570</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/07.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Sports Time Watch</h6>
                            </div>
                          </div>
                        </td>
                        <td>1</td>
                        <td>$185</td>
                        <td>Apr 9, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#38567</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/17.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Women Red Heals</h6>
                            </div>
                          </div>
                        </td>
                        <td>3</td>
                        <td>$356</td>
                        <td>Apr 10, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#48572</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/04.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Yellow Winter Jacket</h6>
                            </div>
                          </div>
                        </td>
                        <td>1</td>
                        <td>$149</td>
                        <td>Apr 11, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#96857</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/10.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Orange Micro Headphone</h6>
                            </div>
                          </div>
                        </td>
                        <td>2</td>
                        <td>$199</td>
                        <td>Apr 15, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#68527</td>
                        <td>
                          <div class="d-flex align-items-center gap-3">
                            <div class="product-box border">
                               <img src="assets/images/products/05.png" alt="">
                            </div>
                            <div class="product-info">
                              <h6 class="product-name mb-1">Men Sports Shoes Nike</h6>
                            </div>
                          </div>
                        </td>
                        <td>1</td>
                        <td>$124</td>
                        <td>Apr 22, 2021</td>
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            
          </main>
       <!--end page main-->

       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
       <!--End Back To Top Button-->

       <!--start switcher-->
       <div class="switcher-body">
        <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="bi bi-paint-bucket me-0"></i></button>
        <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
          </div>
          <div class="offcanvas-body">
            <h6 class="mb-0">Theme Variation</h6>
            <hr>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme" value="option1" checked>
              <label class="form-check-label" for="LightTheme">Light</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme" value="option2">
              <label class="form-check-label" for="DarkTheme">Dark</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDarkTheme" value="option3">
              <label class="form-check-label" for="SemiDarkTheme">Semi Dark</label>
            </div>
            <hr>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="MinimalTheme" value="option3">
              <label class="form-check-label" for="MinimalTheme">Minimal Theme</label>
            </div>
            <hr/>
            <h6 class="mb-0">Header Colors</h6>
            <hr/>
            <div class="header-colors-indigators">
              <div class="row row-cols-auto g-3">
                <div class="col">
                  <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
       <!--end switcher-->

  </div>
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="assets/plugins/easyPieChart/jquery.easypiechart.js"></script>
  <script src="assets/plugins/peity/jquery.peity.min.js"></script>
  <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="assets/js/pace.min.js"></script>
  <script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <!--app-->
  <script src="assets/js/app.js"></script>
  <script src="assets/js/index.js"></script>

  <script>
     new PerfectScrollbar(".best-product")
     new PerfectScrollbar(".top-sellers-list")
  </script>

</body>

</html>