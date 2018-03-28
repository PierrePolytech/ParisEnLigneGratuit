<?php
include 'function.php';
if(isset($_POST['mode'])){
	$mode=$_POST['mode'];
    switch ($mode) {
        case 'Basketball':
            echo '<div id="infos_nba" class="col-sm-6  col-md-6 col-lg-6"><a href="http://www.nba.com/news/?ls=iref:nba:gnav" target="_blank" > <img class="logo_image" src="Images/nba_rss.png"></a>';
            affichage_rss2("http://www.nba.com/rss/nba_rss.xml");
            echo '</div><div id="infos_equipe" class="col-sm-6  col-md-6 col-lg-6 "><a href="http://www.lequipe.fr/Basket/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss_Basket.xml"); 
            break;
        case 'Tous':
            echo '<div id="infos_equipe" class="col-sm-6  col-md-6 col-lg-6 "><a href="http://www.lequipe.fr" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss.xml"); 
            echo '</div><div id="infos_Eurosport" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.eurosport.fr/" target="_blank" ><img class="logo_image"  src="Images/eurosport_logo.png"></a>';
            affichage_rss2("http://www.eurosport.fr/rss.xml");
            echo '</div>';
            break;
        case 'Football':
            echo '</div><div id="infos_equipe" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.lequipe.fr/Football/" target="_blank" ><img class="logo_image"  src="Images/equipe_rss.jpg"></a>';
            affichage_rss2("http://www.lequipe.fr/rss/actu_rss_Football.xml"); 
            echo '</div><div id="infos_basketUSA" class="col-sm-6 col-md-6 col-lg-6 "><a href="http://www.footmercato.net/" target="_blank" ><img class="logo_image"  src="Images/footMercato.svg"></a>';
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

?>
