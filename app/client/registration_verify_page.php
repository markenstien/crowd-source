<?php require_once('../dependencies.php')?>


<?php require_once('functions/main.php')?>

<?php build('content')?>
	<div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div style="margin-top: 150px;">
                <!-- Start row -->
                 <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-8 col-lg-6">
                        <div class="text-center">
                        	<h1>You're a one step away to getting your dream Job!</h1>
                        	<p>We sent you a verification on your email , activate your account today!</p>
                        </div>

                        <div class="text-center">
                        	<?php echo wSystemBanner()?>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
<?php endbuild()?>

<?php loadTo('orbit/index.php')?>