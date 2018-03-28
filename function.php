<?php
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


function Verification_Cote($nomSport,$match,$codeBet,$coderesult){
	$dom = new DOMDocument();
	$dom->load('http://xml.cdn.betclic.com/odds_fr.xml');
	$xpath = new DOMXpath($dom);
	$j=0;
	for($i=0;$i<count($match);$i++){
		$elements = $xpath->query('/sports/sport[@name="'.$nomSport[$i].'"]/event/match[@name="'.$match[$i].'"]/bets/bet[@code="'.$codeBet[$i].'"]/choice[@name="'.$coderesult[$i].'"]');
		foreach ($elements as $choix) {
			$cote[$j]=$choix->getAttribute('odd');
			$j++;
		}
	}
	return $cote;
}

function Affichage_menu(){
	$liste_sports = ['Football','Tennis','Formule 1','Basket-ball','Cyclisme','Rugby à XV','Handball','Biathlon','Golf','Nascar','Football américain'];
	$dom = new DOMDocument();
	$dom->load('http://xml.cdn.betclic.com/odds_fr.xml');
	$xpath = new DOMXpath($dom);
	$elements = $xpath->query("/sports/sport");
	$taille = $xpath->query("/sports/sport/event")->length;
	echo '<nav class="nav" role="navigation"><ul class="nav__list">';
	foreach ($elements as $sport) {
		$nom_sport=$sport->getAttribute('name');
		$id_sport=$sport->getAttribute('id');
		if(in_array($nom_sport,$liste_sports)){
			echo '<li><input id="'.$id_sport.'" type="checkbox" hidden/><label name="label_menu" for="'.$id_sport.'"><span class="fa fa-angle-right"></span>'.$nom_sport.'</label>
		<ul class="group-list">';
			$elements2= $xpath->query("./event",$sport);
			foreach ($elements2 as $event) {
				$nom_event=$event->getAttribute('name');
				$id_event=$event->getAttribute('id');
				$nbre_match= $xpath->query("./match",$event)->length;
				echo '<li><a name="a_menu" onclick="Affichage_paris('.$id_sport.','.$id_event.')">'.$nom_event.' ('.$nbre_match.')</a></li>';
			}
			echo '</ul></li>';
		}
	}
	echo '</ul></nav>';	
}


function Affichage_matchs($idsport,$idevent){
	$liste_sports = ['Football','Tennis','Basket-ball','Rugby à XV','Handball','Football américain'];
	$dom = new DOMDocument();
	$dom->load('http://xml.cdn.betclic.com/odds_fr.xml');
	$xpath = new DOMXpath($dom);
	$elements = $xpath->query("/sports/sport[@id=".$idsport."]");
	foreach ($elements as $sport) {
		$nom_sport=$sport->getAttribute('name');
		$elements2 = $xpath->query("./event[@id=".$idevent."]",$sport);
	}
	foreach ($elements2 as $event) {
		$nom_event=$event->getAttribute('name');
		$elements3 = $xpath->query("./match",$event);
	}
	echo '<div name="entete_affichage_match"><p name="nom_sport">'.$nom_sport.'</p> <p name="nom_event">'.$nom_event.'</p></div>';
	
	$date_prec=1;
	echo '<ul>';
	foreach ($elements3 as $match) {
		$nb_matchs=1;
		$nom_match=$match->getAttribute('name');
		$date_match=$match->getAttribute('start_date');
		$id_match=$match->getAttribute('id');
		$elements2= $xpath->query("./bets/bet",$match);
		foreach ($elements2 as $bet) {
			$code_bet=$bet->getAttribute('code');
			$name_bet=$bet->getAttribute('name');
			$id_bet=$bet->getAttribute('id');
			if(preg_match('/Win/',$code_bet)||preg_match('/Rwi/',$code_bet)){
				$elements3= $xpath->query("./choice",$bet);
				echo '<div name="entete_saison"> '.$nom_match.' - Vainqueur</div>';
				$taille= $xpath->query("./choice",$bet)->length;
				$taille=ceil($taille/2);
				$cpt=0;
				echo '<div name="affichage_Win"><div name="colonne">';
				foreach ($elements3 as $choice) {
					$name_choice=$choice->getAttribute('name');
					$cote_choice=$choice->getAttribute('odd');
					$id_choice=$choice->getAttribute('id');
					$name_choice=str_replace("'", "\'",$name_choice);
					if($cpt==$taille){
						echo '</div><div name="colonne">';
					}
					$nom_match1=str_replace("'", "\'", $nom_match);
					echo '<div name="choix_saison"><p name="equipe_saison">'.$name_choice.'</p><div name="div_boutton_saison"><a type="submit" class="btn btn-default" name="boutton_saison" onclick="parier(\''.$nom_match1.'\','.$cote_choice.',\''.$name_choice.'\','.$id_choice.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')">'.$cote_choice.'</a></div></div>';					
					$cpt++;
				}
				echo '</div></div>';
			}
			else if(((preg_match('/Mwi/',$code_bet)||preg_match('/Mr2/',$code_bet)||preg_match('/Mr3/',$code_bet)||preg_match('/Mr6/',$code_bet)||preg_match('/Mrs/',$code_bet)||preg_match('/Mri/',$code_bet))&&($nb_matchs<=1))&&(in_array($nom_sport,$liste_sports))){
				$nb_Paris= $xpath->query("./bets/bet",$match)->length;
				if($nb_Paris>7){$nb_Paris=7;}
				$elements3= $xpath->query("./choice",$bet);
				$array_date_match = preg_split('"T"', $date_match, -1);
				setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
				$stamp=strtotime($array_date_match[0].' '.$array_date_match[1])+60*60;
				$date_match_test=date('Y-m-d H:i', $stamp);
				$heure_match=date('H:i', $stamp);
				$jour_match=mb_strtoupper(strftime('%A %d %B',strtotime($date_match_test)),'UTF-8');
				$date_actuelle=date("Y-m-d H:i");
				if($date_match_test>=$date_actuelle){
					if($jour_match!=$date_prec){
						if($date_prec!=1){
							echo "</div>";
						}
						echo '<div id="'.$jour_match.'"><ol class="breadcrumb"><li><i class="calendar">'.$jour_match.'</i></li></ol><form class="form-horizontal" role="form"><div class="form-group" name="match"><div class="text_match"><kbd class="heure_match">'.$heure_match.'</kbd><p class="nom_match">'.$nom_match.'</p>';
					}
					else {
						echo '<form class="form-horizontal" role="form"><div class="form-group" name="match"><div class="text_match"><kbd class="heure_match">'.$heure_match.'</kbd><p class="nom_match">'.$nom_match.'</p>';
					}
					echo '<div name="div_boutton">';
					foreach ($elements3 as $choix) {
						//$randomFloat = rand(1, 10) / 10;
						$cote=$choix->getAttribute('odd');//+$randomFloat;
						$vainqueur=$choix->getAttribute('name');
						$id=$choix->getAttribute('id');
						$nom_match1=str_replace("'", "\'", $nom_match);
						if($vainqueur=="%1%"){
							echo '<div name="boutton1"><p name="1"> 1 </p><a type="submit" class="btn btn-default" id="'.$id.'" onclick="parier(\''.$nom_match1.'\','.$cote.',\''.$vainqueur.'\','.$id.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')">'.$cote.'</a></div>';
						}
						else if ($vainqueur=="%2%"){
							echo '<div name="boutton2"><p name="2"> 2 </p><a type="submit" class="btn btn-default" id="'.$id.'" onclick="parier(\''.$nom_match1.'\','.$cote.',\''.$vainqueur.'\','.$id.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')">'.$cote.'</a></div>';
						}
						else if ($vainqueur=="Nul"){
							echo '<div name="bouttonNul"><p name="Nul"> N </p><a type="submit" class="btn btn-default" id="'.$id.'" onclick="parier(\''.$nom_match1.'\','.$cote.',\''.$vainqueur.'\','.$id.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')">'.$cote.'</a></div>';
						}
						else{
							echo '<div name="divbouttonAutres"><p name="Autres">'.$vainqueur.' </p><a type="submit" class="btn btn-default" id="'.$id.'" onclick="parier(\''.$nom_match1.'\','.$cote.',\''.$vainqueur.'\','.$id.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')">'.$cote.'</a></div>';
						}
					}	
					if($nb_Paris>1) echo '<div name="divbouttonParisSup"><a name="bouttonParisSup" type="submit" class="btn btn-default" onclick="Affichage_paris_sup('.$idsport.','.$idevent.','.$id_match.',\''.$nom_sport.'\',\''.$nom_event.'\',\''.$code_bet.'\')"> +'.$nb_Paris.'</a></div>';
					echo '</div>';
					if($jour_match!=$date_prec){
						echo '</div></div></form>';
					}
					else{
						echo '</div></div></form>';	
					}
					$date_prec=$jour_match;
					$nb_matchs++;
				}
			}
		}	
	}
	echo '</ul>';	
}

