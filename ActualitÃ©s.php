<?php
include 'function.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    <meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
    <title>L'actualité du sport en continu</title>
<link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/actualites.css" />
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
                <div class="col-lg-12">
                    <ul class="nav nav-justified" name="sous-menu">
                        <li name="infos_sous-menu" ><a name="a_nav_bar2" >Tous</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">Basketball</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">Football</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">Rugby</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">Tennis</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">F1</a></li>
                        <li name="infos_sous-menu" ><a name="a_nav_bar2">Cyclisme</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" id="affichage_actu">
                <?php 
                    Affichage_Actualites();
                ?>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript">
    document.getElementsByName('a_nav_bar2')[0].onclick=function(){affichage_actualites('Tous')};
    document.getElementsByName('a_nav_bar2')[1].onclick=function(){affichage_actualites('Basketball')};
    document.getElementsByName('a_nav_bar2')[2].onclick=function(){affichage_actualites('Football')};
    document.getElementsByName('a_nav_bar2')[3].onclick=function(){affichage_actualites('Rugby')};
    document.getElementsByName('a_nav_bar2')[4].onclick=function(){affichage_actualites('Tennis')};
    document.getElementsByName('a_nav_bar2')[5].onclick=function(){affichage_actualites('F1')};
    document.getElementsByName('a_nav_bar2')[6].onclick=function(){affichage_actualites('Cyclisme')};
</script>

</html>







