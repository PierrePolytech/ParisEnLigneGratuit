<?php
	$query='SELECT idParis FROM Paris WHERE Paris.situation=\'Attente\'';
	$query=$db->query($query) or die('Erreur'.mysql_error());
	while($donnees=$query->fetch()){
		
	}
?>