<?php
	include('identifiant.php');
	session_start();
	if(isset($_SESSION['id'])){
		if(isset($_POST['range'])){
			//Requete point actuel
			$range=$_POST['range'];
			$requete_solde='SELECT points,sommeTotaleRechargement FROM Membres WHERE idMembres='.$_SESSION['id'].'';
		    $resultat_solde=$db->query($requete_solde) or die ('Erreur'.mysql_error());
		    $columns=$resultat_solde->fetch();
		    $points_actuelle=$columns['points'];
		    $sommerechargement=$columns['sommeTotaleRechargement'];

		    //Suppression rechargement plus d'une semaine
		    $query=$db->prepare('DELETE FROM Rechargement WHERE dateRechargement<(NOW()-INTERVAL 1 WEEK) AND idMembres=:id');
		    $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
			$query->execute();
			//somme recharger cette semaine
			$rechargement_semaine=0;
		    $query='SELECT * FROM Rechargement WHERE dateRechargement>(NOW()-INTERVAL 1 WEEK) AND idMembres='.$_SESSION['id'].'';
			$query=$db->query($query) or die('Erreur'.mysql_error());
			while($donnees=$query->fetch()){
				$rechargement_semaine=$rechargement_semaine+$donnees['sommeRechargement'];
			}

		    if($rechargement_semaine+$range<=100){
		    	$query=$db->prepare('UPDATE Membres SET points=:points WHERE idMembres=:id');
				$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
				$query->bindValue(':points',$points_actuelle+$range, PDO::PARAM_INT);
				$query->execute();

				$query=$db->prepare('UPDATE Membres SET sommeTotaleRechargement=:points WHERE idMembres=:id');
				$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
				$query->bindValue(':points',$sommerechargement+$range, PDO::PARAM_INT);
				$query->execute();
				
				$query=$db->prepare('INSERT INTO Rechargement VALUES (:id,:somme,NOW())');
				$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
				$query->bindValue(':somme', $range, PDO::PARAM_INT);
				$query->execute();
				header('Location: Mes-Statistiques.php');
		    }
		}
		else{
			header('Location: index.php');
		}
	}
	else{
		header('Location: index.php');
	}
?>