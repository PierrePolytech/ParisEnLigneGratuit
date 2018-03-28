

<?php
	include 'function.php';
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		if((isset($_POST['Sport']))&&(isset($_POST['CodeBet']))&&(isset($_POST['Event']))&&(isset($_POST['TypeParis']))&&(isset($_POST['Mise']))&&(isset($_POST['Type']))&&(isset($_POST['CodeResult']))&&(isset($_POST['Cote']))&&(isset($_POST['Date_match']))&&(isset($_POST['Match']))){
			$mise=$_POST['Mise'];
			$cote=$_POST['Cote'];             
		    $date_match=$_POST['Date_match'] ; 
		    $match=$_POST['Match'];
		    $coderesult=$_POST['CodeResult'];
		    $typeparis=$_POST['Type'];
		    $soustypeparis=$_POST['TypeParis'];
		    $date_actuelle=date("Y-m-d H:i");
		    $nomSport=$_POST['Sport'];
		    $nomEvent=$_POST['Event'];
		    $codeBet=$_POST['CodeBet'];
		   
		   // Verification mise
		    $mise_totale=0;
		    for($i=0;$i<count($mise);$i++){
		    	$mise_totale=$mise_totale+$mise[$i];
		    }
		    $date_combine=true;
		    $cote_test_combine=1;
		    // Verification date Paris normale
		    for($i=0;$i<count($match);$i++){
		    	$array_date_match = preg_split('"T"', $date_match[$i], -1);
				setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
				$stamp=strtotime($array_date_match[0].' '.$array_date_match[1])+60*60;
				$date_match_test[$i]=date('Y-m-d H:i', $stamp);
		    	if($date_actuelle>$date_match_test[$i]){
		    		$date_combine=false;
		    	}
		    }
		
		    // Verification Cote Paris Normale
		    $cote_test=Verification_Cote($nomSport,$match,$codeBet,$coderesult);
		    if($typeparis=="Combine"){
		    	$cote_totale=1;
		    	for($i=0;$i<count($cote_test);$i++){
		    		$cote_test_combine=$cote_test_combine*$cote_test[$i];
		    	}
		    	for($i=0;$i<count($cote);$i++){
		    		$cote_totale=$cote_totale*$cote[$i];
		    	}
		    }
		    if($mise_totale>0){
		    	$requete_solde='SELECT points FROM Membres WHERE idMembres='.$_SESSION['id'].'';
			    $resultat_solde=$db->query($requete_solde) or die ('Erreur'.mysql_error());
			    $columns=$resultat_solde->fetch();
			    $solde=$columns['points'];
			    if($mise_totale<=$solde){
			    	if($typeparis=="Combine"){
			    		if($date_combine==true){
			    			echo '<div name=\'corps_paris_combine\'>';
			    			$cote_combine=1;
					    	//connaitre idGroupe Paris combine
						    $requete_max_idgroupe='SELECT MAX(idGroupe) FROM Paris_Combine INNER JOIN Paris On Paris_Combine.idParis=Paris.idParis WHERE idMembres='.$_SESSION['id'].'';
							$resultat_idgroupe=$db->query($requete_max_idgroupe) or die('Erreur'.mysql_error());
					    	$columns = $resultat_idgroupe->fetch();
					   		$id_groupe = $columns['MAX(idGroupe)'];	
					   		if($cote_test_combine==$cote_totale){
					   			for($i=0;$i<count($match);$i++) {
				   					//Test requete 
									$requete_nb_match='SELECT COUNT(idMatch) AS nb FROM Matchs WHERE Matchs.nomMatch="'.$match[$i].'" AND Matchs.dateMatch="'.$date_match[$i].'"';
									$resultat_nb_match=$db->query($requete_nb_match) or die('Erreur'.mysql_error());
							    	$columns = $resultat_nb_match->fetch();
							   		$nb_match = $columns['nb'];
							   		if($nb_match==0){
							   			// Insertion du match
							   			$query=$db->prepare('INSERT INTO Matchs(idMatch,nomSport,nomEvent,nomMatch,Score,dateMatch) VALUES (\'\',:sport,:event,:match,NULL,:date_match)');
										$query->bindValue(':match', $match[$i], PDO::PARAM_STR);
										$query->bindValue(':date_match', $date_match[$i], PDO::PARAM_STR);
										$query->bindValue(':sport', $nomSport[$i], PDO::PARAM_STR);
										$query->bindValue(':event', $nomEvent[$i], PDO::PARAM_STR);
										$query->execute();
									}
									//Selection idMatch
									$requete_match='SELECT idMatch FROM Matchs WHERE Matchs.nomMatch="'.$match[$i].'" AND Matchs.dateMatch="'.$date_match[$i].'"';
									$resultat_match=$db->query($requete_match) or die('Erreur'.mysql_error());
							    	$columns = $resultat_match->fetch();
							   		$id_match = $columns['idMatch'];
							   		//Insertion du paris
									$query=$db->prepare('INSERT INTO Paris(idParis, idMembres, mise, cote, typeParis,codeBet,vainqueur,situation,dateParis,idMatch) VALUES (\'\', :idmembre, :mise, :cote,:type,:code,:vainqueur,\'Attente\',NOW(),:idMatch)');
									$query->bindValue(':idmembre', $_SESSION['id'], PDO::PARAM_STR);
									$query->bindValue(':mise', $mise[0], PDO::PARAM_INT);
									$query->bindValue(':cote', $cote[$i], PDO::PARAM_INT);
									$query->bindValue(':type', $typeparis, PDO::PARAM_STR);
									$query->bindValue(':code', $codeBet[$i], PDO::PARAM_STR);
									$query->bindValue(':vainqueur', $coderesult[$i], PDO::PARAM_STR);
									$query->bindValue(':idMatch',$id_match, PDO::PARAM_INT);
									$query->execute();
									$idParis= $db->lastInsertId();
									if($id_groupe==NULL) {
										$query=$db->prepare('INSERT INTO Paris_Combine(idParis,idGroupe) VALUES (:idparis,1)');
										$query->bindValue(':idparis', $idParis, PDO::PARAM_INT);
										$query->execute();
									}
									else {
										$query=$db->prepare('INSERT INTO Paris_Combine(idParis,idGroupe) VALUES (:idparis,:idgroupe)');
										$query->bindValue(':idparis', $idParis, PDO::PARAM_INT);
										$query->bindValue(':idgroupe', $id_groupe+1, PDO::PARAM_INT);
										$query->execute();
									}
					   				echo "<div name=\"match_combine\"><p name=\"nom_match\">Match: <span>{$match[$i]} </span></p><p name=\"result_match\"> {$result[$i]} </p><p name=\"cote_match_combine\">Cote: <span>{$cote[$i]}</span></p> </div>";
						    	}
						    	$gain_combine= round($mise_totale*$cote_totale,2);
						    	$cote_totale=round($cote_totale,2);
						    	echo "<div name=\"footer_combine\"> <p name=\"mise_combine\"> Mise: <span>{$mise[0]} <i class=\"fa fa-eur\" aria-hidden=\"true\"></i></span></p><p name=\"cote_totale_combine\">  Cote: <span>$cote_totale</span></p><p name=\"gain_potentiel_combine\">  Gain Potentiels: <span>$gain_combine <i class=\"fa fa-eur\" aria-hidden=\"true\"></i></span></p> </div></div>"; 

						    	//MISE A JOUR SOLDE 
						    	$solde=$solde-$mise_totale;
						    	$query=$db->prepare('UPDATE Membres SET points=:points WHERE idMembres=:id');
						    	$query->bindValue(':points', $solde, PDO::PARAM_INT);
								$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
								$query->execute();
					   		}
					   		else{
					   			echo '<p name=\'error\'>La cote a été modifiée veuillez-rafraichir</p>';
					   		}
			    		}
				    }
				    else if ($typeparis=="Simple"){
				    	$y=0;
				    	for($i=0;$i<count($mise);$i++) {
					    	$j=$i+1;
					    	$gain= round($mise[$i]*$cote[$i],2);
					    	if(($mise[$i]!='')&&($mise[$i]!=0.00)){
				    			if($date_actuelle<$date_match_test[$i]){
									if($cote_test[$y]==$cote[$i]){
							   			//Test requete 
										$requete_nb_match='SELECT COUNT(idMatch) AS nb FROM Matchs WHERE Matchs.nomMatch="'.$match[$i].'" AND Matchs.dateMatch="'.$date_match[$i].'"';
										$resultat_nb_match=$db->query($requete_nb_match) or die('Erreur'.mysql_error());
								    	$columns = $resultat_nb_match->fetch();
								   		$nb_match = $columns['nb'];
								   		if($nb_match==0){
								   			// Insertion du match
								   			$query=$db->prepare('INSERT INTO Matchs(idMatch,nomSport,nomEvent,nomMatch,Score,dateMatch) VALUES (\'\',:sport,:event,:match,NULL,:date_match)');
											$query->bindValue(':match', $match[$i], PDO::PARAM_STR);
											$query->bindValue(':date_match', $date_match[$i], PDO::PARAM_STR);
											$query->bindValue(':sport', $nomSport[$i], PDO::PARAM_STR);
											$query->bindValue(':event', $nomEvent[$i], PDO::PARAM_STR);
											$query->execute();
										}
								   		//Selection idMatch
										$requete_match='SELECT idMatch FROM Matchs WHERE Matchs.nomMatch="'.$match[$i].'" AND Matchs.dateMatch="'.$date_match[$i].'"';
										$resultat_match=$db->query($requete_match) or die('Erreur'.mysql_error());
								    	$columns = $resultat_match->fetch();
								   		$id_match = $columns['idMatch'];
										//Insertion du paris
										$query=$db->prepare('INSERT INTO Paris(idParis, idMembres, mise, cote, typeParis,codeBet,vainqueur,situation,dateParis,idMatch) VALUES (\'\', :idmembre, :mise, :cote,:type,:code,:vainqueur,\'Attente\',NOW(),:idmatch)');
										$query->bindValue(':idmembre', $_SESSION['id'], PDO::PARAM_STR);
										$query->bindValue(':mise', $mise[0], PDO::PARAM_INT);
										$query->bindValue(':cote', $cote[$i], PDO::PARAM_INT);
										$query->bindValue(':type', $typeparis, PDO::PARAM_STR);
										$query->bindValue(':code', $codeBet[$i], PDO::PARAM_STR);
										$query->bindValue(':vainqueur', $coderesult[$i], PDO::PARAM_STR);
										$query->bindValue(':idmatch', $id_match, PDO::PARAM_INT);
										$query->execute();
										echo "<div name=\"match_simple\"> <p name=\"titre_match\"> Paris $j </p> <p name=\"nom_match\">Match: <span>{$match[$i]} </span></p><p name=\"result_match\">{$result[$i]} </p><p name=\"mise_match\"> Mise: <span>{$mise[$i]} <i class=\"fa fa-eur\" aria-hidden=\"true\"></i></span></p><p name=\"cote_match\"> Cote: <span>{$cote[$i]} </span></p><p name=\"gain_match\"> Gain Potentiels: <span>$gain <i class=\"fa fa-eur\" aria-hidden=\"true\"></i></span></p></div>";
										//MISE A JOUR SOLDE 
								    	$solde=$solde-$mise[$i];
								    	$query=$db->prepare('UPDATE Membres SET points=:points WHERE idMembres=:id');
								    	$query->bindValue(':points', $solde, PDO::PARAM_INT);
										$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
										$query->execute();
							   		}
							   		else{
							   			echo "<div name=\"match_simple\"> <p name=\"titre_match\"> Paris $j </p> <p name=\"nom_match\">Match: <span>{$match[$i]} </span></p><p name=\"error\">La cote a été modifiée veuillez-rafraichir</p></div>";
							   		}
								}
								else{
									echo "<div name=\"match_simple\"> <p name=\"titre_match\"> Paris $j </p> <p name=\"nom_match\">Match: <span>{$match[$i]} </span></p><p name=\"error\">Date du match du paris dépassé</p></div>";
							   	}
							   	$y++;
							}
							else{
								echo "<div name=\"match_simple\"> <p name=\"titre_match\"> Paris $j </p> <p name=\"nom_match\">Match: <span>{$match[$i]} </span></p><p name=\"error\">Pas de mise sur le paris</p></div>";
							}
						}	
				    }
				    else{
						echo '<p name=\'error\'>erreur type paris</p>';
					}
			    }
			    else{
			    	echo '<p name=\'error\'>Vous n\'avez pas le solde nécessaire pour le paris</p>';
			    }
		    }
		    else{
		    	echo '<p name=\'error\'>Vous n\'avez pas entrée de mise</p>';
		    }
		}
	}
	else{
		echo '<p name=\'error\'>Veuillez-vous connecter</p>';
	}
	
?>


