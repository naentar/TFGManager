<?php
 //file: view/layouts/default.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 
?><!DOCTYPE html>
<html>
  <head>
	<title>TFG Manager</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Business Frontpage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-frontpage.css" rel="stylesheet">
	
	<!-- My own CSS -->
	<link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
  <body>    
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?controller=users&action=index">Inicio</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
				    <li>
                        <a href="#">Informaci&oacuten</a>
                    </li>
					
					<li>
					<?php
							include(__DIR__."/language_select_element.php");
						?>
					</li>
					<?php
						if (!isset($currentuser)) echo '<li class="menuItem"><a href="index.php?controller=users&action=login">Iniciar sesión</a></li>';
					?>
					<?php
					    if(isset($currentuser)) echo '<li class="menuItem"><a href="index.php?controller=users&action=logout">Cerrar sesi&oacute;n</a></li>';
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- header -->
    
    <main>
      <div id="flash">
	<?= $view->popFlash() ?>
      </div>
      
      <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>    
    </main>
	
	<div class="container">
			<hr>
		<div>
    
    <!-- Footer -->
        <section class="footer" id="footer">
			<p class="text-center">
				<a href="#wrapper" class="gototop"><i
						class="fa fa-angle-double-up fa-2x"></i></a>
			</p>

			<div class="container">
				<p>
					&copy; 2016 Copyright ESEI TFG Manager<br>
				</p>
			</div>
		</section>
		
		
    
  </body>
</html>