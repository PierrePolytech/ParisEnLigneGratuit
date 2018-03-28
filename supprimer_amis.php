

<?php
	include 'function.php';
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		if((isset($_POST['Pseudo']))&&(isset($_POST['Mode']))){
			$pseudo=$_POST['Pseudo'];
			$mode=$_POST['Mode'];
			if($mode=="supprimer"){
				$req_compte='SELECT idMembres FROM Membres WHERE pseudo= "'.$pseudo.'";';
		        $result = $db->query($req_compte);
		        $res=$result->fetchAll();
		        $nb_compte=count($res);
		        if($nb_compte==1){
		            foreach ($res as $ligne) {
		                $id=$ligne['idMembres'];
		            }
		            $query=$db->prepare('DELETE from Amis Where idTo=:idto AND idFrom=:idfrom');
		            $query->bindValue(':idto', $_SESSION['id'], PDO::PARAM_INT);
		            $query->bindValue(':idfrom',$id, PDO::PARAM_INT);
		            $query->execute(); 
		            $query=$db->prepare('DELETE from Amis Where idTo=:idto AND idFrom=:idfrom');
		            $query->bindValue(':idto',$id, PDO::PARAM_INT);
		            $query->bindValue(':idfrom',$_SESSION['id'], PDO::PARAM_INT);
		            $query->execute();
				}	
			}
			else if($mode=="ajout"){
				$req_compte='SELECT idMembres FROM Membres WHERE pseudo= "'.$pseudo.'";';
		        $result = $db->query($req_compte);
		        $res=$result->fetchAll();
		        $nb_compte=count($res);
		        if($nb_compte==1){
		        	foreach ($res as $ligne) {
		                $id=$ligne['idMembres'];
		            }
		            $query=$db->prepare('UPDATE Amis SET status=2 Where idTo=:idto AND idFrom=:idfrom');
		            $query->bindValue(':idto', $_SESSION['id'], PDO::PARAM_INT);
		            $query->bindValue(':idfrom',$id, PDO::PARAM_INT);
		            $query->execute(); 
		            $query=$db->prepare('UPDATE Amis SET status=2 Where idTo=:idto AND idFrom=:idfrom');
		            $query->bindValue(':idto',$id, PDO::PARAM_INT);
		            $query->bindValue(':idfrom',$_SESSION['id'], PDO::PARAM_INT);
		            $query->execute();
		        }
			}
		}
	}		   
	else{
		echo '<p name=\'error\'>Veuillez-vous connecter</p>';
	}
?>

