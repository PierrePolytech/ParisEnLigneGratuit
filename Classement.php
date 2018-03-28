
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    <meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
    <title>Suivez l'évolution des meilleurs joueurs de FreeSportsBetting</title>
<link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/classement.css" />
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
                <div class="col-lg-6">
                    <?php
                        Affichage_Classement_Joueur_Gain(); 
                    ?>
                </div>
                <div class="col-lg-6">
                    <?php
                        Affichage_Classement_Paris_Semaine(); 
                    ?>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    document.getElementById("image1").onclick =function() {
        if(document.getElementById("paris_classement1").style.display=="none"){
            document.getElementById("paris_classement1").style.display = "";
            if(document.getElementById("paris_classement2").style.display == ""){
                document.getElementById("paris_classement2").style.display = "none";
            }
            if(document.getElementById("paris_classement3").style.display == ""){
                document.getElementById("paris_classement3").style.display = "none";
            }
            if(document.getElementById("paris_classement4").style.display == ""){
                document.getElementById("paris_classement4").style.display = "none";
            }
            if(document.getElementById("paris_classement5").style.display == ""){
                document.getElementById("paris_classement5").style.display = "none";
            }
        }
        else{
            document.getElementById("paris_classement1").style.display = "none";
        }        
    };
    document.getElementById("image1").onmouseover =function() {
        document.getElementsByClassName("fa fa-angle-down")[0].style.fontWeight="700";
        document.getElementsByClassName("fa fa-angle-down")[0].style.fontSize="130%";
    };
    document.getElementById("image1").onmouseout =function() {
        document.getElementsByClassName("fa fa-angle-down")[0].style.fontWeight="";
        document.getElementsByClassName("fa fa-angle-down")[0].style.fontSize="";
    };
    document.getElementById("image2").onclick=function() {
        if(document.getElementById("paris_classement2").style.display=="none"){
            document.getElementById("paris_classement2").style.display = "";
            if(document.getElementById("paris_classement1").style.display == ""){
                document.getElementById("paris_classement1").style.display = "none";
            }
            if(document.getElementById("paris_classement3").style.display == ""){
                document.getElementById("paris_classement3").style.display = "none";
            }
            if(document.getElementById("paris_classement4").style.display == ""){
                document.getElementById("paris_classement4").style.display = "none";
            }
            if(document.getElementById("paris_classement5").style.display == ""){
                document.getElementById("paris_classement5").style.display = "none";
            }
        }
        else{
            document.getElementById("paris_classement2").style.display = "none";
        }        
    };
    document.getElementById("image2").onmouseover =function() {
        document.getElementsByClassName("fa fa-angle-down")[1].style.fontWeight="700";
        document.getElementsByClassName("fa fa-angle-down")[1].style.fontSize="130%";
    };
    document.getElementById("image2").onmouseout =function() {
        document.getElementsByClassName("fa fa-angle-down")[1].style.fontWeight="";
        document.getElementsByClassName("fa fa-angle-down")[1].style.fontSize="";
    };
    document.getElementById("image3").onclick=function() {
        if(document.getElementById("paris_classement3").style.display=="none"){
            document.getElementById("paris_classement3").style.display = "";
            if(document.getElementById("paris_classement1").style.display == ""){
                document.getElementById("paris_classement1").style.display = "none";
            }
            if(document.getElementById("paris_classement2").style.display == ""){
                document.getElementById("paris_classement2").style.display = "none";
            }
            if(document.getElementById("paris_classement4").style.display == ""){
                document.getElementById("paris_classement4").style.display = "none";
            }
            if(document.getElementById("paris_classement5").style.display == ""){
                document.getElementById("paris_classement5").style.display = "none";
            }
        }
        else{
            document.getElementById("paris_classement3").style.display = "none";
        } 
    };
    document.getElementById("image3").onmouseover =function() {
        document.getElementsByClassName("fa fa-angle-down")[2].style.fontWeight="700";
        document.getElementsByClassName("fa fa-angle-down")[2].style.fontSize="130%";
    };
    document.getElementById("image3").onmouseout =function() {
        document.getElementsByClassName("fa fa-angle-down")[2].style.fontWeight="";
        document.getElementsByClassName("fa fa-angle-down")[2].style.fontSize="";
    };
    document.getElementById("image4").onclick=function() {
        if(document.getElementById("paris_classement4").style.display=="none"){
            document.getElementById("paris_classement4").style.display = "";
            if(document.getElementById("paris_classement1").style.display == ""){
                document.getElementById("paris_classement1").style.display = "none";
            }
            if(document.getElementById("paris_classement2").style.display == ""){
                document.getElementById("paris_classement2").style.display = "none";
            }
            if(document.getElementById("paris_classement3").style.display == ""){
                document.getElementById("paris_classement3").style.display = "none";
            }
            if(document.getElementById("paris_classement5").style.display == ""){
                document.getElementById("paris_classement5").style.display = "none";
            }
        }
        else{
            document.getElementById("paris_classement4").style.display = "none";
        } 
    };
    document.getElementById("image4").onmouseover =function() {
        document.getElementsByClassName("fa fa-angle-down")[3].style.fontWeight="700";
        document.getElementsByClassName("fa fa-angle-down")[3].style.fontSize="130%";
    };
    document.getElementById("image4").onmouseout =function() {
        document.getElementsByClassName("fa fa-angle-down")[3].style.fontWeight="";
        document.getElementsByClassName("fa fa-angle-down")[3].style.fontSize="";
    };
    document.getElementById("image5").onclick=function() {
        if(document.getElementById("paris_classement5").style.display=="none"){
            document.getElementById("paris_classement5").style.display = "";
            if(document.getElementById("paris_classement1").style.display == ""){
                document.getElementById("paris_classement1").style.display = "none";
            }
            if(document.getElementById("paris_classement2").style.display == ""){
                document.getElementById("paris_classement2").style.display = "none";
            }
            if(document.getElementById("paris_classement3").style.display == ""){
                document.getElementById("paris_classement3").style.display = "none";
            }
            if(document.getElementById("paris_classement4").style.display == ""){
                document.getElementById("paris_classement4").style.display = "none";
            }
        }
        else{
            document.getElementById("paris_classement5").style.display = "none";
        } 
    };
    document.getElementById("image5").onmouseover =function() {
        document.getElementsByClassName("fa fa-angle-down")[4].style.fontWeight="700";
        document.getElementsByClassName("fa fa-angle-down")[4].style.fontSize="130%";
    };
    document.getElementById("image5").onmouseout =function() {
        document.getElementsByClassName("fa fa-angle-down")[4].style.fontWeight="";
        document.getElementsByClassName("fa fa-angle-down")[4].style.fontSize="";
    };
</script>
</body>

</html>







