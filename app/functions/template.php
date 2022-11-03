<?php
    function occupy($viewPath)
    {
        $data = $GLOBALS['data'];

        extract($data);

        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';
    }


    function loadTo($viewPath)
    {
        $data = $GLOBALS['data'] ?? [];

        extract($data);
        

        $viewPath = str_replace('.php', '', $viewPath);

        return require_once VIEWS.DS.$viewPath.'.php';
    }

    /*COMBINE
    *FILE REQUIRE
    */
    function combine($viewPath)
    {
        $viewPath = convertDotToDS($viewPath);

        $file = VIEWS.DS.$viewPath.'.php';
        if(file_exists($file)){
            require_once $file;
        }else{
            die(" NO FILE FOUND ");
        }
    }


    function grab($viewPath , $data = null)
    {
        $viewPath = convertDotToDS($viewPath);



        if(isset($_GLOBALS['data']))
        {
            $globalData = $GLOBALS['data'];
            extract($globalData);
        }


        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';

    }

    function grab_script($path)
    {

    }

    /*BUILD
    *This will build a html content
    * and will be stored on render builds
    */
    function build($buildName)
    {
        Material::$buildInstance++;
        Material::addBuild($buildName);

        ob_start();
    }

    /*ENDBUILD
    *This will get all html inside in between build and this function
    *
    */
    function endbuild()
    {
        Material::$buildInstance;
        Material::build(ob_get_contents());

        ob_end_clean();
    }

    /*ENDBUILD
    *This will produce a render build
    */

    function produce($varName)
    {
        echo Material::show($varName);
    }


    function loadSidebar()
    {

        $auth = auth();

        if( isEqual($auth['auth-type'] , 'vendor') )
        {
             include_once VIEWS.DS.'orbit/inc/sidebar_vendor.php'; 
        }

        if( isEqual($auth['auth-type'] , 'company') )
        {
            
        }

        if( isEqual($auth['auth-type'] , 'applicant') )
        {
           include_once VIEWS.DS.'orbit/inc/sidebar_applicant.php'; 
        }
    }


    function loadBreadCrumb($page = 'Administrator')
    {
        $page = ucwords($page);

        print <<<EOF
            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">{$page}</h4>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Actions</button>
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
        EOF;
    }



    function dtHead()
    {
        $link =  _vendor('orbit/plugins');
        print <<<EOF
            <link href="{$link}/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            <link href="{$link}/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        EOF;
    }

    function dtFoot()
    {
        $link =  _vendor('orbit/plugins');

        print <<<EOF
        <!-- Datatable js -->
        <script src="{$link}/datatables/jquery.dataTables.min.js"></script>
        <script src="{$link}/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="{$link}/datatables/dataTables.buttons.min.js"></script>
        <script src="{$link}/datatables/buttons.bootstrap4.min.js"></script>
        <script src="{$link}/datatables/jszip.min.js"></script>
        <script src="{$link}/datatables/pdfmake.min.js"></script>
        <script src="{$link}/datatables/vfs_fonts.js"></script>
        <script src="{$link}/datatables/buttons.html5.min.js"></script>
        <script src="{$link}/datatables/buttons.print.min.js"></script>
        <script src="{$link}/datatables/buttons.colVis.min.js"></script>
        <script src="{$link}/datatables/dataTables.responsive.min.js"></script>
        <script src="{$link}/datatables/responsive.bootstrap4.min.js"></script>
        <script defer>
            $(document).ready(function() {
                /* -- Table - Datatable -- */
                $('.dataTable').DataTable({
                    responsive: true
                });
                 
                // var table = $('#datatable-buttons').DataTable({
                //     lengthChange: false,
                //     responsive: true,
                //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                // });
                // table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            });
        </script>
        EOF;
    }