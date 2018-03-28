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
    <title>Suivez l'historique de vos paris</title>
    <link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/mesparis.css" />
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
                <div class="col-lg-12">
                    <ul class="nav nav-justified" name="sous-menu">
                        <?php   
                            if(isset($_GET['type'])){
                                if ($_GET['type']=="Tous"){
                                    echo '<li name="infos_sous-menu" class="active"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                                }
                                else if ($_GET['type']=="Simple"){
                                    echo '<li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu" class="active"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                                }
                                else if ($_GET['type']=="Combine"){
                                    echo '<li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu" class="active"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                                }
                                else if ($_GET['type']=="Attente"){
                                    echo '<li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu" class="active"><a name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                                }
                                else if ($_GET['type']=="Terminer"){
                                    echo '<li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu" class="active"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                                }
                            }
                            else {
                                echo '<li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Tous">Tous</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Simple">Paris simples</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Combine">Paris combinés</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" name="a_nav_bar2" href="Mes-paris.php?type=Attente">Paris en attente</a></li><li name="infos_sous-menu"><a name="a_nav_bar2" href="Mes-paris.php?type=Terminer">Paris terminés</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1  col-sm-12">
                    <?php   
                        if(isset($_GET['type'])){
                            Affichage_Mes_Paris($_GET['type']);
                        }
                        else {
                            Affichage_Mes_Paris("Tous");
                        }
                    ?>
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript">
    var sport =document.getElementsByName("nom_sport");
    for(var i=0;i<sport.length;i++){
        var content=sport[i].innerHTML;
        switch(sport[i].innerHTML) {
            case "Football":
                sport[i].innerHTML="<div class=\"sport-icon-1\"></div> Football";
                break;
            case "Basket-ball":
                sport[i].innerHTML="<div class=\"sport-icon-2\"></div> Basket-ball";
                break;
            case "Tennis":
                sport[i].innerHTML="<div class=\"sport-icon-5\"></div> Tennis";
                break;
            case "Formule 1":
                sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Formule 1";
                break;
            case "Rugby à XV":
                sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XV";
                break;
            case "Cyclisme":
                sport[i].innerHTML="<div class=\"sport-icon-17\"></div> Cyclisme";
                break;
            case "Golf":
                sport[i].innerHTML="<div class=\"sport-icon-9\"></div> Golf";
                break;
            case "Volley-ball":
                sport[i].innerHTML="<div class=\"sport-icon-7\"></div> Volley-ball";
                break;
             case "Handball":
                sport[i].innerHTML="<div class=\"sport-icon-6\"></div> Handball";
                break;
            case "Hockey sur glace":
                sport[i].innerHTML="<div class=\"sport-icon-4\"></div> Hockey sur glace";
                break;
            case "Football américain":
                sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Football américain";
                break;
            case "Moto":
                sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Moto";
                break;
            case "Boxe":
                sport[i].innerHTML="<div class=\"sport-icon-10\"></div> Boxe";
                break;
            case "Rallye":
                sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Rallye";
                break;
            case "Baseball":
                sport[i].innerHTML="<div class=\"sport-icon-3\"></div> Baseball";
                break;
             case "Rugby à XIII":
                sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XIII";
                break;
            case "Speedway":
                sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Speedway";
                break;
            case "Australian Rules":
                sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Australian Rules";
                break;
        }
    }
    var paris=document.getElementsByName("paris");
    for(var i=0;i<paris.length;i++){
        var x=paris[i].children[0].children[1].getAttribute("type");
        if(x=="Gagné"){
            paris[i].children[2].children[0].setAttribute("choix","Gagné");
            var text = paris[i].children[3].innerText;
            var mise = paris[i].children[3].innerText.split(":") ;
            var cote = paris[i].children[4].innerText.split(":") ;
            var gain =(mise[1]*cote[1]).toFixed(2);
            text=text+"€ → Gain : "+gain+"€";

            paris[i].children[3].innerHTML=text;
        }
        else if(x=="Perdu"){
            paris[i].children[2].children[0].setAttribute("choix","Perdu");
            var text = paris[i].children[3].innerText;
            text=text+"€";
            paris[i].children[3].innerHTML=text;
        }
        else if(x=="Attente"){
            paris[i].children[2].children[0].setAttribute("choix","Attente");
            var text = paris[i].children[3].innerText;
            text=text+"€";
            paris[i].children[3].innerHTML=text;
        }
    }
    var paris_combine=document.getElementsByName("paris_combine");
    for(i=0;i<paris_combine.length;i++){
        var x=paris_combine[i].children;
        var situation_paris="Gagné";
        for( var j=0; j<x.length;j++){
            var attr=x[j].getAttribute("name");
            if(attr=="sous_paris_combine"){
                var situation= x[j].children[0].children[1].getAttribute("type");
                if((situation=="Gagné")&&(situation_paris=="Gagné")){
                    situation_paris="Gagné";
                }
                else if((situation=="Attente")&&(situation_paris!="Perdu")){
                    situation_paris="Attente";
                    x[j].children[1].children[0].children[0].setAttribute("choix","Attente");
                }
                else if(situation=="Perdu"){
                    x[j].children[1].children[0].children[0].setAttribute("choix","Perdu");
                    situation_paris="Perdu";
                }     

                if(situation=="Gagné"){
                    x[j].children[1].children[0].children[0].setAttribute("choix","Gagné");
                } 
                if(situation=="Perdu"){
                    x[j].children[1].children[0].children[0].setAttribute("choix","Perdu");
                }           
            }            
        }
        var modif=paris_combine[i].children[0].children[1];
        modif.setAttribute("type",situation_paris);
        modif.innerHTML=situation_paris;
        if(situation_paris=="Gagné"){
            for( var j=0; j<x.length;j++){
                var attr=x[j].getAttribute("name");
                if(attr=="footer_paris_combine"){
                    var text_combine=x[j].children[0].innerText;
                    var cote_combine=x[j].children[1].innerText.split(":");
                    var mise_combine=x[j].children[0].innerText.split(":");
                    var gain_combine =(mise_combine[1]*cote_combine[1]).toFixed(2);
                    text_combine=text_combine+"€ → Gain : "+gain_combine+"€";
                    x[j].children[0].innerHTML=text_combine;
                }              
            }
        }
        else{
            for( var j=0; j<x.length;j++){
                var attr=x[j].getAttribute("name");
                if(attr=="footer_paris_combine"){
                    var text_combine=x[j].children[0].innerText;
                    text_combine=text_combine+"€";
                    x[j].children[0].innerHTML=text_combine;
                }
            }
        }
    }

</script>
</body>

</html>







