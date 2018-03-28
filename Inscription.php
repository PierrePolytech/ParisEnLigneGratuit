<?php
   include ("identifiant.php");
function Cryptage($MDP, $Clef){
    $LClef = strlen($Clef);
    $LMDP = strlen($MDP);
    if ($LClef < $LMDP){
        $Clef = str_pad($Clef, $LMDP, $Clef, STR_PAD_RIGHT);
    }
    elseif ($LClef > $LMDP){
        $diff = $LClef - $LMDP;
        $_Clef = substr($Clef, 0, -$diff);
    }
    return $MDP ^ $Clef;
}
    
    if(isset($_POST['email'])&&isset($_POST['pwd'])&&isset($_POST['pwd2'])&&isset($_POST['pseudo'])&&isset($_POST['compte'])){
	$email= $_POST['email'];
        $password= $_POST['pwd'];
        $password2 =$_POST['pwd2'];
        $pseudo= $_POST['pseudo'];
        $compte=$_POST['compte'];
        $reponse_secrete=$_POST['question'];
        $Crypt = Cryptage($_POST['pwd'], $reponse_secrete); 
        $salt= "@|-°+=)QtdDm";
        if($password==$password2){
            $pwd=md5(md5($_POST['pwd'].$salt));
            $req_identifiant='SELECT COUNT(idMembres) AS cpt FROM Membres WHERE pseudo= "'.$pseudo.'"';
            $result = $db->query($req_identifiant);
            $nb_pseudo = $result->fetchColumn();
            $req_identifiant='SELECT COUNT(idMembres) AS cpt FROM Membres WHERE compte= "'.$compte.'"';
            $result = $db->query($req_identifiant);
            $nb_compte = $result->fetchColumn();
            if(($nb_pseudo==0)&&($nb_compte==0)){
		$query=$db->prepare('INSERT INTO Membres VALUES (\'\', :pseudo,:compte, :email, :password,:password_crypte,100,0,3)');
                $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $query->bindValue(':compte', $compte, PDO::PARAM_STR);
                $query->bindValue(':email', $email, PDO::PARAM_STR);
                $query->bindValue(':password', $pwd, PDO::PARAM_STR);
                $query->bindValue(':password_crypte',$Crypt, PDO::PARAM_STR);
                $query->execute();
                $headers = 'From: "FreeSportsBetting" <freesportsbetting1@gmail.com>'."\n";
                $headers .= 'Return-Path: <freesportsbetting1@gmail.com>'."\n";
                $headers .= 'MIME-Version: 1.0'."\n";
                $message = 'Bonjour,
Nous vous remercions de votre inscription sur le site FreeSportBetting. Vous disposez maintenant d\'un plein accès à nos services, vous pouvez à tous moment modifier vos informations personnelles grâce à l\'onglet paramètres du compte. Pour l\'instant, vous disposez de 100 euros virtuels pour parier et faire augmenter votre cagnotte, si votre cagnotte est à sec rechargé la grâce à l\'onglet Statistiques dans la limite de 100 euros virtuels toutes les semaines. 
Cordialement,
FreeSportsBetting';
                $sujet = 'Inscription FreeSportsBetting';
                if(mail($email, $sujet, $message, $headers)){
			header('Location: index.php');
			exit();
		}
		else{
                    $erreur= "Une erreur c'est produite lors de l'envoi de l'email.";
                } 
	    } 
		if ($nb_compte!=0){  
	    		$erreur="Nom de compte déjà utilisé";
	    	}
	    	else if ($nb_pseudo!=0){  
	    		$erreur="Pseudonyme déjà utilisé";
	    	}
	    	else if(($nb_pseudo==0)&&($nb_compte==0)){
	    		$erreur="Pseudonyme et nom de compte déjà utilisés";
	    	}   
	}
}
    else{
        
    }
?>
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    <meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
        <title>Inscrivez-vous sur FreeSportsBetting</title>
<link rel="icon" type="image/png" href="Images/icon.png" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Connexion à mon application">
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <!-- ci-dessous notre fichier CSS -->
        <link rel="stylesheet" type="text/css" href="css/inscription.css" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato:400,700,300" />
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js"></script>
    </head>
    
    <body>
        <div class="container">
            <div class="main">              
                <div class="row">
                    <div class="col-lg-12">
                        <a name="bouton_retour" type="submit" class="btn btn-primary" href="./index.php" >Retour</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <h1>Inscription sur FreeSportsBetting</h1>
                        <form class="form-horizontal" role="form" data-toggle="validator" action="Inscription.php" method="POST">
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="pseudo">Pseudonyme:</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="pseudo" placeholder="Entrer pseudonyme" required="required">
                              <span class="help-block">Nom visible sur le site par les autres utilisateurs</span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="compte">Nom de compte:</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="compte" placeholder="Entrer le nom de compte" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="email">Email:</label>
                            <div class="col-sm-6 ">
                              <input type="email" class="form-control" name="email" placeholder="Entrer l'email" required="required">
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="pwd">Mot de passe:</label>
                            <div class="col-sm-6"> 
                              <input type="password" class="form-control" data-minlength="6"  name="pwd" id="inputPassword" placeholder="Entrer le mot de passe" required="required">
                              <span class="help-block">Minimum de 6 charactères</span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="pwd2">Confirmation du mot de passe:</label>
                            <div class="col-sm-6"> 
                              <input type="password" class="form-control" name="pwd2" id="ConfirmInputPassword" data-match="#inputPassword" data-match-error="Mot de passe ne correspond pas" placeholder="Confirmer le mot de passe" required="required">
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-5 col-lg-6" for="question">Quel(s) équipe(s) suportée(s) vous ?</label>
                            <div class="col-sm-6 ">
                              <input type="text" class="form-control" name="question" placeholder="Entrer la réponse secrète" required="required">
                              <span class="help-block">Utilisé en cas d'oublie de mot de passe</span>
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <?php
                            if($erreur) echo '<p class="alert">'.$erreur."</p>";
                          ?>
                          <div class="form-group">
                            <button name="bouton_inscription" type="submit" class="btn btn-success">Inscription</button>
                          </div>                  
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div id="presentation_site">
                            <p name="p_titre"> FreeSportsBetting </p>
                            <p name="p_phrase">Vous êtes toujours demandé qui de vos amis est le meilleur sur le sport, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne.</p>
                            <p name="p_phrase">Voici FreeSportBetting </p>
                            <p name="p_phrase">FreeSportBetting est un site gratuit de paris en ligne sur tous les matchs et sports. Il vous permet de miser de l'argent virtuel sur des côtes mis à jour en direct afin de tester vos compétences, mais aussi celle de vos amis.</p>
                            <p name="p_phrase">Lors de votre inscription, vous recevez 100 euros virtuels que vous pouvez miser sur le site.</p>
                            <p name="p_phrase">Informations : Le rechargement peut se faire à tout moment dans la limite de 100 euros virtuels toutes les semaines.Le classement sur le site est établi par rapport à vos gains réels sur le site</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>







