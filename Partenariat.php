
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vous êtes toujours demandé qui de vos amis est le meilleur sur les pronostics, ou si vous pouviez gagner de l'argent sur des sites de paris en ligne. Voici FreeSportsBetting !! " />
    <meta name="keywords" content="Paris sportifs gratuits,paris,défis,gratuit,amis,pronostics" />
    <title>Suivez l'actualités et les offres de nos partenaires</title>
<link rel="icon" type="image/png" href="Images/icon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="function.js"></script>
	<link rel="stylesheet" href="css/partenariat.css" />
</head>

<body>
	<header id="entete">
        <div class="container">
            <div class="row" name="bandeau_entete">
                <div id="nom_site" class="col-lg-2 col-md-3 col-sm-4 col-xs-3">
                    <img id="image_logo" src="Images/logo.png">
                </div>
                <div id="gestion_compte" class="col-lg-10 col-md-9 col-sm-8 col-xs-9">
                    <?php
                        include 'function.php';
                        Affichage_entete(false); 
                    ?>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-10">
                    <nav>
                      <div class="navbar-justified" >
                        <ul name="nav_bar_entete">
                            <li name="li_nav_bar"><a name="a_nav_bar" href="index.php">Paris</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Actualités.php">Actualités</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Classement.php">Classement</a></li>
                            <li name="li_nav_bar"><a name="a_nav_bar" href="Partenariat.php">Partenariat</a></li>
                        </ul>
                      </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div id="corps">
        <div class="container">
            <ul class="nav nav-justified" name="sous-menu">
                <li name="infos_sous-menu" ><a name="a_nav_bar2">Tous</a></li>
		<li name="infos_sous-menu" ><a name="a_nav_bar2">Winamax</a></li>
		<li name="infos_sous-menu" ><a name="a_nav_bar2">Betclic</a></li>
                <li name="infos_sous-menu" ><a name="a_nav_bar2">Unibet</a></li>
                <li name="infos_sous-menu" ><a name="a_nav_bar2">Bwin</a></li>                
            </ul>
            <div id="affichage_partenaire">
                <div name="titre">
                <p>Inscrivez-vous sur nos sites partenaires afin de profiter de toutes leurs offres de bienvenue et promotionnelles</p>
            </div>
	    <div id="Winamax" name="partenaire">
                <a name="lien_partenaire" href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">
                    <img id="logo_Winamax" src="./Images/logo_winamax.png">
                    <p name="description_partenaire" id="description_Winamax" >Winamax Agréé par l'Arjel – Jouez au Poker en ligne et Pariez sur le Sport. Bénéficiez d'un Bonus sur votre 1er dépôt (jusqu'à 500€) et votre 1er pari est remboursé !</p>
                    
                    <div class="iframe-responsive-wrapper">
                        <iframe id="the_iframe" src="https://www.winamax.fr/affiliate/adserverbetting.php?affiliate_id=FREE-SPORTS-BETTING&size=728x90&sport=" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe> 
                    </div>
                </a>
            </div>
	    <div id="Betclic" name="partenaire">
                <a name="lien_partenaire" href="https://www.betclic.fr/" target="_blank">
                    <p name="description_partenaire">Betclic, Jouez sur le leader français des paris sportifs. Pour varier les plaisirs, découvrez nos offres de Poker en ligne et de paris hippiques!</p>
                    
                </a>
            </div>
            <div id="Ubinet" name="partenaire">
                <a name="lien_partenaire" href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank">
                    <p name="description_partenaire">Unibet.fr Paris en ligne sur le meilleur site de Paris sportifs,paris hippiques, turf et poker en ligne. Pas de frais de dépôts. 3 bonus d'inscription : paris sportifs ...</p>
                    <img name="image_partenaire" src="http://media.unibet.fr/renderimage.aspx?pid=33149&bid=2244" border=0></img>
                </a>
            </div>
            <div id="Bwin" name="partenaire">
                <a name="lien_partenaire" href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">
                     <p name="description_partenaire" >Bwin propose 30 000 paris quotidiens dans plus de 90 sports (football,tennis,…) | paris et vidéos en direct, commentaires audio et bien plus encore !</p>
                    <img name="image_partenaire" src="https://mediaserver.bwinpartypartners.com/renderBanner.do?zoneId=1745624&t=i&v=1">                      
                </a>
            </div>
            </div>     
        </div>
    </div>
</body>
<script type="text/javascript">
    document.getElementsByName('a_nav_bar2')[0].onclick=function(){affichage_partenaire('Tous')};
    document.getElementsByName('a_nav_bar2')[1].onclick=function(){affichage_partenaire('Winamax')};
    document.getElementsByName('a_nav_bar2')[2].onclick=function(){affichage_partenaire('Betclic')};
    document.getElementsByName('a_nav_bar2')[3].onclick=function(){affichage_partenaire('Unibet')};
    document.getElementsByName('a_nav_bar2')[4].onclick=function(){affichage_partenaire('Bwin')};
	
</script>
</html>
