<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/bootstrap/css/bootstrap.min.css'; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/fonts/ptsans/stylesheet.css'; ?>" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/fonts/icomoon/style.css'; ?>" media="screen">

<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/login.css'; ?>" media="screen">

<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/mws-theme.css'; ?>" media="screen">

<title>Login</title>

</head>

<body>
    <div id="mws-login-wrapper">
        <div id="mws-login">
            <h1>Login</h1>
            <div class="mws-login-lock"><i class="icon-lock"></i></div>
            <div id="mws-login-form">
	<?php echo CHtml::beginForm('', 'post', array('class' => 'mws-form' )); ?>
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="text" name="Login[email]" class="mws-login-username required" placeholder="email" value="<?php echo (isset($_POST['Login']['email'])) ? $_POST['Login']['email'] : ''   ?>"  />
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="password" name="Login[password]" class="mws-login-password required" placeholder="password" />
                        </div>
                    </div>
					<?php /** /  ?>
                    <div id="mws-login-remember" class="mws-form-row mws-inset">
                        <ul class="mws-form-list inline">
                            <li>
                                <input id="remember" type="checkbox"> 
                                <label for="remember">Remember me</label>
                            </li>
                        </ul>
                    </div>
					<?php /**/  ?>
		<div class="mws-form-row error"><?php echo '' ?></div>					
                    <div class="mws-form-row">
                        <input type="submit" value="Login" class="btn btn-success mws-login-button">
                    </div>
	<?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>

    <!-- JavaScript Plugins -->
    <script src="<?php echo $this->assetPath . '/admin/js/libs/jquery-1.8.3.min.js'; ?>"></script>
    <script src="<?php echo $this->assetPath . '/admin/js/libs/jquery.placeholder.min.js'; ?>"></script>
    <script src="<?php echo $this->assetPath . '/admin/custom-plugins/fileinput.js' ;?>"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="<?php echo $this->assetPath . '/admin/jui/js/jquery-ui-effects.min.js'; ?>"></script>

    <!-- Plugin Scripts -->
    <script src="<?php echo $this->assetPath . '/admin/plugins/validate/jquery.validate-min.js'; ?>"></script>

    <!-- Login Script -->
    <script src="<?php echo $this->assetPath .'/admin/js/core/login.js'; ?>"></script>

</body>
</html>
