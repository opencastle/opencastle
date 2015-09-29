<!DOCTYPE html>
  <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="description" content=" ****">
        <meta name="keywords" content="****">

      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
       <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Connexion</title>
    </head>

    <body>

       <!-- debut header -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="cyan">
                <div class="nav-wrapper">                    
                    
                    <ul class="left">                      
                      <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/lok sgo.png" alt="OpenCastle"></a> <span class="logo-text">Logo_site</span></h1></li>
                    </ul>
                    <ul class="right hide-on-med-and-down">                                            
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light"><i class="mdi-social-notifications"></i></a>
                        </li>                        
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light"><i class="mdi-communication-chat"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Finheader nav-->
    </header>
    <!-- END HEADER -->
      <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- Menu latéral -->
    <div id="main">
        <!-- Début -->
        <div class="wrapper">

            <!-- Début menu latéral gauche-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">

                    <li class="user-details cyan darken-2">
                        <!--  DEBUT CARREE MEMBRES -->
                        <div class="row">
                            <div class="col col s4 m4 l4">
                                <img src="images/myAvatar.png" alt="" class="circle responsive-img valign profile-image">
                            </div>
                            <div class="col col s8 m8 l8">
                                <ul id="profile-dropdown" class="dropdown-content">
                                    <li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a>
                                    </li>
                                    <li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
                                    </li>
                                    <li><a href="#"><i class="mdi-communication-live-help"></i> Help</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a>
                                    </li>
                                    <li><a href="#"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                                    </li>
                                </ul>
                                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">Compte invité<i class="mdi-navigation-arrow-drop-down right"></i></a>
                                <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
                            </div>
                        </div>
                    <!-- FIN CARREE MEMBRES -->

                    </li>
                    <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Accueil</a>
                    </li>
                            <li class="bold active"><a href ="connexion.php" class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-account-circle"></i> Conexion</a>
                            </li>
                            <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-language"></i> Blog</a>
                            </li>
                 </ul>
           
      
                <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
            </aside> 
       

            <!-- END LEFT SIDEBAR NAV-->

            <!-- //////////////////////////////////////////////////////////////////////////// -->

            <!-- START CONTENT -->
      <section id="content">
        
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
            <!-- Search for small screen -->
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Connexion</h5>
                <ol class="breadcrumb">
                  <li><a href="index.php">Public</a></li>
                    <li class="active">Connexion</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="section">
                        <div id="bienvenu">
                            <h4 class="header">Espace membre</h4>
                            <div class="divider"></div>
                         <div class="row">
                               <form class="login-form">
        
        <div class="row margin">
          <div class="input-field col s4">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="username" type="text">
            <label for="username" class="center-align">Username</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s4">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password">
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">          
          <div class="input-field col s4 m12 l12  login-text">
              <input type="checkbox" id="remember-me" />
              <label for="remember-me">Remember me</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4">
            <a href="index.html" class="btn waves-effect waves-light col s12">Login</a>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4 m6 l6">
            <p class="margin medium-small"><a href="page-register.html">Je m'inscrit !</a></p>
          </div>
          <div class="input-field col s4 m6 l6">
              <p class="margin medium-small"><a href="page-forgot-password.html">Mot de pase oublié ?</a></p>
          </div>          
        </div>

      </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <!--end container-->

      </section>
      <!-- END CONTENT -->
      <!-- START FOOTER -->
  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2015 All rights reserved.</span>

        </div>
    </div>
  </footer>
    <!-- END FOOTER -->


    <!-- ================================================
    Scripts
    ================================================ -->
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
     <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    </body>
  </html>