function Affichage_Paris_Sup($idsport,$idevent,$idmatch){
	$listeparis=['Amf_Tpt','Amf_Mrs','Amf_Han','Ftb_Mr3','Ftb_Tgl','Ftb_Tgl2','Ftb_Csc','Ftb_10','Ftb_Dbc','Ftb_23','Bkb_Mr6','Bkb_Tpt','Bkb_Han','Ten_Mr2','Ten_Tgm','Ten_Tse','Rgb_Mr3','Rgb_Hp2','Rgb_Han','Rgb_Tgt'];
	$dom = new DOMDocument();
	$dom->load('http://xml.cdn.betclic.com/odds_fr.xml');
	$xpath = new DOMXpath($dom);
	$elements = $xpath->query("/sports/sport[@id=".$idsport."]");
	foreach ($elements as $sport) {
		$nom_sport=$sport->getAttribute('name');
		$elements2 = $xpath->query("./event[@id=".$idevent."]",$sport);
	}
	echo '<ul>';
	foreach ($elements2 as $event) {
		$name_event=$event->getAttribute('name');
		echo '<h5><p name="nom_sport">'.$nom_sport.'</p> '.$name_event.'</h5><a name="boutton_retour" type="submit" class="btn btn-primary" onclick="Affichage_paris('.$idsport.','.$idevent.')">Retour</a>';
		$elements3= $xpath->query("./match[@id=".$idmatch."]",$event);
		foreach ($elements3 as $match) {
			$name_match=$match->getAttribute('name');
			$date_match=$match->getAttribute('start_date');
			$equipe = preg_split('"-"', $name_match, -1);
			$name_match=str_replace("'", "\'",$name_match);
			$elements4= $xpath->query("./bets/bet",$match);
			$array_date_match = preg_split('"T"', $date_match, -1);
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$stamp=strtotime($array_date_match[0].' '.$array_date_match[1])+60*60;
			$date_match_test=date('Y-m-d H:i', $stamp);
			$heure_match=date('H\hi', $stamp);
			$jour_match=mb_strtoupper(strftime('%A %d %B',strtotime($date_match_test)),'UTF-8');
			echo '<h6>'.$name_match.'</h6>';
			echo '<p name="date_match_sup">'.$jour_match.' - '.$heure_match.'</p>';
			foreach ($elements4 as $bet) {
				$code_bet=$bet->getAttribute('code');
				$name_bet=$bet->getAttribute('name');
				$id_bet=$bet->getAttribute('id');
				if(in_array($code_bet,$listeparis)){
					echo '<li name="li_bet"><div name="entete_saison">'.$name_bet.'</div>';
					$elements5= $xpath->query("./choice",$bet);
					foreach ($elements5 as $choix) {
						//$randomFloat = rand(1, 10) / 10;
						$cote=$choix->getAttribute('odd');//+$randomFloat;
						$vainqueur=$choix->getAttribute('name');
						$id=$choix->getAttribute('id');
						$texte = str_replace("%1%",$equipe[0],$vainqueur);
						$texte = str_replace("%2%",$equipe[1],$texte);
						$vainqueur=str_replace("'", "\'",$vainqueur);
					
						echo '<div name="divParisSup"><p name="texteParisSup">'.$texte.'</p><a name="bouttonSup" type="submit" class="btn btn-default" id="'.$id.'" onclick="parier(\''.$name_match.'\','.$cote.',\''.$vainqueur.'\','.$id.',\''.$date_match.'\',\''.$nom_sport.'\',\''.$name_event.'\',\''.$code_bet.'\')">'.$cote.'</a></div>';
					}
					echo '</li>';
				}
			}
		}
	}
	echo '</ul>';
}

function Affichage_entete($erreur){
	include 'identifiant.php';
	session_start();
	
    if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))&&(isset($_SESSION['niveau']))){
    	$requete_solde='SELECT points FROM Membres WHERE idMembres='.$_SESSION['id'].'';
	    $resultat_solde=$db->query($requete_solde) or die ('Erreur'.mysql_error());
	    $columns=$resultat_solde->fetch();
	    $points=$columns['points'];
    	echo '<div name="solde">
    			<p name="text_solde">SOLDE</p>
    			<p name="point">
    				<span name="points_solde">'.$points.'</span>
    				<i class="fa fa-eur" aria-hidden="true"></i>
    			</p>
    		</div>
    		<div class="btn-group">
				<button id="logo_compte" class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown">
					<p name="drop_pseudo">'.$_SESSION['pseudo'].'</p>
					<span id="double_fleche" class="fa fa-angle-double-right" ></span>
				</button>
    			<ul class="dropdown-menu dropdown-menu-right">
    				<li><a href="Mes-Statistiques.php" name="stat_menu"><i class="fa fa-pie-chart" aria-hidden="true"></i>Mes Statistiques</a></li>
    				<li><a href="Mes-paris.php"><i class="fa fa-fw fa-shopping-cart"></i> Mes paris</a></li>
    				<li><a href="Amis.php"><i class="fa fa-fw fa-group"></i> Mes amis</a></li>
    				<li><a href="Paramètres-du-compte.php"><i class="fa fa-fw fa-gear"></i> Paramètres du compte</a></li>
    				<li class="divider"></li>';
	if($_SESSION['niveau']==1){echo'<li><a href="Gestion_score.php"> Ajout/Modif Score</a></li>'; }
    	echo'			<li><a href="Deconnexion.php"><i class="fa fa-fw fa-power-off"></i>Deconnexion</a></li>
    			</ul>
    		</div>';
    }
    else{
    	echo '<div id="boutton_entete_droite"><a id="boutton_connecte" name="boutton_entete" type="submit" onclick="Connexion()">CONNEXION</a><a href="Inscription.php" id="boutton_inscription" name="boutton_entete" type="submit" class="btn btn-default">Inscription</a>'; 
    	if($erreur==true){echo '<form id="form_connexion" class="form-horizontal" style="visibility: visible; height: auto;" role="form" action="index.php" method="POST">';}
    	else{echo '<form id="form_connexion" class="form-horizontal" style="visibility: hidden; height: 0px;" role="form" action="index.php" method="POST">';}
		echo '<div class="form-group">
						    <label class="control-label" for="pseudo">Nom du compte:</label>
						    <input type="text" class="form-control" name="compte" placeholder="Entrer pseudo" required="required">
						  </div>
						  <div class="form-group">
						    <label class="control-label" for="pwd">Mot de passe:</label>
						    <input type="password" class="form-control" name="pwd" placeholder="Entrer mot de passe" required="required">
						  </div>
						  <div class="div_mdp_oublie">
						  	<a name="mdp_oublie" href="Mot-de-passe-oublié.php"> Mot de passe oublié ? </a>';
		if($erreur==true){echo '<p name="erreur"><i class="icon-warning-sign"></i> Pseudonyme ou mot de passe incorrecte</p>';}
		echo '			  </div>
						  <div class="form-group"> 
						    <div class="div_boutton_connexion">
						      <button type="submit" class="btn btn-success" >Connexion</button>						      
						    </div>
						  </div>
						</form></div>';      
    }
}

