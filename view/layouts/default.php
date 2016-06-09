<?php
 //file: view/layouts/default.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 
?><!DOCTYPE html>
<html>
  <head>
    <title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
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
                <a class="navbar-brand" href="#">Inicio</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Login</a>
                    </li>
                    <li>
                        <a href="#">Informaci&oacuten</a>
                    </li>
					<li>
					<?php
							include(__DIR__."/language_select_element.php");
						?>
					</li>
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