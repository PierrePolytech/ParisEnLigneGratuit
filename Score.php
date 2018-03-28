<?php
	include 'function.php';
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))){
		if($_SESSION['niveau']==1){
			if(isset($_POST['Mode'])&&isset($_POST['Sports'])){

				$sports=$_POST['Sports'];
				if($_POST['Mode']=='Ajout Score'){
					echo '<p name="titre">Ajout Score</p>';
					echo '<table><tr><th>Sports</th><th>Ligue</th><th>Match</th><th>Date</th><th>Score</th></tr>';
					if($sports[0]=='Tous'){
						
						$query='SELECT * From Matchs WHERE dateMatch<NOW() AND Score IS NULL OR Score="NULL"';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score"><input type="text" class="form-control" id="Score'.$donnees['idMatch'].'"><a type="submit" class="btn btn-success" onclick="majScore('.$donnees['idMatch'].')" >Modifier</a></td>

								</tr>';
						}
					}
					else{
						$query='SELECT * From Matchs WHERE dateMatch<NOW() AND (Score IS NULL OR Score="NULL") AND nomSport in (\''.implode('\',\'',$sports).'\')';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score"><input type="text" class="form-control" id="Score'.$donnees['idMatch'].'"><a type="submit" class="btn btn-success" onclick="majScore('.$donnees['idMatch'].')" >Modifier</a></td>

								</tr>';
						}
					}
					echo '</table>';
				}
				else if($_POST['Mode']=='Modification Score'){
					echo '<p name="titre">Modification Score</p>';
					echo '<table><tr><th>Sports</th><th>Ligue</th><th>Match</th><th>Date</th><th>Score</th><th></th></tr>';
					if($sports[0]=='Tous'){
						$query='SELECT * From Matchs WHERE dateMatch<NOW() AND Score IS NOT NULL Order by dateMatch desc';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score">'.$donnees['Score'].'</td>

								<td><input type="text" class="form-control" id="Score'.$donnees['idMatch'].'"><a type="submit" class="btn btn-success" onclick="majScore('.$donnees['idMatch'].')" >Modifier</a></td></tr>';
						}
					}
					else{
						$query='SELECT * From Matchs WHERE dateMatch<NOW() AND Score IS NOT NULL AND nomSport in (\''.implode('\',\'',$sports).'\')';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score">'.$donnees['Score'].'</td>

								<td><input type="text" class="form-control" id="Score'.$donnees['idMatch'].'"><a type="submit" class="btn btn-success" onclick="majScore('.$donnees['idMatch'].')" >Modifier</a></td></tr>';
						}
					}
					echo '</table>';
				}
				else if($_POST['Mode']=='Previsualisation Score'){
					echo '<p name="titre">Previsualisation Score</p>';
					echo '<table><tr><th>Sports</th><th>Ligue</th><th>Match</th><th>Date</th><th>Score</th></tr>';
					if($sports[0]=='Tous'){
						$query='SELECT * From Matchs WHERE dateMatch>NOW() AND Score IS NULL';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score">'.$donnees['Score'].'</td>

								</tr>';
						}
					}
					else{
						$query='SELECT * From Matchs WHERE dateMatch<NOW() AND Score IS NULL AND nomSport in (\''.implode('\',\'',$sports).'\')';
						$query=$db->query($query) or die('Erreur'.mysql_error());
						while($donnees=$query->fetch()){
							echo '<tr><td name="nomSport">'.$donnees['nomSport'].'</td><td name="nomEvent">'.$donnees['nomEvent'].'</td><td name="nomMatch">'.$donnees['nomMatch'].'</td><td name="dateMatch">'.$donnees['dateMatch'].'</td><td name="Score">'.$donnees['Score'].'</td>

								</tr>';
						}
					}
					echo '</table>';
				}
			}
			else if(isset($_POST['Id'])&&isset($_POST['Modif'])&&isset($_POST['Mode'])){
				
				$mode=$_POST['Mode'];
				echo $mode;
				if($mode=='Ajout Score'){
					echo 'Ajout';
					//MAJ du score
					$query=$db->prepare('UPDATE Matchs SET Score=:modif WHERE idMatch=:id');
					$query->bindValue(':modif', $_POST['Modif'], PDO::PARAM_STR);
					$query->bindValue(':id',$_POST['Id'], PDO::PARAM_INT);
					$query->execute();
					//SELECT nomSport et Score 
					$req_compte='SELECT nomSport,Score FROM Matchs WHERE Matchs.idMatch= '.$_POST['Id'].';';
					$result = $db->query($req_compte);
					$res=$result->fetchAll();
					foreach ($res as $ligne) {
					    $nomSport=$ligne['nomSport'];
					    $Score=$ligne['Score'];
					}
					echo $Score.'/'.$nomSport;
					//Calcule Gain si situation GAGNER
					$query1='SELECT idParis,typeParis,codeBet,vainqueur,mise,cote,idMembres from Paris WHERE Paris.idMatch='.$_POST['Id'].'';
					$query1=$db->query($query1) or die('Erreur'.mysql_error());
					while($donnees1=$query1->fetch()){
						
						//Situation du Paris 
						if(preg_match('/Win/',$donnees1['codeBet'])||preg_match('/Rwi/',$donnees1['codeBet'])){
	                		if($donnees1['vainqueur']==$Score){
	                			$situation="Gagner";
	                		}
	                		else{
	                			$situation="Perdu";
	                		}
	                	}
	                	else{
	                		$situation=Update_situation_paris($nomSport,$donnees1['codeBet'],$donnees1['vainqueur'],$Score);
	                	} 
	                	echo 'Paris'.$donnees1['idParis'].'/'.$Score.'/'.$donnees1['codeBet'].'/'.$donnees1['vainqueur'].'/'.$situation;
	                	//MAJ SCORE
	                	if($donnees1['typeParis']=="Simple"){
	                		echo 'Simple';
		                	if($situation=="Gagner"){
		                		echo 'Gagner';
		                		//MAJ score joueur
		                        $gain=round($donnees1['mise']*$donnees1['cote'],2);
		                        $requete_point='UPDATE Membres SET points=points+'.$gain.' WHERE idMembres='.$donnees1['idMembres'].'';
		                        $query2=$db->prepare($requete_point);
		                        $query2->execute();  
		                        //MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Gagner" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute(); 
		                	}
		                	else if($situation=="Perdu"){
		                		echo 'Perdu';
		                		//MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Perdu" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute();
		                	}
		                	else if($situation=="Attente"){
		                		echo 'Attente';
		                		//MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Attente" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute();
		                	}
		                }
		                else if($donnees1['typeParis']=="Combine"){
		                	echo 'Combine';
		                	if($situation=="Gagner"){
		                        //MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Gagner" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute(); 
		                	}
		                	else if($situation=="Perdu"){
		                		//MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Perdu" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute();
		                	}
		                	else if($situation=="Attente"){
		                		//MAJ situation Paris
							    $requete_situation='UPDATE Paris SET situation="Attente" WHERE idParis='.$donnees1['idParis'].'';
							    $query2=$db->prepare($requete_situation);
							    $query2->execute();
		                	}
					echo 'idParis'.$donnees1['idParis'].'/';
		                	$query3='SELECT idGroupe,mise from Paris natural join Paris_Combine WHERE idParis='.$donnees1['idParis'].'';
							$query3=$db->query($query3) or die('Erreur'.mysql_error());
							while($donnees3=$query3->fetch()){
								$cote=1;
								$situation2="Gagner";
								$query4='SELECT idParis,situation,cote from Paris natural join Paris_Combine WHERE idMembres='.$donnees1['idMembres'].' AND idGroupe='.$donnees3['idGroupe'].'';
								$query4=$db->query($query4) or die('Erreur'.mysql_error());
								while($donnees4=$query4->fetch()){
									if(($donnees4['situation']=="Attente")&&($situation2!="Perdu")){
										$situation2="Attente";
									}
									else if(($donnees4['situation']=="Perdu")){
										$situation2="Perdu";
									}
									$cote=$cote*$donnees4['cote'];
								}
								if ($situation2=="Gagner"){
									$gain=round(($donnees3['mise']*$cote),2);
									//UPDATE POINT
									$requete_situation='UPDATE Membres SET points=points+'.$gain.' WHERE idMembres='.$donnees1['idMembres'].'';
								    $query5=$db->prepare($requete_situation);
								    $query5->execute();
								}
							}
		                }
					}
				}
				else if($mode=='Modification Score'){
					if($_POST['Modif']=="NULL"){
						//MAJ du score
						$query=$db->prepare('UPDATE Matchs SET Score=:modif WHERE idMatch=:id');
						$query->bindValue(':modif', $_POST['Modif'], PDO::PARAM_STR);
						$query->bindValue(':id',$_POST['Id'], PDO::PARAM_INT);
						$query->execute();
						GestionModifScore($_POST['Id']);
						$query1='SELECT idParis,typeParis,codeBet,vainqueur,mise,cote,idMembres from Paris WHERE Paris.idMatch='.$_POST['Id'].'';
						$query1=$db->query($query1) or die('Erreur'.mysql_error());
						while($donnees1=$query1->fetch()){
							$requete_situation='UPDATE Paris SET situation="Attente" WHERE idParis='.$donnees1['idParis'].'';
						    $query2=$db->prepare($requete_situation);
						    $query2->execute();
						}
					}
					else{
						//MAJ du score
						$query=$db->prepare('UPDATE Matchs SET Score=:modif WHERE idMatch=:id');
						$query->bindValue(':modif', $_POST['Modif'], PDO::PARAM_STR);
						$query->bindValue(':id',$_POST['Id'], PDO::PARAM_INT);
						$query->execute();
						//SELECT nomSport et Score 
						$req_compte='SELECT nomSport,Score FROM Matchs WHERE Matchs.idMatch= '.$_POST['Id'].';';
						$result = $db->query($req_compte);
						$res=$result->fetchAll();
						foreach ($res as $ligne) {
						    $nomSport=$ligne['nomSport'];
						    $Score=$ligne['Score'];
						}
						echo $Score.'/'.$nomSport;
						//MAJ Score joueur (si paris déjà gagné)
							GestionModifScore($_POST['Id']);
						//Calcule Gain si situation GAGNER
						$query1='SELECT idParis,typeParis,codeBet,vainqueur,mise,cote,idMembres from Paris WHERE Paris.idMatch='.$_POST['Id'].'';
						$query1=$db->query($query1) or die('Erreur'.mysql_error());
						while($donnees1=$query1->fetch()){
							
							//Situation du Paris 
							if(preg_match('/Win/',$donnees1['codeBet'])||preg_match('/Rwi/',$donnees1['codeBet'])){
		                		if($donnees1['vainqueur']==$Score){
		                			$situation="Gagner";
		                		}
		                		else{
		                			$situation="Perdu";
		                		}
		                	}
		                	else{
		                		$situation=Update_situation_paris($nomSport,$donnees1['codeBet'],$donnees1['vainqueur'],$Score);
		                	} 
		                	echo 'Paris'.$donnees1['idParis'].'/'.$Score.'/'.$donnees1['codeBet'].'/'.$donnees1['vainqueur'].'/'.$situation;
		                	//MAJ SCORE
		                	if($donnees1['typeParis']=="Simple"){
		                		echo 'Simple';
			                	if($situation=="Gagner"){
			                		echo 'Gagner';
			                		//MAJ score joueur
			                        $gain=round($donnees1['mise']*$donnees1['cote'],2);
			                        $requete_point='UPDATE Membres SET points=points+'.$gain.' WHERE idMembres='.$donnees1['idMembres'].'';
			                        $query2=$db->prepare($requete_point);
			                        $query2->execute();  
			                        //MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Gagner" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute(); 
			                	}
			                	else if($situation=="Perdu"){
			                		echo 'Perdu';
			                		//MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Perdu" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute();
			                	}
			                	else if($situation=="Attente"){
			                		echo 'Attente';
			                		//MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Attente" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute();
			                	}
			                }
			                else if($donnees1['typeParis']=="Combine"){
			                	echo 'Combine';
			                	if($situation=="Gagner"){
			                        //MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Gagner" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute(); 
			                	}
			                	else if($situation=="Perdu"){
			                		//MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Perdu" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute();
			                	}
			                	else if($situation=="Attente"){
			                		//MAJ situation Paris
								    $requete_situation='UPDATE Paris SET situation="Attente" WHERE idParis='.$donnees1['idParis'].'';
								    $query2=$db->prepare($requete_situation);
								    $query2->execute();
			                	}
						echo 'idParis'.$donnees1['idParis'].'/';
			                	$query3='SELECT idGroupe,mise from Paris natural join Paris_Combine WHERE idParis='.$donnees1['idParis'].'';
								$query3=$db->query($query3) or die('Erreur'.mysql_error());
								while($donnees3=$query3->fetch()){
									$cote=1;
									$situation2="Gagner";
									$query4='SELECT idParis,situation,cote from Paris natural join Paris_Combine WHERE idMembres='.$donnees1['idMembres'].' AND idGroupe='.$donnees3['idGroupe'].'';
									$query4=$db->query($query4) or die('Erreur'.mysql_error());
									while($donnees4=$query4->fetch()){
										if(($donnees4['situation']=="Attente")&&($situation2!="Perdu")){
											$situation2="Attente";
										}
										else if(($donnees4['situation']=="Perdu")){
											$situation2="Perdu";
										}
										$cote=$cote*$donnees4['cote'];
									}
									if ($situation2=="Gagner"){
										$gain=round(($donnees3['mise']*$cote),2);
										//UPDATE POINT
										$requete_situation='UPDATE Membres SET points=points+'.$gain.' WHERE idMembres='.$donnees1['idMembres'].'';
									    $query5=$db->prepare($requete_situation);
									    $query5->execute();
									}
								}
			                }
						}
					}
				}				
			}
		}
		else{
			header('Location: index.php'); 
			exit();
		}
	}
	else{
		echo 'Erreur';
	}