//ACTUALITES RSS FEED
function Affichage_Actualites(){
	if(isset($_POST['mode'])){
    switch ($_POST['mode']) {
        case 'Basketball':
            echo '<div id="infos_nba" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.nba.com/news/?ls=iref:nba:gnav" target="_blank" > <img class="logo_image" src="Images/nba_rss.png"></a>';
            affichage_rss("http://www.nba.com/rss/nba_rss.xml");
            echo '</div><div id="infos_equipe" class="hidden-sm col-md-4 col-lg-4 "><a href="http://www.lequipe.fr/Basket/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss("http://www.lequipe.fr/rss/actu_rss_Basket.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.basketusa.com/" target="_blank" ><img class="logo_image"  src="Images/basketUSA_rss.jpg"></a>';
            affichage_rss("http://www.basketusa.com/feed/");
            echo '</div>';
            break;
        case 'Tous':
            echo '<div id="infos_equipe" class="col-sm-6  col-md-6 col-lg-6 "><a href="http://www.lequipe.fr" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss.xml"); 
            echo '</div><div id="infos_Eurosport" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.eurosport.fr/" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
            affichage_rss2("http://www.eurosport.fr/rss.xml");
            echo '</div>';
            break;
        case 'Football':
            echo '<div id="infos_nba" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.sport.fr/football/" target="_blank" > <img class="logo_image" src="Images/sportsfr.png"></a>';
            affichage_rss("http://www.sport.fr/RSS/sport1.xml");
            echo '</div><div id="infos_equipe" class="hidden-sm col-md-4 col-lg-4 "><a href="http://www.lequipe.fr/Football/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss("http://www.lequipe.fr/rss/actu_rss_Football.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.footmercato.net/" target="_blank" ><img class="logo_image"  src="Images/footMercato.svg"></a>';
            affichage_rss_foot_mercato("http://www.footmercato.net/flux-rss");
            echo '</div>';
            break;
        case 'Rugby':
            echo '<div id="infos_nba" class="hidden-sm col-md-4 col-lg-4"><a href="http://www.sport.fr/rugby/" target="_blank" > <img class="logo_image" src="Images/sportsfr.png"></a>';
            affichage_rss("http://www.sport.fr/RSS/sport2.xml");
            echo '</div><div id="infos_equipe" class="col-sm-6 col-md-4 col-lg-4"><a href="http://www.lequipe.fr/Rugby/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss("http://www.lequipe.fr/rss/actu_rss_Rugby.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.rugbyrama.fr/" target="_blank" ><img class="logo_image"  src="Images/rugbyrama.jpg"></a>';
            affichage_rss("http://www.rugbyrama.fr/rugby/rss.xml");
            echo '</div>';
            break;
        case 'Tennis':
            echo '<div id="infos_equipe" class="col-sm-6 col-md-6 col-lg-6"><a href="http://www.lequipe.fr/Tennis/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss_Tennis.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.eurosport.fr/tennis/" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
            affichage_rss2("http://www.eurosport.fr/tennis/rss.xml");
            echo '</div>';
            break;
        case 'F1':
            echo '<div id="infos_nba" class="col-sm-6 col-md-4 col-lg-4 "><a href="http://www.f1i.com/" target="_blank" > <img id="f1i" class="logo_image" src="Images/f1i.jpeg"></a>';
            affichage_rss("http://www.f1i.com/feed/");
            echo '</div><div id="infos_equipe" class="hidden-sm col-md-4 col-lg-4 "><a href="http://www.lequipe.fr/Formule-1/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss("http://www.lequipe.fr/rss/actu_rss_F1.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-4 col-lg-4 "><a href="https://www.formula1.com/" target="_blank" ><img id="formula1" class="logo_image"  src="Images/f1.png"></a>';
            affichage_rss("https://www.formula1.com/content/fom-website/en/latest.articlefeed.xml");
            echo '</div>';
            break;
        case 'Cyclisme':
            echo '<div id="infos_equipe" class="col-sm-6 col-md-6 col-lg-6"><a href="http://www.lequipe.fr/Cyclisme/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss_Cyclisme.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-6 col-lg-6"><a href="http://www.eurosport.fr/Cyclisme" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
            affichage_rss2("http://www.eurosport.fr/cyclisme/rss.xml");
            echo '</div>';
            break;
        default:
            echo '<div id="infos_equipe" class="col-sm-6  col-md-6 col-lg-6 "><a href="http://www.lequipe.fr" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss.xml"); 
            echo '</div><div id="infos_Eurosport" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.eurosport.fr/" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
            affichage_rss2("http://www.eurosport.fr/rss.xml");
            echo '</div>';
            break;
    }
}
else{
    echo '<div id="infos_equipe" class="col-sm-6  col-md-6 col-lg-6 "><a href="http://www.lequipe.fr" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
    affichage_rss2("http://www.lequipe.fr/rss/actu_rss.xml"); 
    echo '</div><div id="infos_Eurosport" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.eurosport.fr/" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
    affichage_rss2("http://www.eurosport.fr/rss.xml");
    echo '</div>';
}
}
                
 function affichage_rss2($url){ 
	$rss = simplexml_load_file($url);
	$nb_article=0;
	foreach ($rss->channel->item as $item){
	 if($nb_article>9){break;}
	 $datetime = date_create($item->pubDate);
	 $date = date_format($datetime, 'd M Y, H\hi');
	 $photo="";
	 foreach ($item->enclosure->attributes() as $a => $b) {
	 	if($a=="url"){
	 		$photo=$b;
	 	}
	 }
	 if($photo!=""){
	 	echo '<div class="info_rss2"><div name="image"><img src="'.$photo.'"></div><div name="texte_infos"><a class="lien_rss" href="'.$item->link.'" target="_blank" >'.$item->title.'</a><p class="description">'.$item->description.'</p> <p class="date">'.$date.'<p></div></div> </br>';
	 }
	 else {
	 	echo '<div class="info_rss2"><a class="lien_rss" href="'.$item->link.'" target="_blank" >'.$item->title.'</a><p class="description">'.$item->description.'</p> <p class="date">'.$date.'<p></div>';
	 }
	 $nb_article++;
	}

}                	  
                
                	 
function affichage_rss($url){ 
	$rss = simplexml_load_file($url);
	$nb_article=0;
	foreach ($rss->channel->item as $item){
	 if($nb_article>9){break;}
	 setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
	 $datetime = date_create($item->pubDate);
	 $date = date_format($datetime, 'Y-m-d H:i');
	 $date=strftime('%A %d %B %Y, %H:%M',strtotime($date));
	 echo '<div class="info_rss"><a class="lien_rss" href="'.$item->link.'" target="_blank" >'.$item->title.'</a><p class="description">'.$item->description.'</p> <p class="date">'.$date.'<p></div> </br>';
	 $nb_article++;
	}
}
function affichage_rss_foot_mercato($url){ 
	$rss = simplexml_load_file($url);
	$nb_article=0;
	foreach ($rss->channel->item as $item){
	 if($nb_article>9){break;}
	 setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
	 $date=strftime('%A %d %B %Y, %H:%M',strtotime($date));
	 echo '<div class="info_rss"><a class="lien_rss" href="'.$item->link.'" target="_blank" >'.$item->title.'</a><p class="description">'.$item->description.'</p> <p class="date"><p></div> </br>';
	 $nb_article++;
	}

}


/*CLASSEMENT.PHP*/

function Affichage_Classement_Joueur(){
	include('identifiant.php');
	session_start();
	$classement=1;
	$query='SELECT pseudo,points from Membres order by points desc,idMembres Limit 5';
	$query=$db->query($query) or die('Erreur'.mysql_error());
	echo '<p name="titre_table">Top 5 Joueur (Solde actuel)</p><div class="table"><div class="ligne header green"><div class="cell">Classement</div><div class="cell">Pseudonyme</div><div class="cell">Points</div></div>';
	while($donnees=$query->fetch()){
		switch ($classement) {
			case 1:
				echo '<div class="ligne"><div class="cell"><img src="Images/goldCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['points'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			case 2:
				echo '<div class="ligne"><div class="cell"><img src="Images/silverCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['points'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			case 3:
				echo '<div class="ligne"><div class="cell"><img src="Images/copperCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['points'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			default:
				echo '<div class="ligne"><div class="cell"><img src="Images/basicCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['points'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
		}
		$classement++;
	}
	echo '</div>';
}  

