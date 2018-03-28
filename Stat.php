<?php
	include 'function.php';
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		if(isset($_POST['Mode'])){
			$mode=$_POST['Mode'];
			if($mode=="Paris"){
				/*---------------------------------------------------------PARIS--------------------------*/
				
				//PARCOURS COMBINE
				
				$cotegagner=0;$coteperdu=0;$coteattente=0;
				$attente=0;$perdu=0;$gagner=0;
				$miseattente=0;$miseperdu=0;$misegagner=0;
				$gain_potentiel=0;
				$gain=0;$gainreel=0;
				$query='SELECT distinct(idGroupe),mise from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].'';
				$query=$db->query($query) or die('Erreur'.mysql_error());
				while($donnees=$query->fetch()){
					$cote=1;
					$situation="Gagner";
					$query2='SELECT idParis,situation,cote,mise from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].'';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					while($donnees2=$query2->fetch()){
						if(($donnees2['situation']=="Attente")&&($situation!="Perdu")){
							$situation="Attente";
						}
						else if(($donnees2['situation']=="Perdu")){
							$situation="Perdu";
						}
						$cote=$cote*$donnees2['cote'];
					}
					if ($situation=="Attente"){
						$attente++;
						$miseattente=$miseattente+$donnees['mise'];
						$coteattente=$coteattente+$cote;
						$gain_potentiel=$gain_potentiel+round($donnees['mise']*$cote,2);
					}
					else if ($situation=="Gagner"){
						$gagner++;
						$misegagner=$misegagner+$donnees['mise'];
						$cotegagner=$cotegagner+$cote;
						$gain=$gain+round(($donnees['mise']*$cote),2);
						$gainreel=$gainreel+round(($donnees['mise']*$cote)-$donnees['mise'],2);
					}
					else if ($situation=="Perdu"){
						$perdu++;
						$miseperdu=$miseperdu+$donnees['mise'];
						$coteperdu=$coteperdu+$cote;
					}
				}

				//GAGNER 
				$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Gagner" AND Paris.typeParis="Simple"';
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_gagner = intval($columns['nb']);
		   		$nb_Paris_gagner=$nb_Paris_gagner+$gagner;
		   		//PERDU
		   		$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Perdu" AND Paris.typeParis="Simple"';
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_perdu= intval($columns['nb']);
		   		$nb_Paris_perdu=$nb_Paris_perdu+$perdu;
		   		//ATTENTE
		   		$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente" AND Paris.typeParis="Simple"';
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_attente = intval($columns['nb']);
		   		$nb_Paris_attente=$nb_Paris_attente+$attente;

		   		//SOMME
		   		$nb_Paris=$nb_Paris_gagner+$nb_Paris_perdu+$nb_Paris_attente;

		   		//MISE GAGNER
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale,SUM(ROUND(cote*mise,2)) as gain,SUM(ROUND((cote*mise)-mise,2)) as gainR from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Gagner" AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		   		if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_gagner= 0;
		    	}
		    	else{
		    		$mise_totale_gagner= $columns['Mise_Totale'];
		    	}
		    	if(!(is_null($columns['Cote_Totale']))){
		    		$cotegagner=$cotegagner+$columns['Cote_Totale'];
		    	}
		    	if(!(is_null($columns['gain']))){
		    		$gain=$gain+$columns['gain'];
		    	}
		    	if(!(is_null($columns['gainR']))){
		    		$gainreel=$gainreel+$columns['gainR'];
		    	}
		    	$mise_totale_gagner=$mise_totale_gagner+$misegagner;
		   		//MISE PERDU
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Perdu" AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		    	if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_perdu= 0;
		    	}
		    	else{
		    		$mise_totale_perdu= $columns['Mise_Totale'];
		    	}
		    	$mise_totale_perdu=$mise_totale_perdu+$miseperdu;
		    	if(!(is_null($columns['Cote_Totale']))){
		    		$coteperdu=$coteperdu+$columns['Cote_Totale'];
		    	}
		   		//MISE ATTENTE
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale,SUM(ROUND(cote*mise,2)) as gain from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente" AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		    	if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_attente= 0;
		    	}
		    	else{
		    		$mise_totale_attente= $columns['Mise_Totale'];
		    	}
		   		$mise_totale_attente=$mise_totale_attente+$miseattente;
		   		if(!(is_null($columns['Cote_Totale']))){
		    		$coteattente=$coteattente+$columns['Cote_Totale'];
		    	}
		    	if(!(is_null($columns['gain']))){
		    		$gain_potentiel=$gain_potentiel+$columns['gain'];
		    	}

		   		//Mise TOTALE
		   		$mise_totale=$mise_totale_perdu+$mise_totale_gagner;
		   		//Cote TOTALE
		   		$cote_totale=$coteperdu+$coteattente+$cotegagner;
		   		//GAIN REEL
		   		$gainreel=$gainreel-$mise_totale_perdu;
		   		//MISE MOYENNE
		   		if($nb_Paris_perdu==0){
		   			$mise_moy_perdu=0;
		   			$cote_moy_perdu=0;
		   		}
		   		else{
		   			$mise_moy_perdu=round($mise_totale_perdu/$nb_Paris_perdu,2);
		   			$cote_moy_perdu=round($coteperdu/$nb_Paris_perdu,2);
		   		}

		   		if($nb_Paris_gagner==0){
		   			$mise_moy_gagner=0;
		   			$cote_moy_gagner=0;
		   		}
		   		else{
		   			$mise_moy_gagner=round($mise_totale_gagner/$nb_Paris_gagner,2);
		   			$cote_moy_gagner=round($cotegagner/$nb_Paris_gagner,2);
		   		}
		   		if($nb_Paris==0){
		   			$mise_moy=0;
		   			$cote_moy=0;
		   		}
		   		else{
		   			$mise_moy=round($mise_totale/$nb_Paris,2);
		   			$cote_moy=round($cote_totale/$nb_Paris,2);
		   		}
		   		$nb1=array('label'=>'Gagner','value'=>$nb_Paris_gagner);
		   		$nb2=array('label'=>'Perdu','value'=>$nb_Paris_perdu);
		   		$array_nb=array($nb1,$nb2);
		   		$cotem1=array('label'=>'Gagner','value'=>$cote_moy_gagner);
		   		$cotem2=array('label'=>'Perdu','value'=>$cote_moy_perdu);
		   		$array_cote_moy=array($cotem1,$cotem2);
		   		$misem1=array('label'=>'Gagner','value'=>$mise_moy_gagner);
		   		$misem2=array('label'=>'Perdu','value'=>$mise_moy_perdu);
		   		$array_mise_moy=array($misem1,$misem2);
		   		$infos_sup1=array('label'=>'MiseTotale','value'=>$mise_totale);
		   		$infos_sup2=array('label'=>'Gain','value'=>$gain);
		   		$infos_sup3=array('label'=>'Perte','value'=>$mise_totale_perdu);
		   		$infos_sup4=array('label'=>'GainReel','value'=>$gainreel);
		   		$array_infos_sup=array($infos_sup1,$infos_sup2,$infos_sup3,$infos_sup4);
		   		$attente1=array('label'=>'nb','value'=>$nb_Paris_attente);
		   		$attente2=array('label'=>'Mise','value'=>$mise_totale_attente);
		   		$attente3=array('label'=>'GainPotentiel','value'=>$gain_potentiel);
		   		$array_attente=array($attente1,$attente2,$attente3);
		   		$array_paris=array("Nombre"=>$array_nb,"Cote_Moy"=>$array_cote_moy,"Mise_Moy"=>$array_mise_moy,"Attente"=>$array_attente,"Infos"=>$array_infos_sup);
		   		$json = json_encode($array_paris);
				echo $json;
			}
			elseif($mode=="ParisS"){
				/*--------------------------------------------------------------------PARIS SIMPLE---------------------------------*/
		   		$coteattente=0;$coteperdu=0;$cotegagner=0;
		   		$gain=0;$gainreel=0;
		   		//GAGNER 
				$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Gagner" AND Paris.typeParis="Simple"';
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_gagner_simple = intval($columns['nb']);
		   		//PERDU
		   		$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Perdu" AND Paris.typeParis="Simple"' ;
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_perdu_simple= intval($columns['nb']);
		   		//ATTENTE
		   		$requete_nb_Paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente" AND Paris.typeParis="Simple"';
				$resultat_nb_Paris=$db->query($requete_nb_Paris) or die('Erreur'.mysql_error());
		    	$columns = $resultat_nb_Paris->fetch();
		   		$nb_Paris_attente_simple = intval($columns['nb']);

		   		//SOMME
		   		$nb_Paris_simple=$nb_Paris_attente_simple+$nb_Paris_perdu_simple+$nb_Paris_gagner_simple;

		   		//MISE GAGNER
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale ,SUM(ROUND(cote*mise,2)) as gain,SUM(ROUND((cote*mise)-mise,2)) as gainR from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Gagner"  AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		   		if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_gagner_simple= 0;
		    	}
		    	else{
		    		$mise_totale_gagner_simple= $columns['Mise_Totale'];
		    	}
		    	if(!(is_null($columns['Cote_Totale']))){
		    		$cotegagner=$cotegagner+$columns['Cote_Totale'];
		    	}
		    	if(!(is_null($columns['gain']))){
		    		$gain=$gain+$columns['gain'];
		    	}
		    	if(!(is_null($columns['gainR']))){
		    		$gainreel=$gainreel+$columns['gainR'];
		    	} 

		   		//MISE PERDU
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Perdu"  AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		    	if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_perdu_simple= 0;
		    	}
		    	else{
		    		$mise_totale_perdu_simple= $columns['Mise_Totale'];
		    	}
		    	if(!(is_null($columns['Cote_Totale']))){
		    		$coteperdu=$coteperdu+$columns['Cote_Totale'];
		    	}

		   		//MISE ATTENTE
		   		$requete_mise='SELECT SUM(ROUND(mise,2)) as Mise_Totale,SUM(ROUND(cote,2)) as Cote_Totale,SUM(ROUND(cote*mise,2)) as gain from Paris WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente"  AND Paris.typeParis="Simple"  GROUP BY idMembres';
		   		$resultat_mise=$db->query($requete_mise) or die('Erreur'.mysql_error());
		    	$columns = $resultat_mise->fetch();
		    	if(is_null($columns['Mise_Totale'])){
		    		$mise_totale_attente_simple= 0;
		    	}
		    	else{
		    		$mise_totale_attente_simple= $columns['Mise_Totale'];
		    	}
		    	if(!(is_null($columns['Cote_Totale']))){
		    		$coteattente=$coteattente+$columns['Cote_Totale'];
		    	}
		    	if(!(is_null($columns['gain']))){
		    		$gain_potentiel_simple=$columns['gain'];
		    	}
		   		//Mise TOTAL
		   		$mise_totale_simple=$mise_totale_perdu_simple+$mise_totale_gagner_simple;
		   		$cote_totale_simple=$coteperdu+$coteattente+$cotegagner;
		   		$gainreel=$gainreel-$mise_totale_perdu_simple;

		   		//MISE MOYENNE
		   		if($nb_Paris_perdu_simple==0){
		   			$mise_moy_perdu_simple=0;
		   			$cote_moy_perdu_simple=0;
		   		}
		   		else{
		   			$mise_moy_perdu_simple=round($mise_totale_perdu_simple/$nb_Paris_perdu_simple,2);
		   			$cote_moy_perdu_simple=round($coteperdu/$nb_Paris_perdu_simple,2);
		   		}

		   		if($nb_Paris_gagner_simple==0){
		   			$mise_moy_gagner_simple=0;
		   			$cote_moy_gagner_simple=0;
		   		}
		   		else{
		   			$mise_moy_gagner_simple=round($mise_totale_gagner_simple/$nb_Paris_gagner_simple,2);
		   			$cote_moy_gagner_simple=round($cotegagner/$nb_Paris_gagner_simple,2);
		   		}
		   		if($nb_Paris_simple==0){
		   			$mise_moy_simple=0;
		   			$cote_moy_simple=0;
		   		}
		   		else{
		   			$mise_moy_simple=round($mise_totale_simple/$nb_Paris_simple,2);
		   			$cote_moy_simple=round($cote_totale_simple/$nb_Paris_simple,2);
		   		}
		   		$nb1=array('label'=>'Gagner','value'=>$nb_Paris_gagner_simple);
		   		$nb2=array('label'=>'Perdu','value'=>$nb_Paris_perdu_simple);
		   		$array_nb=array($nb1,$nb2);
		   		$cotem1=array('label'=>'Gagner','value'=>$cote_moy_gagner_simple);
		   		$cotem2=array('label'=>'Perdu','value'=>$cote_moy_perdu_simple);
		   		$array_cote_moy=array($cotem1,$cotem2);
		   		$misem1=array('label'=>'Gagner','value'=>$mise_moy_gagner_simple);
		   		$misem2=array('label'=>'Perdu','value'=>$mise_moy_perdu_simple);
		   		$array_mise_moy=array($misem1,$misem2);
		   		$infos_sup1=array('label'=>'MiseTotale','value'=>$mise_totale_simple);
		   		$infos_sup2=array('label'=>'Gain','value'=>$gain);
		   		$infos_sup3=array('label'=>'Perte','value'=>$mise_totale_perdu_simple);
		   		$infos_sup4=array('label'=>'GainReel','value'=>$gainreel);
		   		$array_infos_sup=array($infos_sup1,$infos_sup2,$infos_sup3,$infos_sup4);
		   		$attente1=array('label'=>'nb','value'=>$nb_Paris_attente_simple);
		   		$attente2=array('label'=>'Mise','value'=>$mise_totale_attente_simple);
		   		$attente3=array('label'=>'GainPotentiel','value'=>$gain_potentiel_simple);
		   		$array_attente=array($attente1,$attente2,$attente3);
		   		$array_paris=array("Nombre"=>$array_nb,"Cote_Moy"=>$array_cote_moy,"Mise_Moy"=>$array_mise_moy,"Attente"=>$array_attente,"Infos"=>$array_infos_sup);
		   		$json = json_encode($array_paris);
				echo $json;
			}
			elseif ($mode=="ParisC") {
				/*-------------------------------------------------------------PARIS COMBINE-----------------------------------------*/
				$nb_Paris_attente_combine=0;$nb_Paris_perdu_combine=0;$nb_Paris_gagner_combine=0;
				$mise_totale_gagner_combine=0;$mise_totale_perdu_combine=0;$mise_totale_attente_combine=0;
				$gain_potentiel_combine=0;
				$cotegagner=0;$coteattente=0;$coteperdu=0;
				$gain=0;$gainreel=0;
				$query='SELECT distinct(idGroupe),mise from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].'';
				$query=$db->query($query) or die('Erreur'.mysql_error());
				while($donnees=$query->fetch()){
					$cote=1;
					$situation="Gagner";
					$query2='SELECT idParis,situation,cote from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].'';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					while($donnees2=$query2->fetch()){
						if(($donnees2['situation']=="Attente")&&($situation!="Perdu")){
							$situation="Attente";
						}
						else if(($donnees2['situation']=="Perdu")){
							$situation="Perdu";
						}
						$cote=$cote*$donnees2['cote'];
					}
					if ($situation=="Attente"){
						$nb_Paris_attente_combine++;
						$mise_totale_attente_combine=$mise_totale_attente_combine+$donnees['mise'];
						$coteattente=$coteattente+$cote;
						$gain_potentiel_combine=$gain_potentiel_combine+(round($cote*$donnees['mise'],2));
					}
					else if ($situation=="Perdu"){
						$nb_Paris_perdu_combine++;
						$mise_totale_perdu_combine=$mise_totale_perdu_combine+$donnees['mise'];
						$coteperdu=$coteperdu+$cote;
					}
					else if ($situation=="Gagner"){
						$nb_Paris_gagner_combine++;
						$mise_totale_gagner_combine=$mise_totale_gagner_combine+$donnees['mise'];
						$cotegagner=$cotegagner+$cote;
						$gain=$gain+round(($donnees['mise']*$cote),2);
						$gainreel=$gainreel+round(($donnees['mise']*$cote)-$donnees['mise'],2);
					}
				}

		   		//SOMME
		   		$nb_Paris_combine=$nb_Paris_attente_combine+$nb_Paris_perdu_combine+$nb_Paris_gagner_combine;	   		

		   		//Mise TOTAL
		   		$mise_totale_combine=$mise_totale_perdu_combine+$mise_totale_gagner_combine;
		   		$cote_totale_combine=$cotegagner+$coteperdu+$coteattente;
		   		$gainreel=$gainreel-$mise_totale_perdu_combine;
		   		//MISE MOYENNE
		   		if($nb_Paris_perdu_combine==0){
		   			$mise_moy_perdu_combine=0;
		   			$cote_moy_perdu_combine=0;
		   		}
		   		else{
		   			$mise_moy_perdu_combine=round($mise_totale_perdu_combine/$nb_Paris_perdu_combine,2);
		   			$cote_moy_perdu_combine=round($coteperdu/$nb_Paris_perdu_combine,2);
		   		}

		   		if($nb_Paris_gagner_combine==0){
		   			$mise_moy_gagner_combine=0;
		   			$cote_moy_gagner_combine=0;
		   		}
		   		else{
		   			$mise_moy_gagner_combine=round($mise_totale_gagner_combine/$nb_Paris_gagner_combine,2);
		   			$cote_moy_gagner_combine=round($cotegagner/$nb_Paris_gagner_combine,2);
		   		}
		   		if($nb_Paris_combine==0){
		   			$mise_moy_combine=0;
		   			$cote_moy_combine=0;
		   		}
		   		else{
		   			$mise_moy_combine=round($mise_totale_combine/$nb_Paris_combine,2);
		   			$cote_moy_combine=round($cote_totale_combine/$nb_Paris_combine,2);
		   		}

		   		$nb1=array('label'=>'Gagner','value'=>$nb_Paris_gagner_combine);
		   		$nb2=array('label'=>'Perdu','value'=>$nb_Paris_perdu_combine);
		   		$array_nb=array($nb1,$nb2);
		   		$cotem1=array('label'=>'Gagner','value'=>$cote_moy_gagner_combine);
		   		$cotem2=array('label'=>'Perdu','value'=>$cote_moy_perdu_combine);
		   		$array_cote_moy=array($cotem1,$cotem2);
		   		$misem1=array('label'=>'Gagner','value'=>$mise_moy_gagner_combine);
		   		$misem2=array('label'=>'Perdu','value'=>$mise_moy_perdu_combine);
		   		$array_mise_moy=array($misem1,$misem2);
		   		$infos_sup1=array('label'=>'MiseTotale','value'=>$mise_totale_combine);
		   		$infos_sup2=array('label'=>'Gain','value'=>$gain);
		   		$infos_sup3=array('label'=>'Perte','value'=>$mise_totale_perdu_combine);
		   		$infos_sup4=array('label'=>'GainReel','value'=>$gainreel);
		   		$array_infos_sup=array($infos_sup1,$infos_sup2,$infos_sup3,$infos_sup4);
		   		$attente1=array('label'=>'nb','value'=>$nb_Paris_attente_combine);
		   		$attente2=array('label'=>'Mise','value'=>$mise_totale_attente_combine);
		   		$attente3=array('label'=>'GainPotentiel','value'=>$gain_potentiel_combine);
		   		$array_attente=array($attente1,$attente2,$attente3);
		   		$array_paris=array("Nombre"=>$array_nb,"Cote_Moy"=>$array_cote_moy,"Mise_Moy"=>$array_mise_moy,"Attente"=>$array_attente,"Infos"=>$array_infos_sup);
		   		$json = json_encode($array_paris);
				echo $json;
			}
			else{
				echo "erreur";
			}
		}
	}
?>
