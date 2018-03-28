<?php
	try
	{
	$db = new PDO('mysql:host=db648385351.db.1and1.com;dbname=db648385351;charset=utf8', 'dbo648385351', '?@pn6f7dygYoz');

	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
?>