function Affichage_Classement_Joueur_Gain(){
	include('identifiant.php');
	session_start();
	$classement=1;
	$query='SELECT pseudo, points, sommeTotaleRechargement,ROUND(points-100-sommeTotaleRechargement,2) as gain from Membres order by Gain desc,idMembres Limit 5';
	$query=$db->query($query) or die('Erreur'.mysql_error());
	echo '<p name="titre_table">Top 5 Joueur</p><div class="table"><div class="ligne header green"><div class="cell">Classement</div><div class="cell">Pseudonyme</div><div class="cell">Points</div></div>';
	while($donnees=$query->fetch()){
		switch ($classement) {
			case 1:
				echo '<div class="ligne"><div class="cell"><img src="Images/goldCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['gain'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			case 2:
				echo '<div class="ligne"><div class="cell"><img src="Images/silverCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['gain'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			case 3:
				echo '<div class="ligne"><div class="cell"><img src="Images/copperCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['gain'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
			default:
				echo '<div class="ligne"><div class="cell"><img src="Images/basicCup.png" width="25" height="25"></div><div class="cell">'.$donnees['pseudo'].'</div><div class="cell">'.$donnees['gain'].'<i class="fa fa-fw fa-eur"></i></div></div>';
				break;
		}
		$classement++;
	}
	echo '</div>';
} 




function Affichage_Classement_Paris_Semaine(){
	include('identifiant.php');
	$idGroupe=array();

	$query='SELECT * FROM ((SELECT idParis,idMembres,typeParis,mise, cote,vainqueur,nomMatch,Null as idGroupe,situation,dateMatch FROM Paris natural join Matchs WHERE Paris.situation=\'Gagner\' AND Paris.typeParis=\'Simple\') UNION (SELECT idParis,idMembres,typeParis,mise, cote,vainqueur,nomMatch,idGroupe,situation,dateMatch FROM Paris natural join Paris_Combine natural join Matchs WHERE Paris.situation=\'Gagner\'))result Where dateMatch>(NOW()-INTERVAL 1 WEEK)';
	$query=$db->query($query) or die('Erreur'.mysql_error());
	while($donnees=$query->fetch()){
		if($donnees['typeParis']=="Combine"){
			$situation_paris="Gagner";
			$cote_totale=1;					
			if(!(in_array($donnees['idGroupe'], $idGroupe))){
				array_push($idGroupe,$donnees['idGroupe']);
				if($parisactuelle>=$premiermessage){
					$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$donnees['idMembres'].' AND idGroupe='.$donnees['idGroupe'].' order by idParis';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					while($donnees2=$query2->fetch()){
						$cote_totale=$cote_totale*$donnees2['cote'];
						if($donnees2['situation']!="Gagner"){ $situation_paris="Perdu";}
					}
					$cote_totale=round($cote_totale,2);
					if($situation_paris=="Gagner") {
						$array[]=array('id'=>$donnees['idGroupe'],'idMembres'=>$donnees['idMembres'],'type'=>$donnees['typeParis'],'cote'=>$cote_totale,'mise'=>$donnees['mise'],'gain'=>$donnees['mise']*$cote_totale);
					}
				}
			}
		}
		else if ($donnees['typeParis']=="Simple"){
			$array[]=array('id'=>$donnees['idParis'],'idMembres'=>$donnees['idMembres'],'type'=>$donnees['typeParis'],'cote'=>$donnees['cote'],'mise'=>$donnees['mise'],'gain'=>$donnees['cote']*$donnees['mise']);
		}			
	}
	foreach ($array as $key => $row) {
	    $id[$key]  = $row['id'];
	    $idMembres[$key]=$row['idMembres'];
	    $type[$key] = $row['type'];
	    $cote[$key]  = $row['cote'];
	    $mise[$key] = $row['mise'];
	    $gain[$key]  = $row['gain'];
	}
	array_multisort($gain, SORT_DESC, $cote, SORT_DESC, $array);
	$maxValues = array_slice($array, 0, 5);
	$classement=1;
	echo '<p name="titre_table">Top 5 Paris du jour</p><table class="table"><thead><tr class="ligne header blue"><th class="cell">Classement</th><th class="cell">Pseudonyme</th><th class="cell">Mise</th><th class="cell">Cote</th><th class="cell">Gain</th></tr></thead>';
	foreach ($maxValues as $row) {
		$query='SELECT pseudo FROM Membres WHERE idMembres='.$row['idMembres'].'';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		$donnees=$query->fetch();
		$pseudo=$donnees['pseudo'];
		switch ($classement) {
			case 1:
				echo '<tr class="ligne" id="image'.$classement.'"><td class="cell"><img src="Images/goldCup.png" width="25" height="25"><i class="fa fa-angle-down" aria-hidden="true"></i></td><td class="cell">'.$pseudo.'</td><td class="cell">'.$row['mise'].'<i class="fa fa-fw fa-eur"></i></td><td class="cell">'.$row['cote'].'</td><td class="cell">'.$row['gain'].'<i class="fa fa-fw fa-eur"></i></td></tr>';
				if($row['type']=="Simple"){
					$query2='SELECT nomEvent,nomMatch,vainqueur,cote From Paris natural join Matchs WHERE idParis='.$row['id'].'';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Simple" name="paris_classement" style="display: none;" class="ligne"><td class="cell" colspan="5"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					$donnees2=$query2->fetch();
					$equipe = preg_split('"-"',$donnees2['nomMatch'], -1);
					$vainqueur = str_replace("%1%",$equipe[0],$donnees2['vainqueur']);
					$vainqueur = str_replace("%2%",$equipe[1],$vainqueur);
					echo '<div name="sous_paris">';
					if(is_null($donnees2['nomEvent'])){
						echo'<p name="match_simple">'.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}
					else{
						echo'<p name="match_simple"><span name="spanEvent">'.$donnees2['nomEvent'].':</span>'.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span> '.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}				
					echo '</div></td></tr>';
				}
				else if($row['type']=="Combine"){
					$query2='(SELECT idParis,cote,vainqueur,nomEvent,nomMatch,idGroupe,situation,dateParis from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$row['idMembres'].' AND idGroupe='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Combine" name="paris_classement" style="display: none;" class="ligne"><td class="cell" colspan="5"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					while($donnees2=$query2->fetch()){
						$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
						$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
						$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
						echo '<div name="sous_paris_combine"><div><p name="match_combine">';
						if(is_null($donnees2['nomEvent'])){
							echo $donnees2['nomMatch'];
						}
						else{
							echo '<span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'];
						}
						echo '</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p></div></div>';
					}
					echo '</td></tr>';
				}
				break;
			case 2:
				echo '<tr id="image'.$classement.'" class="ligne"><td class="cell"><img src="Images/silverCup.png" width="25" height="25"><i class="fa fa-angle-down" aria-hidden="true"></i></td><td class="cell">'.$pseudo.'</td><td class="cell">'.$row['mise'].'<i class="fa fa-fw fa-eur"></i></td><td class="cell">'.$row['cote'].'</td><td class="cell">'.$row['gain'].'<i class="fa fa-fw fa-eur"></i></td></tr>';
				if($row['type']=="Simple"){
					$query2='(SELECT nomEvent,nomMatch,vainqueur,cote From Paris natural join Matchs WHERE idParis='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Simple" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					$donnees2=$query2->fetch();
					$equipe = preg_split('"-"',$donnees2['nomMatch'], -1);
					$vainqueur = str_replace("%1%",$equipe[0],$donnees2['vainqueur']);
					$vainqueur = str_replace("%2%",$equipe[1],$vainqueur);
					echo '<div name="sous_paris">';
					if(is_null($donnees2['nomEvent'])){
						echo'<p name="match_simple">'.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}
					else{
						echo'<p name="match_simple"><span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}					
					echo '</div></td></tr>';
				}
				else if($row['type']=="Combine"){
					$query2='(SELECT idParis,cote,vainqueur,nomEvent,nomMatch,idGroupe,situation,dateParis from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$row['idMembres'].' AND idGroupe='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Combine" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					while($donnees2=$query2->fetch()){
						$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
						$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
						$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
						echo '<div name="sous_paris_combine"><div><p name="match_combine">';
						if(is_null($donnees2['nomEvent'])){
							echo $donnees2['nomMatch'];
						}
						else{
							echo '<span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'];
						}
						echo '</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p></div></div>';
					}
					echo '</td></tr>';
				}
				break;
			case 3:
				echo '<tr id="image'.$classement.'" class="ligne"><td class="cell"><img src="Images/copperCup.png" width="25" height="25"><i class="fa fa-angle-down" aria-hidden="true"></i></td><td class="cell">'.$pseudo.'</td><td class="cell">'.$row['mise'].'<i class="fa fa-fw fa-eur"></i></td><td class="cell">'.$row['cote'].'</td><td>'.$row['gain'].'<i class="fa fa-fw fa-eur"></i></td></tr>';
				if($row['type']=="Simple"){
					$query2='(SELECT nomEvent,nomMatch,vainqueur,cote From Paris natural join Matchs WHERE idParis='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Simple" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					$donnees2=$query2->fetch();
					$equipe = preg_split('"-"',$donnees2['nomMatch'], -1);
					$vainqueur = str_replace("%1%",$equipe[0],$donnees2['vainqueur']);
					$vainqueur = str_replace("%2%",$equipe[1],$vainqueur);
					echo '<div name="sous_paris">';
					if(is_null($donnees2['nomEvent'])){
						echo'<p name="match_simple">'.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}
					else{
						echo'<p name="match_simple"><span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}					
					echo '</div></td></tr>';
				}
				else if($row['type']=="Combine"){
					$query2='(SELECT idParis,cote,vainqueur,nomEvent,nomMatch,idGroupe,situation,dateParis from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$row['idMembres'].' AND idGroupe='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Combine" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement" >Le Pari de '.$pseudo.'</p>';
					while($donnees2=$query2->fetch()){
						$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
						$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
						$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
						echo '<div name="sous_paris_combine"><div><p name="match_combine">';
						if(is_null($donnees2['nomEvent'])){
							echo $donnees2['nomMatch'];
						}
						else{
							echo '<span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'];
						}
						echo '</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p></div></div>';
					}
					echo '</td></tr>';
				}
				break;
			default:
				echo '<tr id="image'.$classement.'" class="ligne"><td class="cell"><img src="Images/basicCup.png" width="25" height="25"><i class="fa fa-angle-down" aria-hidden="true"></i></td><td>'.$pseudo.'</td><td class="cell">'.$row['mise'].'<i class="fa fa-fw fa-eur"></i></td><td class="cell">'.$row['cote'].'</td><td class="cell">'.$row['gain'].'<i class="fa fa-fw fa-eur"></i></td></tr>';
				if($row['type']=="Simple"){
					$query2='(SELECT nomEvent,nomMatch,vainqueur,cote From Paris natural join Matchs WHERE idParis='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Simple" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					$donnees2=$query2->fetch();
					$equipe = preg_split('"-"',$donnees2['nomMatch'], -1);
					$vainqueur = str_replace("%1%",$equipe[0],$donnees2['vainqueur']);
					$vainqueur = str_replace("%2%",$equipe[1],$vainqueur);
					echo '<div name="sous_paris">';
					if(is_null($donnees2['nomEvent'])){
						echo'<p name="match_simple">'.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}
					else{
						echo'<p name="match_simple"><span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'].'</p><p name="vainqueur_simple">Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_simple">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p>';
					}					
					echo '</div></td></tr>';
				}
				else if($row['type']=="Combine"){
					$query2='(SELECT idParis,cote,vainqueur,nomEvent,nomMatch,idGroupe,situation,dateParis from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$row['idMembres'].' AND idGroupe='.$row['id'].')';
					$query2=$db->query($query2) or die('Erreur'.mysql_error());
					echo '<tr id="paris_classement'.$classement.'" type="Combine" name="paris_classement" style="display: none;" class="ligne"><td colspan="5" class="cell"><p name="entete_paris_classement">Le Pari de '.$pseudo.'</p>';
					while($donnees2=$query2->fetch()){
						$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
						$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
						$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
						echo '<div name="sous_paris_combine"><div><p name="match_combine">';
						if(is_null($donnees2['nomEvent'])){
							echo $donnees2['nomMatch'];
						}
						else{
							echo '<span name="spanEvent">'.$donnees2['nomEvent'].':</span> '.$donnees2['nomMatch'];
						}
						echo '</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :<span>'.number_format($donnees2['cote'], 2, '.', '').'</span></p></div></div>';
					}
					echo '</td></tr>';
				}
				break;
		}
		$classement++;
	}
	echo '</table>';
} 

