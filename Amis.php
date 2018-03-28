<?php
    include('identifiant.php');
    
    session_start();
    if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
    }
    else{
        header('Location: index.php');
	exit();
    }
	
if(isset($_POST['compte'])){
        $pseudo=$_POST['compte'];
        $req_compte='SELECT idMembres FROM Membres WHERE pseudo= "'.$pseudo.'";';
        $result = $db->query($req_compte);
        $res=$result->fetchAll();
        $nb_compte=count($res);
        if($nb_compte==1){
            foreach ($res as $ligne) {
                $id=$ligne['idMembres'];
            }
            $requete_amis='select count(idFrom) as nb from Amis WHERE idTo='.$_SESSION['id'].' AND idFrom='.$id.';';
            $resultat_amis=$db->query($requete_amis) or die('Erreur'.mysql_error());
            $columns = $resultat_amis->fetch();
            $demande = $columns['nb'];
            //echo $demande;
            if($demande==1){
                $query=$db->prepare('UPDATE Amis SET status=2 Where idTo=:idto AND idFrom=:idfrom');
                $query->bindValue(':idto', $_SESSION['id'], PDO::PARAM_INT);
                $query->bindValue(':idfrom',$id, PDO::PARAM_INT);
                $query->execute();                    

            }
            else if ($demande==0) {
                //insertion demande amis
                $query=$db->prepare('INSERT INTO Amis VALUES (:idto,:idfrom,1)');
                $query->bindValue(':idto', $id, PDO::PARAM_INT);
                $query->bindValue(':idfrom', $_SESSION['id'], PDO::PARAM_INT);
                $query->execute();
            }

            
        }
        else{
            $erreur='Pseudonyme inexistant';
        }
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
    <title>Suivez l'évolution de vos amis sur FreeSportsBetting</title>
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
    <link rel="stylesheet" href="css/amis.css" />
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
                       Demande_amis();
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form class="form-horizontal" role="form" action="Amis.php" method="POST">
                          <div class="form-group">
                            <label class="control-label col-lg-offset-2 col-lg-2  col-md-offset-2 col-md-2 col-sm-3  col-xs-6" for="pseudo">Pseudonyme :</label>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                              <input type="text" class="form-control" name="compte" placeholder="Entrer pseudo" required="required">
                            </div>
                            <button type="submit" class="btn btn-success col-lg-2 col-md-2 col-sm-2  col-xs-6" >Ajout ami</button>
                          </div>
                          <?php
                            if($erreur) echo '<p class="alert">'.$erreur."</p>";
                          ?> 
                    </form>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?php
                        Affichage_amis();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>






