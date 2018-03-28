<?php
    include('identifiant.php');
    session_start();
    if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
    }
    else{
        header('Location: index.php');
	exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    <meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
    <title>Toutes les statistiques de votre compte FreeSportsBetting</title>
<link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://d3js.org/d3.v3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/solde.css" />
</head>

<body>
	<header id="entete">
        <div class="container">
            <div class="row" name="bandeau_entete">
                <div id="nom_site" class="col-lg-2 col-md-3 col-sm-4 col-xs-3">
                    <img id="image_logo" src="Images/logo.png">
                </div>
                <div id="gestion_compte" class="col-lg-10 col-md-9 col-sm-8 col-xs-9">
                    <?php
                        include 'function.php';
			Affichage_entete(false); 
                    ?>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-10">
                    <nav>
                      <div class="navbar-justified" >
                        <ul name="nav_bar_entete">
                            <li name="li_nav_bar"><a name="a_nav_bar" href="index.php">Paris</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Actualités.php">Actualités</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Classement.php">Classement</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Partenariat.php">Partenariat</a></li>
                        </ul>
                      </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div id="corps">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?php
                        Affichage_Solde();
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form name="form_stat" class="container2" id="form_radio">    
                        <ul>
                          <li class="li_radio">
                            <input type="radio" id="f-option" value="Paris" name="selector" checked>
                            <label for="f-option">Paris</label>                            
                            <div class="check"></div>
                          </li>                          
                          <li class="li_radio">
                            <input type="radio" id="s-option" value="ParisS" name="selector">
                            <label for="s-option">Paris Simples</label>                            
                            <div class="check"></div>
                          </li>                          
                          <li class="li_radio">
                            <input type="radio" id="t-option" value="ParisC" name="selector">
                            <label for="t-option">Paris Combinés</label>                            
                            <div class="check"></div>
                          </li>
                        </ul>
                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div id="div_stat">
                        <!--<div class="header" id="title_attente">Paris en attente</div>-->
                        <div id="corps_stats"></div>
                    </div>                    
                    <div class="widget">
                        <div id="chart" class="chart-container"></div>
                        <div class="header" id="title_donut">Nombre Paris</div>
                    </div>
                    <div class="widget2">
                        <div id="chart_bar1" class="chart-container">
                            <div id="chart_nb" class="chart-container"></div>
                            <div class="header" id="title_nb">Nombre Paris</div>
                        </div>
                        <div id="chart_bar2" class="chart-container">
                            <div id="chart_mise" class="chart-container"></div>
                            <div class="header" id="title_mise">Côte moyenne Paris</div>
                        </div>
                        <div id="chart_bar3" class="chart-container">
                            <div id="chart_miseM" class="chart-container"></div>
                            <div class="header" id="title_miseM">Mise moyenne Paris</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">                    
                    <div id="div_Attente">
                        <div class="header" id="title_attente">Paris en attente</div>
                        <div id="corps_attente"></div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <script type="text/javascript" src="dataviz.js"></script>
</body>

</html>






    
