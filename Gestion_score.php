<?php
    include('identifiant.php');
    include 'function.php';
    session_start();
    if(isset($_SESSION['niveau'])==1){
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
	<link rel="stylesheet" href="css/score.css" />

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
	<div name="recherche">
		<SELECT id="select_mode" size="1" onchange="affichageScore()">
			<OPTION >Ajout Score
			<OPTION>Modification Score
			<OPTION>Previsualisation Score
		</SELECT>
		<div class="checkbox" onchange="affichageScore()">
		      <label><input name=liste_select type="checkbox" value="Tous" checked>Tous</label>
		      <label><input name=liste_select type="checkbox" value="Football" >Football</label>
		      <label><input name=liste_select type="checkbox" value="Basket-Ball">BasketBall</label>
		      <label><input name=liste_select type="checkbox" value="HandBall">HandBall</label>
		      <label><input name=liste_select type="checkbox" value="Tennis">Tennis</label>
		      <label><input name=liste_select type="checkbox" value="Rugby à XV">Rugby à XV</label>
		      <!--<label><input name=liste_select type="checkbox" value="Autres">Autres</label>-->
		</div>
	  </div>
	  <div id="result">
		
	  </div>

    </div>
<script type="text/javascript">
var valeurs = [];
$('input:checked[name=liste_select]').each(function() {
  valeurs.push($(this).val());
}); 
var mode=document.getElementById("select_mode").options[document.getElementById("select_mode").selectedIndex].text;
$.post("Score.php", 
{ 
    Mode:mode,
    Sports:valeurs
},
function(response,status){ 
    document.getElementById('result').innerHTML=response;

});
function affichageScore(){
	var valeurs = [];
$('input:checked[name=liste_select]').each(function() {
  valeurs.push($(this).val());
});	
var mode=document.getElementById("select_mode").options[document.getElementById("select_mode").selectedIndex].text;
//console.log(mode);
//console.log(valeurs);
$.post("Score.php", 
{ 
    Mode:mode,
    Sports:valeurs
},
function(response,status){ 
    document.getElementById('result').innerHTML=response;

});
}


function majScore(id){
    var modif =$('input[id="Score'+id+'"]').val();
    var mode=document.getElementById("select_mode").options[document.getElementById("select_mode").selectedIndex].text;
   
$.post("Score.php", //Required URL of the page on server
            { // Data Sending With Request To Server
                Id:id,
                Modif:modif,
                Mode:mode
            },
            function(response,status){ // Required Callback Function
                //alert("----Resumé Action----" + response);//"response" receives - whatever written in echo of above PHP script.
                document.location.href="GestionScore.php";
    });
}


</script>
</body>


</html>







