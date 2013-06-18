<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Plugin Stylesheets first to ease overrides -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/plugins/colorpicker/colorpicker.css' ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/custom-plugins/wizard/wizard.css' ?>" media="screen" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/bootstrap/css/bootstrap.min.css';  ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/fonts/ptsans/stylesheet.css'; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/fonts/icomoon/style.css' ?>" media="screen" />

<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/mws-style.css'; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/icons/icol16.css';?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/icons/icol32.css' ?>" media="screen" />

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/demo.css'; ?>" media="screen" />

<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/jui/css/jquery.ui.all.css'; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/jui/jquery-ui.custom.css'; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/jui/css/jquery.ui.timepicker.css'; ?>" media="screen">


<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/mws-theme.css' ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/css/themer.css';?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/plugins/cleditor/jquery.cleditor.css';?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/plugins/ibutton/jquery.ibutton.css';?>" media="screen" />

<link rel="stylesheet" type="text/css" href="<?php echo $this->assetPath . '/admin/custom-plugins/picklist/picklist.css';?>" media="screen" />



<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
	
	<!-- Header -->
	<div id="mws-header" class="clearfix">
    
    	<!-- Logo Container -->
    	<div id="mws-logo-container">
        
				<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
				<div id="mws-logo-wrap"></div>
        </div>
        
        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">
                    <?php /** / ?>

        	<!-- Notifications -->
        	<div id="mws-user-notif" class="mws-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-exclamation-sign"></i></a>
                
                <!-- Unread notification count -->
                <span class="mws-dropdown-notif">35</span>
                
                <!-- Notifications dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-notifications">
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php /**/ ?>
            <?php /** / ?>
            <!-- Messages -->
            <div id="mws-user-message" class="mws-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-envelope"></i></a>
                
                <!-- Unred messages count -->
                <span class="mws-dropdown-notif">35</span>
                
                <!-- Messages dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-messages">
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php /**/ ?>
            
            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">
            
            	<!-- User Photo -->
<!--            	<div id="mws-user-photo">
                	<img src="example/profile.jpg" alt="User Photo">
                </div>-->
                
                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
                        Hello, <?php echo Yii::app()->user->name ?>
                    </div>
                    <ul>
<!--                    	<li><a href="#">Profile</a></li>-->
                        <li><a href="<?php echo Yii::app()->createUrl('admin/user_form/' . Yii::app()->user->id ) ?>">Change Password</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('admin/logout/') ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

	


    
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>
		<?php $this->widget('backend.widgets.menu.WidgetMenu'); ?>
        
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            	
	<?php echo $content; ?>

				
				                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
            <div id="mws-footer">
            	Rightster Product 2013
            </div>
            
        </div>
        <!-- Main Container End -->
        
    </div>



	
    <!--[if lt IE 9]>
    <script src="<?php echo $this->assetPath . '/admin/js/libs/excanvas.min.js' ?>"></script>
    <![endif]-->

</body>
</html>