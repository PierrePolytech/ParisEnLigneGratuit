<?php
	include 'function.php';
	if((isset($_POST['Sport']))&&(isset($_POST['Event']))){
		Affichage_matchs($_POST['Sport'],$_POST['Event']);
	}
	else if((isset($_POST['SportSup']))&&(isset($_POST['EventSup']))&&(isset($_POST['MatchSup']))){
		Affichage_Paris_Sup($_POST['SportSup'],$_POST['EventSup'],$_POST['MatchSup']);
	}
?>