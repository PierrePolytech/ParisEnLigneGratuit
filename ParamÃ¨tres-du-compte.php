<?php
    include('identifiant.php');
    session_start();
    if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
	if(isset($_POST['pseudo'])){
            $pseudo=$_POST['pseudo'];
            // nbre de fois identifiant
            $req_identifiant='SELECT COUNT(idMembres) AS cpt FROM Membres WHERE pseudo= "'.$pseudo.'";';
            $result = $db->query($req_identifiant);
            $nb = $result->fetchColumn();
            if($nb==0){
                $query=$db->prepare('UPDATE Membres Set Membres.pseudo=:pseudo Where Membres.idMembres=:id');
                $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                $query->execute();
                $_SESSION['pseudo']=$pseudo;
                header('Location: Paramètres-du-compte.php'); 
            }
            else{
                $erreur="Pseudonyme déjà utilisé";
            }
        }
        else if(isset($_POST['compte'])&& isset($_POST['ancienpwd'])){
            $compte=$_POST['compte'];
            $password=$_POST['ancienpwd'];
            // nbre de fois identifiant
            $req_identifiant='SELECT COUNT(idMembres) AS cpt FROM Membres WHERE compte= "'.$compte.'";';
            $result = $db->query($req_identifiant);
            $nb = $result->fetchColumn();
            if($nb==0){
                $req_compte='SELECT idMembres FROM Membres WHERE pseudo="'.$_SESSION['pseudo'].'" AND compte="'.$_SESSION['compte'].'" AND password=MD5(MD5("'.$password.'@|-°+=)QtdDm"));';
                $result = $db->query($req_compte);
                $id_compte = $result->fetchColumn();
                if($id_compte==$_SESSION['id']){
                    $query=$db->prepare('UPDATE Membres Set Membres.compte=:compte Where Membres.idMembres=:id');
                    $query->bindValue(':compte', $compte, PDO::PARAM_STR);
                    $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $query->execute();
                    $_SESSION['compte']=$compte;
                    header('Location:Paramètres-du-compte.php'); 
                }
                else{
                    $erreur="Mot de passe incorrecte";
                }
                
            }
            else{
                $erreur="Nom de compte déjà utilisé";
            }
        }
        else if(isset($_POST['email'])){
            $mail=$_POST['email'];
            $query=$db->prepare('UPDATE Membres Set Membres.email=:mail Where Membres.idMembres=:id');
            $query->bindValue(':mail', $mail, PDO::PARAM_STR);
            $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $query->execute();
            $_SESSION['email']=$mail;
            header('Location: Paramètres-du-compte.php'); 
        }
        else if(isset($_POST['pwd'])&& isset($_POST['pwd2'])&&isset($_POST['ancienpwd'])){
            $nvpassword=$_POST['pwd'];
            $confirmation=$_POST['pwd2'];
            $ancienpassword=$_POST['ancienpwd'];
            if($nvpassword==$confirmation){
                $nvpassword=$nvpassword.'@|-°+=)QtdDm';
                $req_compte='SELECT idMembres FROM Membres WHERE pseudo="'.$_SESSION['pseudo'].'"  AND password=MD5(MD5("'.$ancienpassword.'@|-°+=)QtdDm")) ;';
                $result = $db->query($req_compte);
                $id_compte = $result->fetchColumn();
                if($id_compte==$_SESSION['id']){
                    $query=$db->prepare('UPDATE Membres Set Membres.password=MD5(MD5(:mdp)) Where Membres.idMembres=:id');
                    $query->bindValue(':mdp', $nvpassword, PDO::PARAM_STR);
                    $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $query->execute();
                    header('Location: Paramètres-du-compte.php'); 
                }
                else{
                    $erreur="Mot de passe incorrecte";
                }
            }
            else{
                $erreur="erreur confirmation mot de passe";
            }
        }
        else{
            $erreur=false;
        }
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/setting.css" />
</head>

<body>
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
                <div class="col-lg-12 col-md-12 col-sm-12" id="parametre">
                    <?php Affichage_Parametre(); ?>
                    <?php
                        if($erreur) echo '<p class="alert">'.$erreur."</p>";
                    ?>
                </div>
            </div> 
        </div>
    </div>
</body>
</body>

</html>






    
