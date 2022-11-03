<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo APP_NAME?></title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?php echo _vendor('images/favicon.ico')?>">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="<?php echo _vendor('plugins/switchery/switchery.min.css')?>" rel="stylesheet">
    <link href="<?php echo _vendor('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/icons.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/flag-icon.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _vendor('css/style.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _public('css/global_custom.css')?>" rel="stylesheet" type="text/css">

    <?php produce('headers')?>
    <!-- End css -->
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php"><?php echo APP_NAME?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if( empty( auth() ) ): ?>
        <ul class="navbar-nav my-2 ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="catalog.php">Catalog <span class="sr-only">(current)</span></a>
          </li>
        </ul>
        <?php else:?>
        <ul class="navbar-nav my-2 ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
        </ul>
        <?php endif;?>
      </div>
    </nav>

    <divp>
        <?php produce('content')?>


        <!-- <?php appVersion() ?> -->
    </div>
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="100240705180203"
  theme_color="#13cf13"
  logged_in_greeting="You like it? send us a message and we will set up the application for you!"
  logged_out_greeting="You like it? send us a message and we will set up the application for you!">
      </div>
      
    <script src="<?php echo _vendor('js/jquery.min.js')?>"></script>
    <script src="<?php echo _vendor('js/popper.min.js')?>"></script>
    <script src="<?php echo _vendor('js/bootstrap.min.js')?>/"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="<?php echo _vendor('js/modernizr.min.js')?>"></script>
    <script src="<?php echo _vendor('js/detect.js')?>"></script>
    <script src="<?php echo _vendor('js/jquery.slimscroll.js')?>"></script>
    <script src="<?php echo _vendor('js/vertical-menu.js')?>"></script>
    <!-- Switchery js -->
    <script src="<?php echo _vendor('plugins/switchery/switchery.min.js')?>"></script>
    <!-- Core js -->
    <script src="<?php echo _vendor('js/core.js')?>"></script>
    <!-- End js -->
</body>
</html>