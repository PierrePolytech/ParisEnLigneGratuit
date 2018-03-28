<?php
	include 'function.php';
	include ("identifiant.php");

	if(isset($_POST['compte'])&&isset($_POST['reponse'])){
		$compte= $_POST['compte'];
		$reponse= $_POST['reponse'];
		$salt= "@|-°+=)QtdDm";
		$req_compte='SELECT password_crypte,password,email FROM Membres WHERE compte= "'.$compte.'" ;';
		$result = $db->query($req_compte);
    	$res=$result->fetchAll();
    	$nb_compte=count($res);
    	if($nb_compte==1){
    		foreach ($res as $ligne) {
    			$Crypt=$ligne['password_crypte'];
    			$mdp=$ligne['password'];
    			$email=$ligne['email'];
    		}
    		$Decrypt = Cryptage($Crypt, $reponse);
    		if($mdp==md5(md5($Decrypt.$salt))){
    			$headers = 'From: "FreeSportsBetting" <freesportsbetting1@gmail.com>'."\n";
				$headers .= 'Return-Path: <freesportsbetting1@gmail.com>'."\n";
				$headers .= 'MIME-Version: 1.0'."\n";
    			$message = 'Bonjour,
Votre mot de passe sur le site FreeSportBetting est '.$Decrypt.'. Si la demande de revoie du mot de passe ne viens pas de votre demande, cela veux dire que un utilisateur dispose de votre nom de compte. 
Nous vous conseillons de modifier votre nom de compte et mot de passe.  
PS : Nous vous recommandons de changer régulièrement votre mot de passe et de ne pas diffuser votre nom de compte afin de protéger vos données.
Cordialement,
FreeSportsBetting';
    			$sujet = 'Mot de passe oublié FreeSportBetting';
     			if(mail($email, $sujet, $message, $headers)){
				    header('Location: index.php');
				}
				else{
			        $erreur= "Une erreur c'est produite lors de l'envoie de l'email.";
				}
    		}
			else{
				$erreur='Reponse secrete ou nom de compte incorrecte';
			}
		}
		else{
				$erreur='Reponse secrete ou nom de compte incorrecte';
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
        <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    	<meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
	    <title>Mot de passe oublié FreeSportsBetting ?</title>
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
        <!-- ci-dessous notre fichier CSS -->
        <link rel="stylesheet" type="text/css" href="css/mdp.css" />
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
    	<div class="container">
		    <div class="main">	            
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-offset-2 col-lg-9">
			            <h2>Mot de passe oublié </h2>
			            <p>Indiquez ci-dessous l'adresse email et la réponse secrète que vous utilisez pour votre compte.
						Vous recevrez un email vous indiquant les informations pour récupérer l’accès à votre compte.</p>
			            <form name="mdp_oublie" class="form-horizontal" role="form" action="Mot-de-passe-oublié.php" method="POST">
						  <div class="form-group" name="form">
						    <label class="control-label col-lg-5 col-sm-6" for="compte">Nom du compte:</label>
						    <div class="col-lg-7 col-sm-6">
						      <input id="compte_corps" type="text" class="form-control" name="compte" placeholder="Entrer pseudo" required="required">
						    </div>
						  </div>
						  <div class="form-group" name="form">
						    <label class="control-label col-lg-5 col-sm-6" for="reponse">Quel(s) équipe(s) suportée(s) vous ?:</label>
						    <div class="col-lg-7 col-sm-6"> 
						      <input id="reponse_corps" type="text" class="form-control" name="reponse" placeholder="Entrer reponse secrete" required="required">
						    </div>
						  </div>
						  <?php
							if($erreur) echo '<p class=\'alert\'>'.$erreur.'</p>';
						  ?> 
						  <div class="form-group" name="form"> 
						    <div class="col-lg-offset-5 col-lg-7">
						      <button id="renvoie_mdp" type="submit" class="btn btn-success" >Renvoie mot de passe</button>						      
						    </div>
						  </div>
						</form>
			        </div>
		        </div>
	    	</div>
		</div>
    </body>
</html>
