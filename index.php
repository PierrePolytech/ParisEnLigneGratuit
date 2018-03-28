<?php
    session_start();
    include ("identifiant.php");
    if(isset($_POST['compte'])&&isset($_POST['pwd'])){
        $compte= $_POST['compte'];
        $password= $_POST['pwd'];
        $salt= "@|-°+=)QtdDm";
        $req_compte='SELECT idMembres,pseudo,points,email,compte,niveau FROM Membres WHERE compte= "'.$compte.'" AND password=MD5(MD5("'.$password.$salt.'")) ;';
        $result = $db->query($req_compte);
        $res=$result->fetchAll();
        $nb_compte=count($res);
        if($nb_compte==1){
            $_SESSION['compte'] = $compte;
            foreach ($res as $ligne) {
                $_SESSION['id']=$ligne['idMembres'];
                $_SESSION['email']=$ligne['email'];
                $_SESSION['pseudo']=$ligne['pseudo'];
		$_SESSION['niveau']=$ligne['niveau'];
            }            
        }
        else{  
            $erreur=true;//"Pseudonyme ou mot de passe incorrecte";
        }
    }
    else{
        $erreur=false;
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
    <title>Paris Sportifs Virtuels Gratuits</title>
<link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">


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
	<link rel="stylesheet" href="css/index.css" />

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
                        Affichage_entete($erreur); 
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
        <div class="container" name="corpsprincipale">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div id="affichage_menu" >
                        <?php 
                            Affichage_menu();
                        ?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7" id="div_div_affichage_matchs">
                    <div id="affichage_matchs" >
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3" id="conteneur_paris">
                    <div id="affichage_init_paris_conteneur">
                        <p id="p_parie">
                            <i class="fa fa-fw fa-shopping-cart"></i> 
                             0 pari sélectionné
                        </p>
                        <p name="description">
                            Ajoutez des paris à votre sélection en cliquant sur les cotes
                        </p>
                    </div>
                </div>
                <div id="myModal" class="modal">
                  <!-- Modal content -->
                  <div class="modal-content">
                    <div class="modal-header">
                      <span class="close">&times</span>
                      <h2>Paris</h2>
                    </div>
                    <div class="modal-body">
                      <p id="reponse_paris"></p>
                    </div>
                  </div>
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript">
// When the user clicks on <span> (x), close the modal
document.getElementsByClassName("close")[0].onclick = function() {
    document.getElementById('myModal').style.display = "none";
    document.location.href="index.php";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = "none";
        document.location.href="index.php";
    }
}
function myFunction() {
    document.getElementById("boutton_valide_paris").disabled = true;
    var body = document.body; // For Chrome, Safari and Opera
    var html = document.documentElement; // Firefox and IE places the overflow at the html level, unless else is specified. Therefore, we use the documentElement property for these two browsers
    body.scrollTop = 0;
    html.scrollTop = 0;
    $('#boutton_valide_paris').attr('onclick','');
    validation_paris();
}
</script>
</body>


</html>







