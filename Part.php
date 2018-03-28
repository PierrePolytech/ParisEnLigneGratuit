<?php
include 'function.php';
if(isset($_POST['mode'])){
	$mode=$_POST['mode'];
    switch ($mode) {
        case 'Tous':
            echo '<div name="titre">
                <p>Inscrivez-vous sur nos sites partenaires afin de profiter de toutes leurs offres de bienvenue et promotionnelles</p>
            </div>
            <div id="Ubinet" name="partenaire">
                <a name="lien_partenaire" href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank">
                    <p name="description_partenaire">Unibet.fr Paris en ligne sur le meilleur site de Paris sportifs,paris hippiques, turf et poker en ligne. Pas de frais de dépôts. 3 bonus d\'inscription : paris sportifs ...</p>
                    <img name="image_partenaire" src="http://media.unibet.fr/renderimage.aspx?pid=33149&bid=2244" border=0></img>
                </a>
            </div>
            <div id="Bwin" name="partenaire">
                <a name="lien_partenaire" href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">
                     <p name="description_partenaire" >Bwin propose 30 000 paris quotidiens dans plus de 90 sports (football,tennis,…) | paris et vidéos en direct, commentaires audio et bien plus encore !</p>
                    <img name="image_partenaire" src="https://mediaserver.bwinpartypartners.com/renderBanner.do?zoneId=1745624&t=i&v=1">                      
                </a>
            </div>
            <div id="Winamax" name="partenaire">
                <a name="lien_partenaire" href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">
                    <img id="logo_Winamax" src="./Images/logo_winamax.png">
                    <p name="description_partenaire" id="description_Winamax" >Winamax Agréé par l\'Arjel – Jouez au Poker en ligne et Pariez sur le Sport. Bénéficiez d\'un Bonus sur votre 1er dépôt (jusqu\'à 500€) et votre 1er pari est remboursé !</p>
                    
                    <div class="iframe-responsive-wrapper">
                        <iframe id="the_iframe" src="https://www.winamax.fr/affiliate/adserverbetting.php?affiliate_id=FREE-SPORTS-BETTING&size=728x90&sport=" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe> 
                    </div>
                </a>
            </div>';
            break;
        case 'Bwin':
            echo '<span>
                <h1>Bwin</h1>
                <img name="image_partenaire" src="https://mediaserver.bwinpartypartners.com/renderBanner.do?zoneId=1745624&t=i&v=1">
                <div class="avis_partenaire">
                    <p>Faut-il encore présenter Bwin, un des leaders mondiaux des paris sportifs eu Europe ? Le site a bâti sa réputation sur la <strong>qualité de sa plateforme et grâce à un grand nombre de paris proposés</strong>. Bwin.fr se distingue ainsi par le nombre de paris proposés sur chaque match de football, bien supérieur à se que vous pourrez trouver chez d’autres bookmakers.</p>
                    <p>Les paris live ne sont pas en reste, Bwin proposant certainement <strong>la meilleure interface pour parier en direct</strong>. De plus, de nombreux matchs tous sports confondus sont retransmis en vidéo sur le site. </p>
                    <p> Enfin, 
                        <b>
                            <a href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">Bwin rembourse votre premier pari</a>
                        </b> 
                        s\'il est perdant, jusqu\'à 100 euros ! Le tout en cash. Simple et efficace. Un vrai bon bonus, délivré une fois votre compte joueur validé.
                    </p>
                    <p align="right">
                        <strong>
                            <a href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">Découvrir Bwin <img src="Images/fleches.png" alt="Découvrir Bwin" width="25" height="12" border="0" align="absmiddle"></a>
                        </strong>
                    </p>
                </div>
            </span>
            <h3 class="titre_tableau_partenaire">L’offre de Bwin en bref</h3>
            <table class="tableau_partenaire" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="50%" align="center"class="bleu">Points forts<img src="Images/fleche-up.png" width="18" height="16" align="absmiddle"></td>
                    <td width="50%" align="center"class="bleu">Points faibles <img src="Images/fleche-down.png" width="18" height="16" align="absmiddle"></td>
                </tr>
                <tr>
                    <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Le meilleur site pour vos paris en direct</td>
                    <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Un support client pas toujours très réactif</td>
                </tr>
                <tr>
                    <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Un choix de paris sans équivalent</td>
                    <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Des frais sur les dépôts par carte bancaire</td>
                </tr>
            </table>
            <b  name="lien_bottom_partenaire" >
                <a href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">100€ remboursés en cash sur votre 1er pari en passant par ce lien !</a>
            </b> ';
            break; 
	case 'Betclic':
            echo '<span>
                <h1>Betclic</h1>
                <div class="avis_partenaire">
                    <p>Betclic.fr s\'est imposé sur le marché français et est aujourd\'hui 
			<strong>le meilleur bookmaker en France, en particulier pour les débutants</strong>
			. Le site est très facile d\'utilisation et <b><a href="https://www.betclic.fr/" target="_blank" rel="nofollow">rembourse votre premier pari jusque 100€</a></b> 
			s\'il est perdant, sans condition ! Betclic invente ainsi le droit à l\'erreur avec le pari gratuit de bienvenue !
		    </p>
                    <p align="right">
                        <strong>
                            <a href="https://www.betclic.fr/" target="_blank" rel="nofollow">Découvrir Betclic <img src="Images/fleches.png" alt="Découvrir Bwin" width="25" height="12" border="0" align="absmiddle"></a>
                        </strong>
                    </p>
                </div>
            </span>
            <h3 class="titre_tableau_partenaire">L’offre de Betclic en bref</h3>
            <table class="tableau_partenaire" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="50%" align="center"class="bleu">Points forts<img src="Images/fleche-up.png" width="18" height="16" align="absmiddle"></td>
                    <td width="50%" align="center"class="bleu">Points faibles <img src="Images/fleche-down.png" width="18" height="16" align="absmiddle"></td>
                </tr>
                <tr>
                    <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Votre premier pari remboursé jusque 100€ !</td>
                    <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Des paris secondaires parfois peu intéressants</td>
                </tr>
                <tr>
                    <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Un site particulièrement clair et efficace</td>
                    <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Des cotes très moyennes sur les sports moins médiatiques</td>
                </tr>
		<tr>
                    <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Des bonnes cotes sur la Ligue 1</td>
                </tr>
            </table>
            <b  name="lien_bottom_partenaire" >
                <a href="https://www.betclic.fr/" target="_blank" rel="nofollow">Profitez du bonus de 100€ remboursés proposé par Betclic !</a>
            </b> ';
            break; 
        case 'Unibet':
            echo '<span>
            <h1>Unibet</h1>
            <img name="image_partenaire" src="http://media.unibet.fr/renderimage.aspx?pid=33149&bid=2244" border=0></img>
            <div class="avis_partenaire">
                <p>
                    Unibet est l’un des plus importants bookmakers en Europe, bien connu des parieurs avisés ! Les atouts du site sont nombreux : cotes intéressantes, offre de paris très complète et ergonomie bien pensée, il est l\'un des plus intéressants du marché.
                </p>
                <p>
                    Ce qui fait aussi l’originalité d’Unibet.fr, ce sont les nombreuses promotions offertes régulièrement aux parieurs du site. Vous profiterez par exemple de paris remboursés en cas d’évènements particuliers dans un match, de cotes boostées jusqu\'à 15% pour les paris combinés ou encore de cagnottes mises en jeu pendant les plus grandes compétitions. Enfin, le bookmaker fait appel à l’expert Pierre Ménès qui donne ses pronostics sur le site.
                </p>
                <p align="right">
                    <strong>
                        <a href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank" rel="nofollow">Découvrir Unibet 
                        <img src="Images/fleches.png" alt="Découvrir Unibet" width="25" height="12" border="0" align="absmiddle"></a>
                    </strong>
                </p>
            </div>
        </span>
        <h3 class="titre_tableau_partenaire">L’offre de Unibet en bref</h3>
        <table class="tableau_partenaire" cellpadding="5" cellspacing="0">
            <tr>
                <td width="50%" align="center"class="bleu">Points forts<img src="Images/fleche-up.png" width="18" height="16" align="absmiddle"></td>
                <td width="50%" align="center"class="bleu">Points faibles <img src="Images/fleche-down.png" width="18" height="16" align="absmiddle"></td>
            </tr>
            <tr>
                <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Des cotes boostées sur les paris combinés</td>
                <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Peu de paris proposés sur les sports moins médiatiques</td>
            </tr>
            <tr>
                <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> De nombreuses promotions proposées régulièrement</td>
                <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Un service clients pas toujours très réactif</td>
            </tr>
        </table>
        <b name="lien_bottom_partenaire" >
            <a href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank" rel="nofollow">Cliquez ici pour profiter de 100€ de paris gratuits sur Unibet !</a>
        </b>';
            break; 
        case 'Winamax':
         echo '<span>
            <h1>Winamax</h1>
            <div class="iframe-responsive-wrapper">
                <iframe id="the_iframe" src="https://www.winamax.fr/affiliate/adserverbetting.php?affiliate_id=FREE-SPORTS-BETTING&size=728x90&sport=" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe> 
            </div>
            <div class="avis_partenaire">
                <p>Arrivé sur le marché français à l’occasion de la Coupe du Monde 2014, Winamax s’est directement imposé comme un futur poids lourd du secteur. L’opérateur se distingue particulièrement grâce au <strong>niveau de ses cotes très élevées en football</strong> sur les paris les plus populaires du marché (1N2, double chance, nul remboursé, etc…).</p>
                <p>L’autre grande force de Winamax, c’est son 
                    <b><a href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">bonus « premier pari remboursé », qui atteint 100€</a></b> 
                    ! Cette offre permettra à tout le monde de gagner gros sans trembler. Un luxe dont il serait dommage de se priver.
                </p>            
                <p align="right">
                    <strong>
                        <a href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">Découvrir Winamax <img src="Images/fleches.png" alt="Découvrir Winamax" width="25" height="12" border="0" align="absmiddle"></a>
                    </strong>
                </p>
             </div>
        </span>
        <h3 class="titre_tableau_partenaire">L’offre de Winamax en bref</h3>
        <table class="tableau_partenaire" cellpadding="5" cellspacing="0">
            <tr>
                <td width="50%" align="center"class="bleu">Points forts<img src="Images/fleche-up.png" width="18" height="16" align="absmiddle"></td>
                <td width="50%" align="center"class="bleu">Points faibles <img src="Images/fleche-down.png" width="18" height="16" align="absmiddle"></td>
            </tr>
            <tr>
                <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Des cotes attractives sur les paris 1-N-2 </td>
                <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Niveau des cotes sur les paris alternatifs</td>
            </tr>
            <tr>
                <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Un premier pari remboursé de 100€ !</td>
                <td><img src="Images/moins.png" width="18" height="18" align="absmiddle"> Peu de diversité dans les paris secondaires</td>
            </tr>
            <tr>
                <td><img src="Images/plus.png" width="18" height="18" align="absmiddle"> Une interface sobre et intuitive</td>
                <td></td>
            </tr>       
        </table>
        <b name="lien_bottom_partenaire" ><a href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">Profiter du premier pari remboursé de 100 euros proposé par Winamax</a></b>';
            break;
        default:
            echo '<div name="titre">
                <p>Inscrivez-vous sur nos sites partenaires afin de profiter de toutes leurs offres de bienvenue et promotionnelles</p>
            </div>
            <div id="Ubinet" name="partenaire">
                <a name="lien_partenaire" href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank">
                    <p name="description_partenaire">Unibet.fr Paris en ligne sur le meilleur site de Paris sportifs,paris hippiques, turf et poker en ligne. Pas de frais de dépôts. 3 bonus d\'inscription : paris sportifs ...</p>
                    <img name="image_partenaire" src="http://media.unibet.fr/renderimage.aspx?pid=33149&bid=2244" border=0></img>
                </a>
            </div>
            <div id="Bwin" name="partenaire">
                <a name="lien_partenaire" href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">
                     <p name="description_partenaire" >Bwin propose 30 000 paris quotidiens dans plus de 90 sports (football,tennis,…) | paris et vidéos en direct, commentaires audio et bien plus encore !</p>
                    <img name="image_partenaire" src="https://mediaserver.bwinpartypartners.com/renderBanner.do?zoneId=1745624&t=i&v=1">                      
                </a>
            </div>
            <div id="Winamax" name="partenaire">
                <a name="lien_partenaire" href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">
                    <img id="logo_Winamax" src="./Images/logo_winamax.png">
                    <p name="description_partenaire" id="description_Winamax" >Winamax Agréé par l\'Arjel – Jouez au Poker en ligne et Pariez sur le Sport. Bénéficiez d\'un Bonus sur votre 1er dépôt (jusqu\'à 500€) et votre 1er pari est remboursé !</p>
                    
                    <div class="iframe-responsive-wrapper">
                        <iframe id="the_iframe" src="https://www.winamax.fr/affiliate/adserverbetting.php?affiliate_id=FREE-SPORTS-BETTING&size=728x90&sport=" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe> 
                    </div>
                </a>
            </div>';
            break;
    }
}
else{
    echo '<div name="titre">
                <p>Inscrivez-vous sur nos sites partenaires afin de profiter de toutes leurs offres de bienvenue et promotionnelles</p>
            </div>
            <div id="Ubinet" name="partenaire">
                <a name="lien_partenaire" href="http://media.unibet.fr/redirect.aspx?pid=33149&bid=2244" target="_blank">
                    <p name="description_partenaire">Unibet.fr Paris en ligne sur le meilleur site de Paris sportifs,paris hippiques, turf et poker en ligne. Pas de frais de dépôts. 3 bonus d\'inscription : paris sportifs ...</p>
                    <img name="image_partenaire" src="http://media.unibet.fr/renderimage.aspx?pid=33149&bid=2244" border=0></img>
                </a>
            </div>
            <div id="Bwin" name="partenaire">
                <a name="lien_partenaire" href="https://sports.bwin.be/fr/sports?wm=4511836&zoneId=1745624" target="_blank" rel="nofollow">
                     <p name="description_partenaire" >Bwin propose 30 000 paris quotidiens dans plus de 90 sports (football,tennis,…) | paris et vidéos en direct, commentaires audio et bien plus encore !</p>
                    <img name="image_partenaire" src="https://mediaserver.bwinpartypartners.com/renderBanner.do?zoneId=1745624&t=i&v=1">                      
                </a>
            </div>
            <div id="Winamax" name="partenaire">
                <a name="lien_partenaire" href="http://www.winamax.fr/landing/landing_leads.php?banid=30672" target="_blank" rel="nofollow">
                    <img id="logo_Winamax" src="./Images/logo_winamax.png">
                    <p name="description_partenaire" id="description_Winamax" >Winamax Agréé par l\'Arjel – Jouez au Poker en ligne et Pariez sur le Sport. Bénéficiez d\'un Bonus sur votre 1er dépôt (jusqu\'à 500€) et votre 1er pari est remboursé !</p>
                    
                    <div class="iframe-responsive-wrapper">
                        <iframe id="the_iframe" src="https://www.winamax.fr/affiliate/adserverbetting.php?affiliate_id=FREE-SPORTS-BETTING&size=728x90&sport=" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe> 
                    </div>
                </a>
            </div>';
}

?>