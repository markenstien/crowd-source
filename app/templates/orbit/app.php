<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo APP_NAME?></title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?php echo _vendor('images/favicon.ico')?>">
    <!-- Start css -->
    <link href="<?php echo _vendor('plugins/switchery/switchery.min.css')?>" rel="stylesheet">
    <link href="<?php echo _vendor('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/icons.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/flag-icon.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/style.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _public('css/main/global.css')?>" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo _vendor('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/icons.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/flag-icon.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/style.css')?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo _vendor('plugins/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo _vendor('plugins/datatables/buttons.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
    <!-- Responsive Datatable css -->
    <link href="<?php echo _vendor('plugins/datatables/responsive.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
    <?php dtHead()?>

    <?php produce('headers')?>
</head>
<body class="vertical-layout">
    <!-- Start Infobar Setting Sidebar -->
    <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
        <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
            <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close">
                <img src="<?php echo _vendor('images/svg-icon/close.svg')?>" class="img-fluid menu-hamburger-close" alt="close"></a>
        </div>
        <div class="infobar-settings-sidebar-body">
            <div class="custom-mode-setting">
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Payment Reminders</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-first" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Stock Updates</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-second" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Open for New Products</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-third" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Enable SMS</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Newsletter Subscription</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Show Map</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-sixth" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">e-Statement</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-8"><h6 class="mb-0">Monthly Report</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <div class="leftbar">
            <!-- Start Sidebar -->
            <div class="sidebar">
                <!-- Start Logobar -->
                <div class="logobar">
                    <a href="catalog.php" class="logo logo-large"><img src="<?php echo _public('logo_regular.png')?>" class="img-fluid" alt="logo"></a>
                    <a href="catalog.php" class="logo logo-small"><img src="<?php echo _public('logo_regular.png')?>" class="img-fluid" alt="logo"></a>
                </div>
                <!-- End Logobar -->
                <!-- Start Navigationbar -->
                <?php loadSidebar()?>

                <!-- End Navigationbar -->
            </div>
            <!-- End Sidebar -->
        </div>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="index.html" class="mobile-logo"><img src="<?php echo _vendor('images/logo.svg')?>" class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="javascript:void();">
                                            <img src="<?php echo _vendor('images/svg-icon/horizontal.svg')?>" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                            <img src="<?php echo _vendor('images/svg-icon/verticle.svg')?>" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <img src="<?php echo _vendor('images/svg-icon/collapse.svg')?>" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="<?php echo _vendor('images/svg-icon/close.svg')?>" class="img-fluid menu-hamburger-close" alt="close">
                                         </a>
                                     </div>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Topbar -->
            <div class="topbar">
                <!-- Start row -->
                <div class="row align-items-center">
                    <!-- Start col -->
                    <div class="col-md-12 align-self-center">
                        <div class="infobar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="notifybar">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo _vendor('images/svg-icon/notifications.svg')?>" class="img-fluid" alt="notifications">
                                            <span class="live-icon"></span></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                                <div class="notification-dropdown-title">
                                                    <h4>Notifications</h4>                            
                                                </div>
                                                <ul class="list-unstyled">
                                                    <?php foreach(getNotifications( Session::get('user')['id'] ) as $key => $notification) :?>

                                                    <li class="media dropdown-item">
                                                        <span class="action-icon badge badge-primary-inverse"><i class="feather icon-info"></i></span>
                                                        <a href="<?php echo $notification['link']?>">
                                                             <div class="media-body">
                                                                <h5 class="action-title"><?php echo $notification['notification']?></h5>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <?php endforeach?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li> 
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div> 
                <!-- End row -->
            </div>
            <!-- End Topbar -->
            <!-- Start Contentbar --> 
            <?php produce('breadcrum')?>
               
            <div class="contentbar">

                <?php produce('content')?>
            </div>
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© 2020 <?php echo APP_NAME?> - All Rights Reserved.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <script src="<?php echo _vendor('js/jquery.min.js')?>"></script>
    <script src="<?php echo _vendor('js/popper.min.js')?>"></script>
    <script src="<?php echo _vendor('js/bootstrap.min.js')?>"></script>
    <script src="<?php echo _vendor('js/modernizr.min.js')?>"></script>
    <script src="<?php echo _vendor('js/detect.js')?>"></script>
    <script src="<?php echo _vendor('js/jquery.slimscroll.js')?>"></script>
    <script src="<?php echo _vendor('js/vertical-menu.js')?>"></script>
    <!-- Switchery js -->
    <script src="<?php echo _vendor('plugins/switchery/switchery.min.js')?>"></script>

    <!-- Datatable js -->
    <script src="<?php echo _vendor('plugins/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/dataTables.bootstrap4.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/dataTables.buttons.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/buttons.bootstrap4.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/jszip.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/pdfmake.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/vfs_fonts.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/buttons.html5.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/buttons.print.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/buttons.colVis.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/dataTables.responsive.min.js')?>"></script>
    <script src="<?php echo _vendor('plugins/datatables/responsive.bootstrap4.min.js')?>"></script>

    <script src="<?php echo _public('js/core.js')?>"></script>
    <script src="<?php echo _public('js/global.js')?>"></script>
    <script src="<?php echo _vendor('js/core.js');?>"></script>

    <?php dtFoot() ?>
    
    <!-- <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/vertical-menu.js"></script>
    <script src="assets/plugins/switchery/switchery.min.js"></script> -->

    <?php produce('scripts')?>
</body>
</html>