/*Rajout*/

function Affichage_Mes_Paris($type){
	include('identifiant.php');
	$nbreparisparpage=5;
	$nbreparisparpagecombine=3;
	if ($type=="Tous") {
		echo '<div name="entete_mes_paris">MES PARIS</div>';
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres="'.$_SESSION['id'].'" AND Paris.typeParis="Simple"';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris_simple = $columns['nb'];
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(distinct(idGroupe)) AS nb FROM Paris NATURAL JOIN Paris_Combine WHERE Paris.idMembres='.$_SESSION['id'].'';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris_combine = $columns['nb'];

		$nb_paris=$nb_paris_simple+$nb_paris_combine;
		$nbrepages=ceil($nb_paris/$nbreparisparpage);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
		$idGroupe=array();
		$premiermessage=($page-1)*$nbreparisparpage;
		$derniermessage=$premiermessage+$nbreparisparpage;
		$parisactuelle=0;
		$query='SELECT * FROM ((SELECT idParis,typeParis,mise, cote,vainqueur, nomMatch,null as idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural Join Matchs WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.typeParis=\'Simple\') UNION (SELECT idParis,typeParis,mise, cote,vainqueur,nomMatch,idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural join Paris_Combine natural Join Matchs WHERE Paris.idMembres='.$_SESSION['id'].'))result order by dateParis desc,idParis';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while(($donnees=$query->fetch())&&($parisactuelle<$derniermessage)){
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$dateparis=mb_strtoupper(strftime('%A %d %B %T',strtotime($donnees['dateParis'])),'UTF-8');
			if($donnees['typeParis']=="Combine"){
				$cote_totale=1;					
				if(!(in_array($donnees['idGroupe'], $idGroupe))){
					array_push($idGroupe,$donnees['idGroupe']);
					if($parisactuelle>=$premiermessage){
						echo '<div name="paris_combine"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation"></p></div>';
						$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation,dateParis,nomEvent,nomSport from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' ORDER BY dateParis desc,idParis';
						$query2=$db->query($query2) or die('Erreur'.mysql_error());
						while($donnees2=$query2->fetch()){
							if($donnees2['situation']=="Gagner"){ $donnees2['situation']="Gagné";}
							$cote_totale=$cote_totale*$donnees2['cote'];
							$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
							$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
							$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
							if(is_null($donnees['nomEvent'])){
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
							else{
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - '.$donnees2['nomEvent'].' - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
						}
						$cote_totale=round($cote_totale,2);
						echo '<div name="footer_paris_combine"><p name="mise_totale_combine">Mise totale : '.$donnees['mise'].'</p><p name="cote_totale_combine">Cote totale :'.number_format($cote_totale, 2, '.', '').'</p></div></div>';
					}	
					$parisactuelle++;
				}
			}
			else if ($donnees['typeParis']=="Simple"){
				if($parisactuelle>=$premiermessage){
					if($donnees['situation']=="Gagner"){ $donnees['situation']="Gagné";}
					$nomMatch=preg_split('"[ ]+-"', $donnees['nomMatch']);
					$vainqueur=str_replace("%1%",$nomMatch[0],$donnees['vainqueur']);
					$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
					if(is_null($donnees['nomEvent'])){
						echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
					}
					else{
						echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - '.$donnees['nomEvent'].' - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
					}
				}
				$parisactuelle++;
			}	
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
	}
	else if($type=="Simple"){
		echo '<div name="entete_mes_paris">MES PARIS SIMPLES</div>';
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres="'.$_SESSION['id'].'" AND Paris.typeParis="Simple"';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris = $columns['nb'];

		$nbrepages=ceil($nb_paris/$nbreparisparpage);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
		$premiermessage=($page-1)*$nbreparisparpage;
		$query='SELECT idParis,mise, cote,vainqueur,nomMatch, situation,dateParis,nomEvent,nomSport  from Paris natural Join Matchs WHERE idMembres='.$_SESSION['id'].' AND Paris.typeParis=\'Simple\' ORDER BY dateParis desc,idParis Limit '.$nbreparisparpage.' OFFSET '.$premiermessage.'';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while($donnees=$query->fetch()){
			if($donnees['situation']=="Gagner"){ $donnees['situation']="Gagné";}
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$dateparis=mb_strtoupper(strftime('%A %d %B %T',strtotime($donnees['dateParis'])),'UTF-8');
			$nomMatch=preg_split('"[ ]+-"', $donnees['nomMatch']);
			$vainqueur=str_replace("%1%",$nomMatch[0],$donnees['vainqueur']);
			$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
			echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - '.$donnees['nomEvent'].' - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}

	}
	else if($type=="Combine"){
		echo '<div name="entete_mes_paris">MES PARIS COMBINÉS</div>';
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(distinct(idGroupe)) AS nb FROM Paris NATURAL JOIN Paris_Combine WHERE Paris.idMembres='.$_SESSION['id'].'';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris = $columns['nb'];

		$nbrepages=ceil($nb_paris/$nbreparisparpagecombine);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}
		//affichage des paris de l'utilisateur
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
		$premiermessage=($page-1)*$nbreparisparpagecombine;
		$derniermessage=$premiermessage+$nbreparisparpagecombine;
		$parisactuelle=0;
		$query='SELECT idGroupe,dateParis,mise from Paris natural join Paris_Combine WHERE Paris.idMembres='.$_SESSION['id'].' group by idGroupe order by dateParis desc,idParis ';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while(($donnees=$query->fetch())&&($parisactuelle<$derniermessage)){
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$dateparis=mb_strtoupper(strftime('%A %d %B %T',strtotime($donnees['dateParis'])),'UTF-8');
			$cote_totale=1;
			if($parisactuelle>=$premiermessage){
				echo '<div name="paris_combine"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation"></p></div>';
				$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation,dateParis,nomEvent,nomSport from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' order by dateParis desc,idParis';
				$query2=$db->query($query2) or die('Erreur'.mysql_error());
				while($donnees2=$query2->fetch()){
					if($donnees2['situation']=="Gagner"){ $donnees2['situation']="Gagné";}
					$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
					$cote_totale=$cote_totale*$donnees2['cote'];
					$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
					$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
					echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - '.$donnees2['nomEvent'].' - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
				}
				$cote_totale=round($cote_totale,2);
				echo '<div name="footer_paris_combine"><p name="mise_totale_combine">Mise totale : '.$donnees['mise'].'</p><p name="cote_totale_combine">Cote totale :'.number_format($cote_totale, 2, '.', '').'</p></div></div>';
			}
			$parisactuelle++;
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}	
	}
	else if($type=="Terminer"){
		echo '<div name="entete_mes_paris">MES PARIS TERMINÉS</div>';
		$idGroupeTermine=array();
		$query='SELECT distinct(idGroupe) from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].'';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while($donnees=$query->fetch()){
			
			$termine=true;
			$query2='SELECT situation from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' order by idParis';
			$query2=$db->query($query2) or die('Erreur'.mysql_error());
			while($donnees2=$query2->fetch()){
				if(($donnees2['situation']!="Perdu")&&($donnees2['situation']!="Gagner")){
					$termine=false;
				}
			}
			if ($termine==true){
				array_push($idGroupeTermine,$donnees['idGroupe']);
			}
		}
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres="'.$_SESSION['id'].'" AND Paris.typeParis="Simple" AND (Paris.situation="Gagner" OR Paris.situation="Perdu")';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris = $columns['nb']+count($idGroupeTermine);
		$nbrepages=ceil($nb_paris/$nbreparisparpage);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
		$idGroupe=array();
		$premiermessage=($page-1)*$nbreparisparpage;
		$derniermessage=$premiermessage+$nbreparisparpage;
		$parisactuelle=0;
		$query='SELECT * FROM ((SELECT idParis,typeParis,mise, cote,vainqueur,nomMatch,null as idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural Join Matchs WHERE Paris.idMembres='.$_SESSION['id'].' AND (Paris.situation="Gagner" OR Paris.situation="Perdu") AND Paris.typeParis="Simple") UNION (SELECT idParis,typeParis,mise, cote,vainqueur,nomMatch,idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural join Paris_Combine natural Join Matchs WHERE Paris.idMembres='.$_SESSION['id'].' AND (Paris.situation="Gagner" OR Paris.situation="Perdu")))result order by dateParis desc,idParis';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while(($donnees=$query->fetch())&&($derniermessage>$parisactuelle)){
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$dateparis=mb_strtoupper(strftime('%A %d %B %T',strtotime($donnees['dateParis'])),'UTF-8');
			if($donnees['typeParis']=="Combine"){
				$cote_totale=1;					
				if((!(in_array($donnees['idGroupe'], $idGroupe)))&&(in_array($donnees['idGroupe'],$idGroupeTermine))){
					array_push($idGroupe,$donnees['idGroupe']);
					if($parisactuelle>=$premiermessage){
						echo '<div name="paris_combine"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation"></p></div>';
						$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation,nomEvent,nomSport from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' order by idParis';
						$query2=$db->query($query2) or die('Erreur'.mysql_error());
						while($donnees2=$query2->fetch()){
							if($donnees2['situation']=="Gagner"){ $donnees2['situation']="Gagné";}
							$cote_totale=$cote_totale*$donnees2['cote'];
							$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
							$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
							$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
							if(is_null($donnees['nomEvent'])){
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
							else{
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - '.$donnees2['nomEvent'].' - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
						}
						$cote_totale=round($cote_totale,2);
						echo '<div name="footer_paris_combine"><p name="mise_totale_combine">Mise totale : '.$donnees['mise'].'</p><p name="cote_totale_combine">Cote totale :'.number_format($cote_totale, 2, '.', '').'</p></div></div>';			
					}
					$parisactuelle++;
				}
			}
			else if ($donnees['typeParis']=="Simple"){
				if($parisactuelle>=$premiermessage){
					if($donnees['situation']=="Gagner"){ $donnees['situation']="Gagné";}
					$nomMatch=preg_split('"[ ]+-"', $donnees['nomMatch']);
					$vainqueur=str_replace("%1%",$nomMatch[0],$donnees['vainqueur']);
					$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
					echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - '.$donnees['nomEvent'].' - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
				}
				$parisactuelle++;
			}			
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
	}
	else if($type=="Attente"){
		echo '<div name="entete_mes_paris">MES PARIS EN ATTENTE</div>';
		$idGroupeTermine=array();
		$query='SELECT distinct(idGroupe) from Paris natural join Paris_Combine WHERE idMembres='.$_SESSION['id'].'';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while($donnees=$query->fetch()){
			$termine=true;
			$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' order by idParis';
			$query2=$db->query($query2) or die('Erreur'.mysql_error());
			while($donnees2=$query2->fetch()){
				if(($donnees2['situation']=="Attente")){
					$termine=false;
				}
			}
			if ($termine==false){
				array_push($idGroupeTermine,$donnees['idGroupe']);
			}
		}
		// Recupere nbre total de paris
		$requete_nb_paris='SELECT COUNT(idParis) AS nb FROM Paris WHERE Paris.idMembres="'.$_SESSION['id'].'" AND Paris.typeParis="Simple" AND Paris.situation="Attente"';
		$resultat_nb_paris=$db->query($requete_nb_paris) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_paris->fetch();
		$nb_paris = $columns['nb']+count($idGroupeTermine);
		$nbrepages=ceil($nb_paris/$nbreparisparpage);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
		$idGroupe=array();
		$premiermessage=($page-1)*$nbreparisparpage;
		$derniermessage=$premiermessage+$nbreparisparpage;
		$parisactuelle=0;
		$query='SELECT * FROM ((SELECT idParis,typeParis,mise, cote,vainqueur,nomMatch,null as idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural join Matchs WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente") UNION (SELECT idParis,typeParis,mise, cote,vainqueur,nomMatch,idGroupe,situation,dateParis,nomEvent,nomSport FROM Paris natural join Paris_Combine natural Join Matchs WHERE Paris.idMembres='.$_SESSION['id'].' AND Paris.situation="Attente"))result order by dateParis desc, idParis';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		while(($donnees=$query->fetch())&&($derniermessage>$parisactuelle)){
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$dateparis=mb_strtoupper(strftime('%A %d %B %T',strtotime($donnees['dateParis'])),'UTF-8');
			if($donnees['typeParis']=="Combine"){
				$cote_totale=1;					
				if((!(in_array($donnees['idGroupe'], $idGroupe)))&&(in_array($donnees['idGroupe'],$idGroupeTermine))){
					array_push($idGroupe,$donnees['idGroupe']);
					if($parisactuelle>=$premiermessage){
						echo '<div name="paris_combine"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation"></p></div>';
						$query2='SELECT idParis,cote,vainqueur,nomMatch,idGroupe,situation,nomEvent,nomSport from Paris natural join Paris_Combine natural join Matchs WHERE idMembres='.$_SESSION['id'].' AND idGroupe='.$donnees['idGroupe'].' order by idParis';
						$query2=$db->query($query2) or die('Erreur'.mysql_error());
						while($donnees2=$query2->fetch()){
							$cote_totale=$cote_totale*$donnees2['cote'];
							$nomMatch=preg_split('"[ ]+-"', $donnees2['nomMatch']);
							$vainqueur=str_replace("%1%",$nomMatch[0],$donnees2['vainqueur']);
							$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
							if(is_null($donnees['nomEvent'])){
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
							else{
								echo '<div name="sous_paris_combine"><div><div name="entete_matchs_combine"><p name="nom_sport">'.$donnees2['nomSport'].'</p><p name="nom_event"> - '.$donnees2['nomEvent'].' - </p><p name="match_combine">'.$donnees2['nomMatch'].'</p></div><p name="situation_combine" type="'.$donnees2['situation'].'">'.$donnees2['situation'].'</p></div><div name="bottom"><p name="vainqueur_combine"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="cote_combine">Cote :'.number_format($donnees2['cote'], 2, '.', '').'</p></div></div>';
							}
						}
						$cote_totale=round($cote_totale,2);
						echo '<div name="footer_paris_combine"><p name="mise_totale_combine">Mise totale : '.$donnees['mise'].'</p><p name="cote_totale_combine">Cote totale :'.number_format($cote_totale, 2, '.', '').'</p></div></div>';
					}
					$parisactuelle++;
				}
			}
			else if ($donnees['typeParis']=="Simple"){
				if($parisactuelle>=$premiermessage){
					$nomMatch=preg_split('"[ ]+-"', $donnees['nomMatch']);
					$vainqueur=str_replace("%1%",$nomMatch[0],$donnees['vainqueur']);
					$vainqueur=str_replace("%2%",$nomMatch[1],$vainqueur);
					if(is_null($donnees['nomEvent'])){
						echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
					}
					else{
						echo '<div name="paris"><div name="entete_paris"><p name="date_paris">'.$dateparis.'</p><p name="situation" type="'.$donnees['situation'].'">'.$donnees['situation'].'</p></div><div name="entete_matchs"><p name="nom_sport">'.$donnees['nomSport'].'</p><p name="nom_event"> - '.$donnees['nomEvent'].' - </p><p name="match">'.$donnees['nomMatch'].'</p></div><p name="vainqueur"> Vainqueur :<span>'.$vainqueur.'</span></p><p name="mise"> Mise : '.$donnees['mise'].'</p><p name="cote">Cote :'.number_format($donnees['cote'], 2, '.', '').'</p></div>';
					}
				}
				$parisactuelle++;
			}					
		}
		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page=1&type='.$type.'"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Mes-paris.php?page='.$i.'&type='.$type.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Mes-paris.php?page='.$nbrepages.'&type='.$type.'">>></a>';
			echo '</div>';
		}
	}
}

function Affichage_Parametre(){
	if(isset($_POST['btn_modifier'])||isset($_POST['btn_valide_modif'])){
		if($_POST['btn_modifier']=="mdp"||$_POST['btn_valide_modif']=="mdp"){
			echo '<div name="modification">
	<form class="form" role="form" data-toggle="validator" action="Paramètres-du-compte.php" method="POST">
		<div class="form-group">
			<label class="control-label col-md-4" for="ancienpwd">Ancien mot de passe:</label>
			<div class="col-md-5">
				<input id="input1" type="password" class="form-control" name="ancienpwd" id="inputAncienPassword" placeholder="Entrer ancien mot de passe" required="required">
			</div>
		</div>
		<div class="form-group">
		    <label class="control-label col-md-4" for="pwd">Mot de passe:</label>
		    <div class="col-md-5"> 
		      <input type="password" class="form-control" data-minlength="6"  name="pwd" id="inputPassword" placeholder="Entrer mot de passe" required="required">
		      <span class="help-block">Minimum de 6 charactères</span>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-md-4" for="pwd2">Confirmation du mot de passe:</label>
		    <div class="col-md-5"> 
		      <input type="password" class="form-control" name="pwd2" id="ConfirmInputPassword" data-match="#inputPassword" data-match-error="Mot de passe ne correspond pas" placeholder="Confirmer mot de passe" required="required">
		      <div class="help-block with-errors"></div>
		    </div>
		  </div>
		<div class="form-group">
			<div class="col-md-offset-4 col-md-5">
				<button name="btn_valide_modif" value="mdp" type="submit" class="btn btn-success" >Modifier</button>
				<a id="bouttonAnnuler" href="Paramètres-du-compte.php" type="submit" class="btn btn-primary" >Annuler</a>
			</div>
		</div>
	</form>
</div>';
		}
		else if($_POST['btn_modifier']=="pseudo"||$_POST['btn_valide_modif']=="pseudo"){
			echo '<div name="modification"><form class="form-inline" role="form" action="Paramètres-du-compte.php" method="POST"><p name="titre">Pseudonyme </p> <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Entrer nouveau pseudo" required="required"><button name="btn_valide_modif" value="pseudo" type="submit" class="btn btn-success" >Modifier Pseudonyme</button><a href="Paramètres-du-compte.php" type="submit" class="btn btn-primary" >Annuler</a></form></div>';

		}
		else if($_POST['btn_modifier']=="compte"||$_POST['btn_valide_modif']=="compte"){
			echo '<div name="modification">
	<form role="form" action="Paramètres-du-compte.php" method="POST">
		<div class="row">
			<div class="col-md-3">
				<label class="control-label" for="ancienpwd">Mot de passe:</label>
			</div>
			<div class="col-md-4">
				<input type="password" class="form-control" name="ancienpwd" id="inputAncienPassword" placeholder="Entrer mot de passe" required="required">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<label class="control-label" for="compte">Nouveau nom de compte:</label>
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control" id="compte" name="compte" placeholder="Entrer nouveau nom de compte" required="required">
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-3 col-md-4">
				<button name="btn_valide_modif" value="compte" type="submit" class="btn btn-success">Modifier</button>
				<a id="bouttonAnnuler" href="Paramètres-du-compte.php" type="submit" class="btn btn-primary">Annuler</a>
			</div>
		</div>
	</form>
</div>';
		}
		else if($_POST['btn_modifier']=="mail"||$_POST['btn_valide_modif']=="mail"){
			echo '<div name="modification"><form class="form-inline" role="form" action="Paramètres-du-compte.php" method="POST"><p name="titre">Email </p> <input type="email" class="form-control" id="email" name="email" placeholder="Entrer nouveau email" required="required"><button name="btn_valide_modif" value="mail" type="submit" class="btn btn-success" >Modifier email</button><a href="Paramètres-du-compte.php" type="submit" class="btn btn-primary" >Annuler</a></form></div>';
		}
		else{header('Location: index.php'); }
	}
	else{
		echo '<p name="titre_modif">Paramètres généraux du compte</p>';
		echo '<table class="table"><form action="Paramètres-du-compte.php" method="POST">';
		echo '<tr id="pseudo"><td><p name="titre">Pseudonyme</p></td><td><p name="valeur">'.$_SESSION['pseudo'].'</p></td><td><button value="pseudo" name="btn_modifier">Modifier</button></td></tr>';
		echo '<tr id="compte"><td><p name="titre">Nom du compte</p></td><td><p name="valeur">'.$_SESSION['compte'].'</p></td><td><button value="compte" name="btn_modifier">Modifier</button></td></tr>';
		echo '<tr id="mdp"><td><p name="titre">Mot de passe</p></td><td><p name="valeur">**********</p></td><td><button type="submit" value="mdp" name="btn_modifier">Modifier</button></td></tr>';
		echo '<tr id="mail"><td><p name="titre">E-mail</p></td><td><p name="valeur">'.$_SESSION['email'].'</p></td><td><button value="mail" name="btn_modifier">Modifier</button></td></tr>';
		echo '</form></table>';
	}
}

function Affichage_Solde(){
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		//Requete point actuel
		$requete_solde='SELECT points,sommeTotaleRechargement FROM Membres WHERE idMembres='.$_SESSION['id'].'';
	    $resultat_solde=$db->query($requete_solde) or die ('Erreur'.mysql_error());
	    $columns=$resultat_solde->fetch();
	    $points_actuelle=$columns['points'];
	    $points_totale=$columns['points']-($columns['sommeTotaleRechargement']+100);
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

		
	    if($rechargement_semaine<100){
	    	//Requete paris en attente
	    	echo '<table class="table" id=affichage_solde>';
	    	echo '<tr id="solde_actuel"><td name="titre">Solde actuel</td><td name="infos">'.$points_actuelle.'<i class="fa fa-fw fa-eur"></i></td></tr><tr id="solde_total"><td name="titre">Gains réels</td>';
	    	if($points_totale<0){
	    		echo '<td name="infos" style="color:red;">'.$points_totale.'<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	else if($points_totale>0){
	    		echo '<td name="infos" style="color:green;">'.$points_totale.'<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	else{
	    		echo '<td name="infos">0<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	echo '</tr></table>';
	    	echo '<form class="form-horizontal" role="form" data-toggle="validator" action="recharger.php" method="POST">';
	    	echo '<input type="range" name="range" id="slider1" min="0" max="'.(100-$rechargement_semaine).'" step="1" value="100" oninput="result.value=parseInt(slider1.value)"/><div name="result_slider"><output id="result">--</output><i class="fa fa-fw fa-eur"></i><button name="bouton_recharger" type="submit" class="btn btn-success">Recharger</button></div>';
	    	echo '</form>';
	    }
	    else{
	    	echo '<table class="table" id=affichage_solde>';
	    	echo '<tr id="solde_actuel"><td name="titre">Solde actuel</td><td name="infos">'.$points_actuelle.'<i class="fa fa-fw fa-eur"></i></td></tr><tr id="solde_total" ><td name="titre">Gains réels</td>';
	    	if($points_totale<0){
	    		echo '<td name="infos" style="color:red;">'.$points_totale.'<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	else if($points_totale>0){
	    		echo '<td name="infos" style="color:green;">'.$points_totale.'<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	else{
	    		echo '<td name="infos">'.$points_totale.'<i class="fa fa-fw fa-eur"></i></td>';
	    	}
	    	echo '</tr></table>';
	    }
	}
	else{
		header('Location: index.php');
	}

}

function Affichage_amis(){
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		$requete_nb_amis='select count(idTo) as nb from Amis Where (idFrom='.$_SESSION['id'].' OR idTo='.$_SESSION['id'].') ';
		$resultat_nb_amis=$db->query($requete_nb_amis) or die('Erreur'.mysql_error());
		$columns = $resultat_nb_amis->fetch();
		$nb_amis = $columns['nb'];
		$nbparpage=10;
		$nbrepages=ceil($nb_amis/$nbparpage);
		//affichage des paris de l'utilisateur
		if (isset($_GET['page'])){
		    $page = $_GET['page']; 
		}
		else {
	        $page = 1;
		}

		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Amis.php?page=1"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Amis.php?page='.$i.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Amis.php?page='.$i.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Amis.php?page='.$nbrepages.'">>></a>';
			echo '</div>';
		}
		$premiercompte=($page-1)*$nbparpage;
		$query='SELECT * FROM((select pseudo, points,status from Amis inner join  Membres on Membres.idMembres=idTo Where idFrom='.$_SESSION['id'].' AND status=2)UNION(select pseudo, points,status from Amis inner join  Membres on Membres.idMembres=idFrom Where idTo='.$_SESSION['id'].' AND status=2)UNION(select pseudo,points,status from Amis inner join Membres on idMembres=idTo Where status=1 And idFrom='.$_SESSION['id'].'))result order by points desc Limit '.$nbparpage.' OFFSET '.$premiercompte.';';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		echo '<table><tr><th>Pseudonyme</th><th>Points</th><th></th></tr>';
		while($donnees=$query->fetch()){
			if($donnees['status']==1){
				echo '<tr><td name="pseudo">'.$donnees['pseudo'].'</td><td>'.$donnees['points'].'</td><td><a name="boutton_annuler" type="submit" class="btn btn-info" onclick="supprimer_amis(\''.$donnees['pseudo'].'\',\'supprimer\')"> Annuler demande </a></td></tr>';
			}
			else if($donnees['status']==2){
				echo '<tr><td name="pseudo">'.$donnees['pseudo'].'</td><td>'.$donnees['points'].'</td><td><a name="boutton_supprimer" type="submit" class="btn btn-danger" onclick="supprimer_amis(\''.$donnees['pseudo'].'\',\'supprimer\')"> Supprimer </a></td></tr>';
			}
		}
		echo '</table>';

		if($nbrepages>1){
			echo '<div name="div_pages">';
			if($page<3){
				$debut=1;
				if($nbrepages>5){
					$fin=5;
				}
				else{
					$fin=$nbrepages;
				}				
			}
			else{
				$debut=$page-2;				
				if($nbrepages>$page+2){
					$fin=$page+2;
				}
				else{
					$fin=$nbrepages;
				}
			}
			echo '<a name="page" class="active" href="Amis.php?page=1"><<</a>';
			for($i=$debut;$i<=$fin;$i++){
				if($i==$page){
					echo '<a name="page" class="active" href="Amis.php?page='.$i.'">'.$i.'</a>';
				}
				else{
					echo '<a name="page" href="Amis.php?page='.$i.'">'.$i.'</a>';
				}
			}
			echo '<a name="page" class="active" href="Amis.php?page='.$nbrepages.'">>></a>';
			echo '</div>';
		}
	}	
}


function Demande_amis(){
	include('identifiant.php');
	session_start();
	if((isset($_SESSION['id']))&&(isset($_SESSION['pseudo']))){
		$query='select pseudo from Amis inner join  Membres on Membres.idMembres=idFrom WHERE idTo='.$_SESSION['id'].' AND status=1;';
		$query=$db->query($query) or die('Erreur'.mysql_error());
		echo '<div name="demandes_amis">';
		while($donnees=$query->fetch()){
			echo '<div name="demande_amis"><p name="demande"> Demande d\'amis de '.$donnees['pseudo'].'</p><a name="boutton_valide" type="submit" class="btn btn-success" onclick="supprimer_amis(\''.$donnees['pseudo'].'\',\'ajout\')"> Valider</a><a name="boutton_refuser" type="submit" class="btn btn-danger" onclick="supprimer_amis(\''.$donnees['pseudo'].'\',\'supprimer\')"> Refuser</a></div>';
		}
		echo "</div>";
	}
}
?>
