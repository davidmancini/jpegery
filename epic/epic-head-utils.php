<!--------------------------------------------------------------------
|	Head Utilities specifically for Epic
|------------------------------------------
| HTML tags to be included into head tags
| for Bootstrap functionality.
|
---------------------------------------------------------------------!> <!-- -->

<!-- Tells IE to use highest mode available, avoiding IE compatibility Mode bugs. -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- Sets viewport and zoom scale to 1:1.  This is required when creating a responsive site. -->
<meta name="viewport" content="width=device-width, initial-scale=1" />


<!-- Bootstrap Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous" />

<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<!--Angular-->
<?php $ANGULAR_VERSION = "1.5.0";?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.2.1/ui-bootstrap-tpls.min.js"></script>
<script type="text/javascript" src="//angular-file-upload.appspot.com/js/ng-file-upload-shim.js"></script>
<script type="text/javascript" src="//angular-file-upload.appspot.com/js/ng-file-upload.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-messages.js"></script>

<!--Angular app files (order: app, services, directives, controllers)-->
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/jpegery.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/route-config.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/services/login-service.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/services/profile-service.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/directives/current-profile.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/main-controller.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/image-controller.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/user-controller.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/settings-controller.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/upload-controller.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX;?>angular/controllers/login-controller.js"></script>