function GestionModifScore($idMatch){
	include('identifiant.php');
	echo 'GestionModifScore';
	$querygestion='SELECT idMembres,situation,idParis,typeParis,ROUND(cote*mise,2) as gain from Paris WHERE Paris.idMatch='.$idMatch.'';
	$querygestion=$db->query($querygestion) or die('Erreur'.mysql_error());
	while($donneesgestion=$querygestion->fetch()){
		echo 'While';
		if(($donneesgestion['typeParis']=="Simple")&&($donneesgestion['situation']=='Gagner')){
			echo 'UPDATE SIMPLE/'.$donneesgestion['gain'];
			//UPDATE POINT
			$requete_situation='UPDATE Membres SET points=points-'.$donneesgestion['gain'].' WHERE idMembres='.$donneesgestion['idMembres'].'';
		    $query8=$db->prepare($requete_situation);
		    $query8->execute();
		}
		else if($donneesgestion['typeParis']=="Combine"){
			echo 'Update COmbine';
			$query8='SELECT idGroupe,mise from Paris natural join Paris_Combine WHERE Paris.idMatch='.$idMatch.'';
			$query8=$db->query($query8) or die('Erreur'.mysql_error());
			while($donnees8=$query8->fetch()){
				$cote=1;
				$situation2="Gagner";
				$query9='SELECT idParis,situation,cote from Paris natural join Paris_Combine WHERE idMembres='.$donneesgestion['idMembres'].' AND idGroupe='.$donnees8['idGroupe'].'';
				$query9=$db->query($query9) or die('Erreur'.mysql_error());
				while($donnees9=$query9->fetch()){
					if(($donnees9['situation']=="Attente")&&($situation2!="Perdu")){
						$situation2="Attente";
					}
					else if(($donnees9['situation']=="Perdu")){
						$situation2="Perdu";
					}
					$cote=$cote*$donnees9['cote'];
				}
				if ($situation2=="Gagner"){
					$gain=round(($donnees8['mise']*$cote),2);
					//UPDATE POINT
					$requete_situation='UPDATE Membres SET points=points-'.$gain.' WHERE idMembres='.$donneesgestion['idMembres'].'';
				    $query2=$db->prepare($requete_situation);
				    $query2->execute();
				}
			}
		}
	}
}
function Update_situation_paris($nomSport,$codeBet,$vainqueurParis,$Score){
	switch ($nomSport) {
		case 'Football':
			switch ($codeBet) {
				case 'Ftb_Mr3':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if($vainqueur==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;
				case 'Ftb_Tgl':
					$resultat=preg_split('/-/',$Score);
					$vainqueur=trim($resultat[0])+trim($resultat[1]);
					if(preg_match('/\+/', $vainqueurParis)){
						$vainqueurParis=$vainqueurParis{0};
						if($vainqueurParis<=$vainqueur){return 'Gagner';}
						else{return 'Perdu';}
					}
					else{
						$vainqueurParis=preg_split('/-/',$vainqueurParis);
						if(($vainqueurParis[0]==$vainqueur)||($vainqueurParis[1]==$vainqueur)){return 'Gagner';}
						else{return'Perdu';}
					}
					break;	
				case 'Ftb_Tgl2':
					$resultat=preg_split('/-/',$Score);
					$vainqueur=trim($resultat[0])+trim($resultat[1]);
					if(preg_match('/\+/', $vainqueurParis)){
						$vainqueurParis=$vainqueurParis{0};
						if($vainqueurParis<=$vainqueur){return 'Gagner';}
						else{return 'Perdu';}
					}
					else{
						if($vainqueurParis==$vainqueur){return 'Gagner';}
						else{return'Perdu';}
					}
					break;	
				case 'Ftb_Csc':
					$Score=preg_replace('/ /','',$Score);
					$vainqueurParis=preg_replace('/ /','',$vainqueurParis);
					if($Score==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;	
				case 'Ftb_10':
					$resultat=preg_split('/-/',$Score);
					$vainqueur=trim($resultat[0])+trim($resultat[1]);
					if(preg_match('/\+/', $vainqueurParis)){
						$vainqueurParis=preg_split('/de /',$vainqueurParis);
						if(floatval(str_replace(',','.',$vainqueurParis[1]))<$vainqueur){
							return 'Gagner';
						}
						else{
							return 'Perdu';
						}
					}
					else if(preg_match('/\-/', $vainqueurParis)){
						$vainqueurParis=preg_split('/de /',$vainqueurParis);
						if(floatval(str_replace(',','.',$vainqueurParis[1]))>$vainqueur){
							return 'Gagner';
						}
						else{
							return'Perdu';
						}
					}
					break;	
				case 'Ftb_Dbc':
					$resultat=preg_split('/-/',$Score);
					$vainqueurParis=preg_split('/ou/',$vainqueurParis);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if((trim($vainqueurParis[0])==$vainqueur)||(trim($vainqueurParis[1])==$vainqueur)){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;
				case 'Ftb_23':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					$ecart1=$resultat[0]-$resultat[1]; //écart pour %1%
					$ecart2=$resultat[1]-$resultat[0]; //écart pour %2%
					if(preg_match('/'.$vainqueur.'/',$vainqueurParis)){
						if(preg_match('/\//', $vainqueurParis)){
							$vainqueurParis=preg_split('/\//',$vainqueurParis);
							for($i=0;$i<count($vainqueurParis);$i++){
								if(preg_match('/'.$vainqueur.'/',$vainqueurParis[$i])){
									if(trim($vainqueurParis[$i])==$vainqueur){
										return 'Gagner';
									}
									else if(preg_match('/\+/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else if(preg_match('/-/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else if(preg_match('/exactement/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1==$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2==$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else{
										return 'Perdu';
									}
								}
							}
						}
						else{
							if(trim($vainqueurParis)==$vainqueur){
								return 'Gagner';
							}
							else if(preg_match('/\+/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else if(preg_match('/-/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else if(preg_match('/exactement/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1==$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2==$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else{
								return 'Perdu';
							}
						}
						
					}
					else{
						return'Perdu';
					}
					break;	
				default:
					return 'Attente';
					break;
			}	
			break;
		case 'Basket-ball':
			switch ($codeBet) {
				case 'Bkb_Mr6':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if($vainqueur==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;
				case 'Bkb_Tpt':
					$resultat=preg_split('/-/',$Score);
					$points=$resultat[0]+$resultat[1];
					if(preg_match('/\+/', $vainqueurParis)){
						preg_match('/([0-9])+,[0-9]+/', $vainqueurParis, $matches);
						if($points>floatval(str_replace(',','.',$matches[0]))){
							return 'Gagner';
						}
						else {
							return "Perdu";
						}
					}
					else if(preg_match('/-/', $vainqueurParis)){
						preg_match('/([0-9])+,[0-9]+/', $vainqueurParis, $matches);
						if($points<floatval(str_replace(',','.',$matches[0]))){
							return 'Gagner';
						}
						else {
							return "Perdu";
						}
					}
					break;
				case 'Bkb_Han':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					$ecart1=$resultat[0]-$resultat[1]; //écart pour %1%
					$ecart2=$resultat[1]-$resultat[0]; //écart pour %2%
					if(preg_match('/'.$vainqueur.'/',$vainqueurParis)){
						if(preg_match('/\//', $vainqueurParis)){
							$vainqueurParis=preg_split('/\//',$vainqueurParis);
							for($i=0;$i<count($vainqueurParis);$i++){
								if(preg_match('/'.$vainqueur.'/',$vainqueurParis[$i])){
									if(trim($vainqueurParis[$i])==$vainqueur){
										return 'Gagner';
									}
									else if(preg_match('/plus/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else if(preg_match('/moins/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else{
										return 'Perdu';
									}
								}
							}
						}
						else{
							if(trim($vainqueurParis)==$vainqueur){
								return 'Gagner';
							}
							else if(preg_match('/plus/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else if(preg_match('/moins/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else{
								return 'Perdu';
							}
						}
						
					}
					else{
						return'Perdu';
					}
					break;
				default:
					return 'Attente';
					break;
			}
			break;
		case 'Tennis':
			switch ($codeBet) {
				case 'Ten_Mr2':
					$nbset1=0;
					$nbset2=0;
					$set=preg_split('/-/',$Score);
					for($i=0;$i<count($set);$i++){
					    $jeu=preg_split('/\//',$set[$i]);
					    if($jeu[0]>$jeu[1]){
					        $nbset1++;
					    }
					    else if($jeu[1]>$jeu[0]){
					        $nbset2++;
					    }
					    else{
					        return 'Attente';
					    }
					}
					if($nbset1>$nbset2){
					    if(trim($vainqueurParis)=='%1%'){
					        return 'Gagner';
					    }
					    else{
					        return 'Perdu';
					    }
					}
					else if($nbset2>$nbset1){
					    if(trim($vainqueurParis)=='%2%'){
					        return 'Gagner';
					    }
					    else{
					        return 'Perdu';
					    }
					}
					else{
					    return 'Attente';
					}
					break;	
				case 'Ten_Tse':
					$set=preg_split('/-/',$Score);
					$nbSetParis=preg_split('/sets/',$vainqueurParis);
					if(trim($nbSetParis[0])==count($set)){
						return'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;	
				case 'Ten_Tgm':
					$nbjeux=0;
					$set=preg_split('/-/',$Score);
					for($i=0;$i<count($set);$i++){
					    $jeu=preg_split('/\//',$set[$i]);
					    $nbjeux=$nbjeux+$jeu[0]+$jeu[1];
					}
					print($Score.'/'.$vainqueurParis.'/'.$nbjeux);
					if(preg_match('/\+/', $vainqueurParis)){
					    $vainqueur=preg_split('/de/',$vainqueurParis);
					    if($nbjeux>floatval(floatval(trim(str_replace(',','.',$vainqueur[1]))))){
					        print 'Gagner';
					    }
					    else{
					        print 'Perdu';
					    }
					}
					else if(preg_match('/-/', $vainqueurParis)){
					    $vainqueur=preg_split('/de/',$vainqueurParis);
					    if($nbjeux<floatval(floatval(trim(str_replace(',','.',$vainqueur[1]))))){
					        print 'Gagner';
					    }
					    else{
					        print 'Perdu';
					    }
					}
					else{
					    return 'Attente';
					}
					break;		
				default:
					return 'Attente';
					break;
			}
			break;
		case 'Football américain':
			switch ($codeBet) {
				case 'Amf_Mrs':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if($vainqueur==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;	
				case 'Amf_Han':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					$ecart1=$resultat[0]-$resultat[1]; //écart pour %1%
					$ecart2=$resultat[1]-$resultat[0]; //écart pour %2%
					if(preg_match('/'.$vainqueur.'/',$vainqueurParis)){
						if(preg_match('/\//', $vainqueurParis)){
							$vainqueurParis=preg_split('/\//',$vainqueurParis);
							for($i=0;$i<count($vainqueurParis);$i++){
								if(preg_match('/'.$vainqueur.'/',$vainqueurParis[$i])){
									if(trim($vainqueurParis[$i])==$vainqueur){
										return 'Gagner';
									}
									else if(preg_match('/plus/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2>$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else if(preg_match('/moins/', $vainqueurParis[$i])){
										preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
										if($vainqueur=="%1%"){
											if($ecart1<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
										else if($vainqueur=="%2%"){
											if($ecart2<$matches[0]){return 'Gagner';}
											else{ return "Perdu";}
										}
									}
									else{
										return 'Perdu';
									}
								}
							}
						}
						else{
							if(trim($vainqueurParis)==$vainqueur){
								return 'Gagner';
							}
							else if(preg_match('/plus/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2>$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else if(preg_match('/moins/', $vainqueurParis)){
								preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
								if($vainqueur=="%1%"){
									if($ecart1<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
								else if($vainqueur=="%2%"){
									if($ecart2<$matches[0]){return 'Gagner';}
									else{ return "Perdu";}
								}
							}
							else{
								return 'Perdu';
							}
						}
						
					}
					else{
						return'Perdu';
					}
					break;	
				case 'Amf_Tpt':
					$resultat=preg_split('/-/',$Score);
					$points=$resultat[0]+$resultat[1];
					if(preg_match('/\+/', $vainqueurParis)){
						preg_match('/([0-9])+,[0-9]+/', $vainqueurParis, $matches);
						if($points>floatval(str_replace(',','.',$matches[0]))){
							return 'Gagner';
						}
						else {
							return "Perdu";
						}
					}
					else if(preg_match('/-/', $vainqueurParis)){
						preg_match('/([0-9])+,[0-9]+/', $vainqueurParis, $matches);
						if($points<floatval(str_replace(',','.',$matches[0]))){
							return 'Gagner';
						}
						else {
							return "Perdu";
						}
					}
					break;		
				default:
					return 'Attente';
					break;
			}
			break;
		case 'Rugby à XV':
			switch ($codeBet) {
				case 'Rgb_Mr3':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if($vainqueur==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;
				case 'Rgb_Hp2':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					preg_match('/([0-9])+.([0-9])+/', $vainqueurParis, $matches);
					if(preg_match('/%1%/',$vainqueurParis)){
						if(preg_match('/\+/', $vainqueurParis)){
							if($resultat[0]+$matches[0]>$resultat[1]){return'Gagner';}
							else{ return 'Perdu';}
						}
						else if(preg_match('/-/', $vainqueurParis)){
							if($resultat[0]-$matches[0]>$resultat[1]){return'Gagner';}
							else{ return 'Perdu';}
						}
						else{
							return 'Perdu';
						}
					}
					else if(preg_match('/%2%/',$vainqueurParis)){
						if(preg_match('/\+/', $vainqueurParis)){
							if($resultat[1]+$matches[0]>$resultat[0]){return'Gagner';}
							else{ return 'Perdu';}
						}
						else if(preg_match('/-/', $vainqueurParis)){
							if($resultat[1]-$matches[0]>$resultat[0]){return'Gagner';}
							else{ return 'Perdu';}
						}
						else{
							return 'Perdu';
						}

					}
					else{
						return 'Perdu';
					}	
					break;
				case 'Rgb_Han':
					$resultat=preg_split('/-/',$Score);
					if(preg_match('/\+/', $vainqueurParis)){
						preg_match('/\+([0-9])+/', $vainqueurParis, $matches);
					}
					else if(preg_match('/-/', $vainqueurParis)){
						preg_match('/-([0-9])+/', $vainqueurParis, $matches);
					}
					$handicap=substr($matches[0],1);
					if(preg_match('/Nul/',$vainqueurParis)){
						if(preg_match('/%1%/',$vainqueurParis)){
							if(preg_match('/\+/', $vainqueurParis)){
								if($resultat[0]+$handicap==$resultat[1]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else if(preg_match('/-/', $vainqueurParis)){
								if($resultat[0]-$handicap==$resultat[1]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else{
								return 'Perdu';
							}
						}
						else if(preg_match('/%2%/',$vainqueurParis)){
							if(preg_match('/\+/', $vainqueurParis)){
								if($resultat[1]+$handicap==$resultat[0]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else if(preg_match('/-/', $vainqueurParis)){
								if($resultat[1]-$handicap==$resultat[0]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else{
								return 'Perdu';
							}
						}
						else{
							return 'Perdu';
						}
					}
					else{
						if(preg_match('/%1%/',$vainqueurParis)){
							if(preg_match('/\+/', $vainqueurParis)){
								if($resultat[0]+$handicap>$resultat[1]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else if(preg_match('/-/', $vainqueurParis)){
								if($resultat[0]-$handicap>$resultat[1]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else{
								return 'Perdu';
							}
						}
						else if(preg_match('/%2%/',$vainqueurParis)){
							if(preg_match('/\+/', $vainqueurParis)){
								if($resultat[1]+$handicap>$resultat[0]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else if(preg_match('/-/', $vainqueurParis)){
								if($resultat[1]-$handicap>$resultat[0]){return'Gagner';}
								else{ return 'Perdu';}
							}
							else{
								return 'Perdu';
							}

						}
						else{
							return 'Perdu';
						}
					}
					break;
				case 'Rgb_Tpt':
					$resultat=preg_split('/-/',$Score);
					$nbPoints=trim($resultat[0])+trim($resultat[1]);
					$Resultat_match=preg_split('/de/',$vainqueurParis);

					if(preg_match('/\+/', $vainqueurParis)){
						if($nbPoints>trim($Resultat_match[1])){return'Gagner';}
						else{ return 'Perdu';}
					}
					else if(preg_match('/-/', $vainqueurParis)){
						if($nbPoints<trim($Resultat_match[1])){return'Gagner';}
						else{ return 'Perdu';}
					}
					else{
						return 'Perdu';
					}
					break;
				default:
					return 'Attente';
					break;
			}
			break;
		case 'Handball':
			switch ($codeBet) {
				case 'Hdb_Mr3':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
						$vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
						$vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
						$vainqueur='%2%';
					}
					if($vainqueur==$vainqueurParis){
						return 'Gagner';
					}
					else{
						return 'Perdu';
					}
					break;
				case 'Hdb_Han':
					$resultat=preg_split('/-/',$Score);
					if(trim($resultat[0])>trim($resultat[1])){
					    $vainqueur='%1%';
					}
					else if(trim($resultat[0])==trim($resultat[1])){
					    $vainqueur='Nul';
					}
					else if(trim($resultat[0])<trim($resultat[1])){
					    $vainqueur='%2%';
					}
					$ecart1=$resultat[0]-$resultat[1]; //écart pour %1%
					$ecart2=$resultat[1]-$resultat[0]; //écart pour %2%
					if(preg_match('/'.$vainqueur.'/',$vainqueurParis)){
					    if(preg_match('/\//', $vainqueurParis)){
					        $vainqueurParis=preg_split('/\//',$vainqueurParis);
					        for($i=0;$i<count($vainqueurParis);$i++){
					            if(preg_match('/'.$vainqueur.'/',$vainqueurParis[$i])){
					                if(trim($vainqueurParis[$i])==$vainqueur){
					                    return 'Gagner';
					                }
					                else if(preg_match('/plus/', $vainqueurParis[$i])){
					                    preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
					                    if($vainqueur=="%1%"){
					                        if($ecart1>$matches[0]){return 'Gagner';}
					                        else{ return "Perdu";}
					                    }
					                    else if($vainqueur=="%2%"){
					                        if($ecart2>$matches[0]){return 'Gagner';}
					                        else{ return "Perdu";}
					                    }
					                }
					                else if(preg_match('/moins/', $vainqueurParis[$i])){
					                    preg_match('/ ([0-9])+/', $vainqueurParis[$i], $matches);
					                    if($vainqueur=="%1%"){
					                        if($ecart1<$matches[0]){return 'Gagner';}
					                        else{ return "Perdu";}
					                    }
					                    else if($vainqueur=="%2%"){
					                        if($ecart2<$matches[0]){return 'Gagner';}
					                        else{ return "Perdu";}
					                    }
					                }
					                else{
					                    return 'Perdu';
					                }
					            }
					        }
					    }
					    else{
					        if(trim($vainqueurParis)==$vainqueur){
					            return 'Gagner';
					        }
					        else if(preg_match('/plus/', $vainqueurParis)){
					            preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
					            if($vainqueur=="%1%"){
					                if($ecart1>$matches[0]){return 'Gagner';}
					                else{ return "Perdu";}
					            }
					            else if($vainqueur=="%2%"){
					                if($ecart2>$matches[0]){return 'Gagner';}
					                else{ return "Perdu";}
					            }
					        }
					        else if(preg_match('/moins/', $vainqueurParis)){
					            preg_match('/ ([0-9])+/', $vainqueurParis, $matches);
					            if($vainqueur=="%1%"){
					                if($ecart1<$matches[0]){return 'Gagner';}
					                else{ return "Perdu";}
					            }
					            else if($vainqueur=="%2%"){
					                if($ecart2<$matches[0]){return 'Gagner';}
					                else{ return "Perdu";}
					            }
					        }
					        else{
					            return 'Perdu';
					        }
					    }
					    
					}
					else{
					    return'Perdu';
					}
					break;
				case 'Hdb_Tgt':
					$resultat=preg_split('/-/',$Score);
					$nbPoints=trim($resultat[0])+trim($resultat[1]);
					$Resultat_match=preg_split('/de/',$vainqueurParis);

					if(preg_match('/\+/', $vainqueurParis)){
						if($nbPoints>trim($Resultat_match[1])){return'Gagner';}
						else{ return 'Perdu';}
					}
					else if(preg_match('/-/', $vainqueurParis)){
						if($nbPoints<trim($Resultat_match[1])){return'Gagner';}
						else{ return 'Perdu';}
					}
					else{
						return 'Perdu';
					}
					break;
				default:
					return 'Attente';
					break;
			}
		break;	
	}
}
?>

