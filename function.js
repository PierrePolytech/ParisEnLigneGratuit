function Affichage_paris(sport,eventSport){
	$.post("Affichage.php", 
        { 
            Sport:sport,
            Event:eventSport
        },
        function(response,status){ 
            document.getElementById('affichage_matchs').innerHTML=''+response+'';
            var sport =document.getElementsByName("nom_sport");
            for(var i=0;i<sport.length;i++){
                console.log(sport[i].innerHTML);
                var content=sport[i].innerHTML;

                switch(sport[i].innerHTML) {
                    case "Football":
                        sport[i].innerHTML="<div class=\"sport-icon-1\"></div> Football";
                        break;
                    case "Basket-ball":
                        sport[i].innerHTML="<div class=\"sport-icon-2\"></div> Basket-ball";
                        break;
                    case "Tennis":
                        sport[i].innerHTML="<div class=\"sport-icon-5\"></div> Tennis";
                        break;
                    case "Formule 1":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Formule 1";
                        break;
                    case "Rugby à XV":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XV";
                        break;
                    case "Cyclisme":
                        sport[i].innerHTML="<div class=\"sport-icon-17\"></div> Cyclisme";
                        break;
                    case "Golf":
                        sport[i].innerHTML="<div class=\"sport-icon-9\"></div> Golf";
                        break;
                    case "Volley-ball":
                        sport[i].innerHTML="<div class=\"sport-icon-7\"></div> Volley-ball";
                        break;
                     case "Handball":
                        sport[i].innerHTML="<div class=\"sport-icon-6\"></div> Handball";
                        break;
                    case "Hockey sur glace":
                        sport[i].innerHTML="<div class=\"sport-icon-4\"></div> Hockey sur glace";
                        break;
                    case "Football américain":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Football américain";
                        break;
                    case "Moto":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Moto";
                        break;
                    case "Boxe":
                        sport[i].innerHTML="<div class=\"sport-icon-10\"></div> Boxe";
                        break;
                    case "Rallye":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Rallye";
                        break;
                    case "Baseball":
                        sport[i].innerHTML="<div class=\"sport-icon-3\"></div> Baseball";
                        break;
                     case "Rugby à XIII":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XIII";
                        break;
                    case "Speedway":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Speedway";
                        break;
                    case "Australian Rules":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Australian Rules";
                        break;
                }
            }
    });
}

function Affichage_paris_sup(sport,eventSport,match){
	$.post("Affichage.php", 
        { 
            SportSup:sport,
            EventSup:eventSport,
            MatchSup:match
        },
        function(response,status){ 
            document.getElementById('affichage_matchs').innerHTML=''+response+'';
            if(document.getElementsByName("li_bet")){
                var x= document.getElementsByName("li_bet");
                for (var i = 0; i < x.length; i++) {
                    var cpt=0;
                    for (var j = 0; j < x[i].childNodes.length; j++) {
                        if (x[i].childNodes[j].getAttribute('name') == "divParisSup") {
                           cpt++;
                        }
                        if(cpt>5){
                            x[i].childNodes[j].style.display="none";
                        }     
                    }
                    if(cpt>5){
                        var span = document.createElement('span');
                        span.setAttribute('class','minimized');
                        span.setAttribute('name','fleche_voir');
                        span.setAttribute('id','fleche_voir'+i);
                        span.setAttribute('onclick','fleche_voir('+i+',\'etire\')');
                        span.innerHTML="Tout voir...";
                        x[i].appendChild(span);
                    }     
                }
            }
            var sport =document.getElementsByName("nom_sport");
            for(var i=0;i<sport.length;i++){
                console.log(sport[i].innerHTML);
                var content=sport[i].innerHTML;

                switch(sport[i].innerHTML) {
                    case "Football":
                        sport[i].innerHTML="<div class=\"sport-icon-1\"></div> Football";
                        break;
                    case "Basket-ball":
                        sport[i].innerHTML="<div class=\"sport-icon-2\"></div> Basket-ball";
                        break;
                    case "Tennis":
                        sport[i].innerHTML="<div class=\"sport-icon-5\"></div> Tennis";
                        break;
                    case "Formule 1":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Formule 1";
                        break;
                    case "Rugby à XV":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XV";
                        break;
                    case "Cyclisme":
                        sport[i].innerHTML="<div class=\"sport-icon-17\"></div> Cyclisme";
                        break;
                    case "Golf":
                        sport[i].innerHTML="<div class=\"sport-icon-9\"></div> Golf";
                        break;
                    case "Volley-ball":
                        sport[i].innerHTML="<div class=\"sport-icon-7\"></div> Volley-ball";
                        break;
                     case "Handball":
                        sport[i].innerHTML="<div class=\"sport-icon-6\"></div> Handball";
                        break;
                    case "Hockey sur glace":
                        sport[i].innerHTML="<div class=\"sport-icon-4\"></div> Hockey sur glace";
                        break;
                    case "Football américain":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Football américain";
                        break;
                    case "Moto":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Moto";
                        break;
                    case "Boxe":
                        sport[i].innerHTML="<div class=\"sport-icon-10\"></div> Boxe";
                        break;
                    case "Rallye":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Rallye";
                        break;
                    case "Baseball":
                        sport[i].innerHTML="<div class=\"sport-icon-3\"></div> Baseball";
                        break;
                     case "Rugby à XIII":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Rugby à XIII";
                        break;
                    case "Speedway":
                        sport[i].innerHTML="<div class=\"sport-icon-11\"></div> Speedway";
                        break;
                    case "Australian Rules":
                        sport[i].innerHTML="<div class=\"sport-icon-12\"></div> Australian Rules";
                        break;
                }
            }
    });
}

function fleche_voir(i,type){
    var x=document.getElementsByName("li_bet")[i];
    var cpt=0;
    for (var j = 0; j < x.childNodes.length; j++) {
        if(type=="etire"){
            x.childNodes[j].style.display="";
        }
        else{
            if((type=="minimized")&&(cpt>5)&&(x.childNodes[j].getAttribute('name') == "divParisSup")){
                x.childNodes[j].style.display="none";
            }
        }
        cpt++;
    }
    if(type=="minimized"){
        document.getElementById("fleche_voir"+i).setAttribute('class','minimized');
        document.getElementById("fleche_voir"+i).setAttribute('onclick','fleche_voir('+i+',\'etire\')');
        document.getElementById("fleche_voir"+i).innerHTML="Tout voir...";
    }
    else if(type=="etire"){
        document.getElementById("fleche_voir"+i).setAttribute('class','etire');
        document.getElementById("fleche_voir"+i).setAttribute('onclick','fleche_voir('+i+',\'minimized\')');
        document.getElementById("fleche_voir"+i).innerHTML="Réduire";
    }
    
}



function parier(match,cote,vainqueur,id,date,nomsport,nomevent,codebet){
    var regex_match=new RegExp ("[ ]+-","g"); // regx pour vainqueur
    var tab_name_match=match.split(regex_match);
    if(!(document.getElementById('paris_selectionne'))){
        if(document.getElementById('affichage_init_paris_conteneur')){ document.getElementById('affichage_init_paris_conteneur').remove();}
        $('<div id="affichage_paris_conteneur"><p id="p_parie" name="Simple"><i class="fa fa-fw fa-shopping-cart"></i><span id="p_nbre_paris">paris sélectionnés</span><i onclick="SuppressionParis()" class="fa fa-fw fa-trash-o"></i></p><ul class="nav nav-tabs nav-justified"><li id="Type_simple" role="presentation" class="active"><a>SIMPLE</a></li><li id="Type_combine" role="presentation" class=""><a >COMBINE</a></li></ul><div id="paris_selectionne"></div><div id="totale_paris"></div></div>').appendTo('#conteneur_paris');
    }
    if(document.getElementById('p_parie').getAttribute("name")=="Combine"){
        document.getElementById('Type_simple').setAttribute("onclick","Simple(\'Normale\')");
        document.getElementById('Type_combine').setAttribute("onclick","");
    }
    else if(document.getElementById('p_parie').getAttribute("name")=="Simple"){
        document.getElementById('Type_simple').setAttribute("onclick","");
    }


    if(document.getElementById('mise'+id+'')){
        document.getElementById('mise'+id+'').remove();
        if(document.getElementById('p_parie').getAttribute("name")=="Simple"){Calcule_gain_totale("Normale");}
        else if(document.getElementById('p_parie').getAttribute("name")=="Combine"){
             if((document.getElementsByName('paris_matchs').length<2)){ Simple('Normale');}
        }
    }
    else{
        if((document.getElementById('p_parie').getAttribute("name")=="Simple")){
            if(!(document.getElementById('paris_selectionne_simple'))){$('<div id="paris_selectionne_simple"></div> ').appendTo('#paris_selectionne');}
            $('<div id="mise'+id+'" type="normal" codebet="'+codebet+'" sport="'+nomsport+'" event="'+nomevent+'" name="paris_matchs" start-date="'+date+'"></div>').appendTo('#paris_selectionne_simple');
        }
        else if ((document.getElementById('p_parie').getAttribute("name")=="Combine")){
            if(!(document.getElementById('paris_selectionne_combine'))){$('<div id="paris_selectionne_combine"></div> ').appendTo('#paris_selectionne');}
            $('<div id="mise'+id+'" type="normal" codebet="'+codebet+'" sport="'+nomsport+'" event="'+nomevent+'" name="paris_matchs" start-date="'+date+'"></div>').appendTo('#paris_selectionne_combine');
        }
        
        $('<p name="id_match">'+match+'</p><i onclick="SuppressionParisID(\'mise'+id+'\',\'Normale\')" class="fa fa-times" aria-hidden="true"></i>').appendTo('#mise'+id+'');
        if(vainqueur=="%2%"){
            $('<p name="id_paris" vainqueur="%2%">Résultat:<b>'+tab_name_match[1]+'</b></p>').appendTo('#mise'+id+'');
        }
        else if (vainqueur=="%1%"){
            $('<p name="id_paris" vainqueur="%1%">Résultat:<b>'+tab_name_match[0]+'</b></p>').appendTo('#mise'+id+'');
        }
        else if(vainqueur=="Nul"){
            $('<p name="id_paris" vainqueur="Nul">Résultat: <b>Match nul</b></p>').appendTo('#mise'+id+'');
        }
        else{
            var patt = new RegExp("%1%");
            var patt2 = new RegExp("%2%");
            if((patt.test(vainqueur))||(patt2.test(vainqueur))){
                var textvainqueur=vainqueur.replace("%1%",tab_name_match[0]);
                textvainqueur=textvainqueur.replace("%2%",tab_name_match[1]);
                $('<p name="id_paris" vainqueur="'+vainqueur+'">Résultat: <b>'+textvainqueur+'</b></p>').appendTo('#mise'+id+'');
            }
            else{
                $('<p name="id_paris" vainqueur="'+vainqueur+'">Résultat: <b>'+vainqueur+'</b></p>').appendTo('#mise'+id+'');
            }
        }
        
        $('<p name="id_cote">'+parseFloat(cote).toFixed(2)+'</p>').appendTo('#mise'+id+'');
        if(document.getElementById('p_parie').getAttribute("name")=="Simple"){
            $('<div class="form-inline"><div class="form-group" lang="en-US"><label class="control-label" for="Valeur_mise"> Votre mise :</label><input name="Valeur_mise" min="0" pattern="[0-9]+([,\.][0-9]+)?" formnovalidate step="0.5" type="number" id="InputMise'+id+'" size="3" placeholder="Mise" oninput="Calcule_gain('+id+','+cote+',\'Normale\')"></div></div><p name="result" id="Result'+id+'"></p>').appendTo('#mise'+id+'');
        
        }


    }
    if((document.getElementById('p_parie').getAttribute("name")=="Simple")&&(document.getElementsByName('Valeur_mise').length!=0)&&(!(document.getElementById('mises_globales')))&&(!(document.getElementById('gains_globals')))){
        $('<p id="mises_globales"></p><p id="gains_globals"></p><div id="boutton_parier"></div>').appendTo('#totale_paris');
    }
    else if(((document.getElementsByName('Valeur_mise').length==0)&&(document.getElementById('p_parie').getAttribute("name")=="Simple"))||((document.getElementById('p_parie').getAttribute("name")=="Combine")&&(document.getElementsByName('paris_matchs').length==0))){
        if(document.getElementById('affichage_paris_conteneur')){document.getElementById('affichage_paris_conteneur').remove()};
        if(document.getElementById('mises_globales')){document.getElementById('mises_globales').remove();}
        if(document.getElementById('gains_globals')){document.getElementById('gains_globals').remove();}
        if(document.getElementById('boutton_parier')){document.getElementById('boutton_parier').remove();}
        $('<div id="affichage_init_paris_conteneur"><p id="p_parie"><i class="fa fa-fw fa-shopping-cart"></i>0 pari sélectionné</p><p name="description">Ajoutez des paris à votre sélection en cliquant sur les cotes</p></div>').appendTo('#conteneur_paris');
    }
    else if (document.getElementById('p_parie').getAttribute("name")=="Combine"){
        $('<p id="mises_globales"></p><p id="gains_globals"></p><div id="boutton_parier"></div>').appendTo('#totale_paris');
        document.getElementById('mises_globales').innerHTML= "<div class=\"form-inline\"><div class=\"form-group\" lang=\"en-US\"><label class=\"control-label\" for=\"Valeur_mise\" >Votre mise :</label><input name=\"Valeur_mise\" min=\"0\" pattern=\"[0-9]+([,\.][0-9]+)?\" step=\"0.5\" formnovalidate type=\"number\" id=\"InputMise"+id+"\" size=\"3\" placeholder=\"Mise\" oninput=\"Calcule_gain_totale_Combine('Normale')\"></div></div>";
        Calcule_gain_totale_Combine("Normale");
    }
    if((document.getElementsByName('paris_matchs').length<2)){        
        if  (document.getElementById('Type_combine')){
            document.getElementById('Type_combine').setAttribute("class","disabled");
            document.getElementById('Type_combine').removeAttribute("onclick");
        }
    }
    else{
        if(document.getElementById('p_parie').getAttribute("name")!="Combine"){
            document.getElementById('Type_combine').setAttribute("onclick","Combine(\'Normale\')");
            document.getElementById('Type_combine').removeAttribute("class");
        }
        else{
            document.getElementById('Type_combine').setAttribute("class","active");
        }
    }
    if (document.getElementById("paris_selectionne")){
        var x=document.getElementById("paris_selectionne").children[0].children.length;
        if(x==1) document.getElementById("p_nbre_paris").innerHTML= '<span id="span_nbre_paris">'+x+'</span> paris sélectionné';
        else document.getElementById("p_nbre_paris").innerHTML= '<span id="span_nbre_paris">'+x+'</span> paris sélectionnés';
    }
 }
 


 function Calcule_gain(id,cote,type){
    if(document.getElementById('p_parie').getAttribute("name")=="Simple"){
        var x = document.getElementById('InputMise'+id+'').value;
        
        if(x>0){
            document.getElementById('Result'+id+'').innerHTML = "Gains Potentiels: <p name=\"gain_potentiel\">" + Number((x*cote).toFixed(2))+"<i class=\"fa fa-fw fa-eur\"></i></p>";
            Calcule_gain_totale(type);
        }
        else{
            document.getElementById('Result'+id+'').innerHTML = "Gains Potentiels: <p name=\"gain_potentiel\"> 0 <i class=\"fa fa-fw fa-eur\"></i></p>";
            Calcule_gain_totale(type);
        }
        
    }    

}

function Calcule_gain_totale_Combine(type){
    var Cote_totale=1.00;
    var Gain_totale=0.00;
    $('p[name="id_cote"]').each(function(){  Cote_totale=Cote_totale*(parseFloat($(this).text())); });
    if ((document.getElementsByName('Valeur_mise')[0].value!="")&&(document.getElementsByName('Valeur_mise')[0].value>0)){
        Gain_totale = parseFloat(document.getElementsByName('Valeur_mise')[0].value);
        Gain_totale= Gain_totale*Cote_totale;
    }
    document.getElementById('gains_globals').innerHTML="<div id=\"cote_totale_combine\"> Cote totale :<p name=\"valeur_totale\">"+Number(Cote_totale).toFixed(2)+"</p></div><div id=\"gains_globals_combine\">Gains potentiels :<p name=\"valeur_totale\">"+Number((Gain_totale).toFixed(2))+"<i class=\"fa fa-fw fa-eur\"></i></p></div>";
    if(document.getElementsByName('Valeur_mise')[0].value>0){
        document.getElementById('boutton_parier').innerHTML="<a id=\"boutton_valide_paris\" type=\"submit\" name=\"submit\" class=\"btn btn-default\" onclick=\"myFunction();\">Parier maintenant</a>";
    }
    else{
        document.getElementById('boutton_parier').innerHTML="<a id=\"boutton_valide_paris\" disabled=\"disabled\" type=\"submit\" name=\"submit\" class=\"btn btn-default\" onclick=\"myFunction()\">Parier maintenant</a>";
        
    }

    
    
    
}

 function Calcule_gain_totale(type){
    if(document.getElementById('p_parie').getAttribute("name")=="Simple"){
        if((document.getElementById('mises_globales'))&&(document.getElementById('gains_globals'))){
            var regex_gain=new RegExp ("[:]","g"); 
            var x = document.getElementsByName('Valeur_mise');
            var y=document.getElementsByName('result');
            var Valeur_mise=0;
            var Valeur_cote=0;
            for(var i=0;i<x.length;i++){
                if((x[i].value!="")&&(x[i].value>0)){Valeur_mise=Valeur_mise+parseFloat(x[i].value)};
            }
            for(var j=0;j<y.length;j++){
                var gain=y[j].innerText.split(regex_gain);
                if(y[j].innerText!=""){Valeur_cote=Valeur_cote+parseFloat(gain[1])};
            }
            document.getElementById('mises_globales').innerHTML="Mise totale : <p name=\"valeur_totale\">"+Number((Valeur_mise).toFixed(2))+"<i class=\"fa fa-fw fa-eur\"></i></p>";
            document.getElementById('gains_globals').innerHTML="Gains potentiels : <p name=\"valeur_totale\">"+Number((Valeur_cote).toFixed(2))+"<i class=\"fa fa-fw fa-eur\"></i></p>";
            if(Valeur_mise>0){
                document.getElementById('boutton_parier').innerHTML="<a id=\"boutton_valide_paris\" type=\"submit\" name=\"submit\" class=\"btn btn-default\" onclick=\"myFunction()\">Parier maintenant</a>";
            }
            else{
                if(type=="Normale"){
                    document.getElementById('boutton_parier').innerHTML="<a id=\"boutton_valide_paris\" disabled=\"disabled\" type=\"submit\" name=\"submit\" class=\"btn btn-default\">Parier maintenant</a>";
                }
                else if(type=="Speciaux"){
                    document.getElementById('boutton_parier').innerHTML="<a id=\"boutton_valide_paris\" disabled=\"disabled\" type=\"submit\" name=\"submit\" class=\"btn btn-default\">Parier maintenant</a>";
                }
            }
            
        }
    }
}

function Combine(type){
    if(document.getElementById('mises_globales')){document.getElementById('mises_globales').remove();}
    if(document.getElementById('gains_globals')){document.getElementById('gains_globals').remove();}
    if(document.getElementById('boutton_parier')){document.getElementById('boutton_parier').remove();}


    document.getElementById('Type_combine').setAttribute("class", "active");
    document.getElementById('Type_simple').removeAttribute("class");
    document.getElementById('p_parie').setAttribute("name","Combine");


    if(!(document.getElementById('paris_selectionne_combine'))){$('<div id="paris_selectionne_combine"></div> ').appendTo('#paris_selectionne');}
    var tabCote=new Array();
    var tabId =new Array();
    var tabDate= new Array();
    var tabMatch= new Array();
    var tabCodeResult= new Array();
    var tabType= new Array();
    var typeParis=$('p[id="p_parie"]').attr("name");
    var tabSport=new Array();
    var tabEvent=new Array();
    var tabCodeBet = new Array();
    $('p[name="id_cote"]').each(function(){ tabCote.push($(this).text()); });
    $('p[name="id_match"]').each(function(){ tabMatch.push($(this).text()); });
    $('p[name="id_paris"]').each(function(){ tabCodeResult.push($(this).attr("vainqueur")); });
    $('div[name="paris_matchs"]').each(function(){ tabId.push($(this).attr("id"));tabCodeBet.push($(this).attr("codebet"));tabSport.push($(this).attr("sport"));if($(this).attr("event")){tabEvent.push($(this).attr("event"))}else{tabEvent.push('NULL')};if($(this).attr("start-date")){tabDate.push($(this).attr("start-date"))}else{tabDate.push('NULL')}; tabType.push($(this).attr("type")); });

    if(document.getElementById('paris_selectionne_simple')){document.getElementById('paris_selectionne_simple').remove();}
    for(var i=0;i<tabMatch.length;i++){
    	parier(tabMatch[i],tabCote[i],tabCodeResult[i],tabId[i].substring(tabId[i].lastIndexOf('e')+1,tabId[i].length),tabDate[i],tabSport[i],tabEvent[i],tabCodeBet[i]);           
    }
}


function Simple(type){
    if(document.getElementById('mises_globales')){document.getElementById('mises_globales').remove();}
    if(document.getElementById('gains_globals')){document.getElementById('gains_globals').remove();}
    if(document.getElementById('boutton_parier')){document.getElementById('boutton_parier').remove();}
     
    
    document.getElementById('Type_simple').setAttribute("class", "active");
    document.getElementById('Type_combine').removeAttribute("class");
    document.getElementById('p_parie').setAttribute("name","Simple");


    if(!(document.getElementById('paris_selectionne_simple'))){$('<div id="paris_selectionne_simple"></div> ').appendTo('#paris_selectionne');}
    var tabCote=new Array();
    var tabId =new Array();
    var tabDate= new Array();
    var tabMatch= new Array();
    var tabCodeResult= new Array();
    var tabType= new Array();
    var typeParis=$('p[id="p_parie"]').attr("name");
    var tabSport=new Array();
    var tabEvent=new Array();
    var tabCodeBet = new Array();
    $('p[name="id_cote"]').each(function(){ tabCote.push($(this).text()); });
    $('p[name="id_match"]').each(function(){ tabMatch.push($(this).text()); });
    $('p[name="id_paris"]').each(function(){ tabCodeResult.push($(this).attr("vainqueur")); });
    $('div[name="paris_matchs"]').each(function(){ tabId.push($(this).attr("id"));tabCodeBet.push($(this).attr("codebet"));tabSport.push($(this).attr("sport"));if($(this).attr("event")){tabEvent.push($(this).attr("event"))}else{tabEvent.push('NULL')};if($(this).attr("start-date")){tabDate.push($(this).attr("start-date"))}else{tabDate.push('NULL')}; tabType.push($(this).attr("type")); });

    if(document.getElementById('paris_selectionne_combine')){document.getElementById('paris_selectionne_combine').remove();}
    for(var i=0;i<tabMatch.length;i++){
         parier(tabMatch[i],tabCote[i],tabCodeResult[i],tabId[i].substring(tabId[i].lastIndexOf('e')+1,tabId[i].length),tabDate[i],tabSport[i],tabEvent[i],tabCodeBet[i]);           
    }   
}

function SuppressionParis(){
    document.getElementById('affichage_paris_conteneur').remove();
    $('<div id="affichage_init_paris_conteneur"><p id="p_parie"><i class="fa fa-fw fa-shopping-cart"></i>0 pari sélectionné</p><p name="description">Ajoutez des paris à votre sélection en cliquant sur les cotes</p></div>').appendTo('#conteneur_paris');
}


function SuppressionParisID(id,type){
    document.getElementById(''+id+'').remove();
    if(document.getElementsByName('paris_matchs').length==0){
        if(document.getElementById('mises_globales')){document.getElementById('mises_globales').remove();}
        if(document.getElementById('gains_globals')){document.getElementById('gains_globals').remove();}
        if(document.getElementById('boutton_parier')){document.getElementById('boutton_parier').remove();}
        if(document.getElementById('affichage_paris_conteneur')){document.getElementById('affichage_paris_conteneur').remove()};
        $('<div id="affichage_init_paris_conteneur"><p id="p_parie"><i class="fa fa-fw fa-shopping-cart"></i>0 pari sélectionné</p><p name="description">Ajoutez des paris à votre sélection en cliquant sur les cotes</p></div>').appendTo('#conteneur_paris');
    }
    else{
        if(document.getElementById('p_parie').getAttribute("name")=="Combine"){
            if(document.getElementsByName('paris_matchs').length<2){ 
                Simple('Normale');
		Calcule_gain_totale(type);
            }
	    else{
		Calcule_gain_totale_Combine(type);
	    }
        }
        if((document.getElementById('Type_combine'))&&(document.getElementsByName('paris_matchs').length<2)){
            document.getElementById('Type_combine').setAttribute("class","disabled");
            document.getElementById('Type_combine').removeAttribute("onclick");
        }
	if(document.getElementById('p_parie').getAttribute("name")=="Simple"){
		Calcule_gain_totale(type);	
	}
    }
    if (document.getElementById("paris_selectionne")){
        var x=document.getElementById("paris_selectionne").children[0].children.length;
        if(x==1) document.getElementById("p_nbre_paris").innerHTML= '<span id="span_nbre_paris">'+x+'</span> paris sélectionné';
        else document.getElementById("p_nbre_paris").innerHTML= '<span id="span_nbre_paris">'+x+'</span> paris sélectionnés';
    }
}

function Connexion(){
    node = document.getElementById('form_connexion');
    if (node.style.visibility=="hidden"){
	if(document.getElementsByName('erreur').length==1){
	  document.getElementsByName('erreur')[0].remove();		
	}
        node.style.visibility = "visible";
        node.style.height = "auto";         // Optionnel rétablir la hauteur
    }else{
        node.style.visibility = "hidden";
        node.style.height = "0";            // Optionnel libérer l'espace
    }
}

function supprimer_amis(pseudo,mode){
    if(document.getElementById('boutton_connecte')){
        document.location.href="Connexion.php";
    }
    else{
        $.post("supprimer_amis.php", //Required URL of the page on server
                { // Data Sending With Request To Server
                    Pseudo:pseudo,
                    Mode:mode
                },function(response,status){ // Required Callback Function
                    document.location.href="Amis.php";
                    console.log(response);
        });
    }
}


function validation_paris(){
    if(document.getElementById('boutton_connecte')){
        document.getElementById('form_connexion').style.visibility = "visible";
        document.getElementById('form_connexion').style.height = "auto";
		$('html, body').animate({ scrollTop: 0 }, 800);
    }
    else{
        var tabMise=new Array();
        var tabCote=new Array();
        var tabDate= new Array();
        var tabMatch= new Array();
        var tabCodeResult= new Array();
        var tabType=new Array();
        var typeParis=$('p[id="p_parie"]').attr("name");
        var tabSport=new Array();
        var tabEvent=new Array();
        var tabCodeBet = new Array();
        $('input[name="Valeur_mise"]').each(function(){  tabMise.push(Number(($(this).val())).toFixed(2)) ; });
        $('p[name="id_cote"]').each(function(){ tabCote.push($(this).text()); });
        $('p[name="id_match"]').each(function(){ tabMatch.push($(this).text()); });
        $('p[name="id_paris"]').each(function(){ tabCodeResult.push($(this).attr("vainqueur")); });
        $('div[name="paris_matchs"]').each(function(){ tabCodeBet.push($(this).attr("codebet"));tabSport.push($(this).attr("sport"));if($(this).attr("event")){tabEvent.push($(this).attr("event"))}else{tabEvent.push('NULL')};if($(this).attr("start-date")){tabDate.push($(this).attr("start-date"))}else{tabDate.push('NULL')}; tabType.push($(this).attr("type")); });
        $.post("valide_paris.php", //Required URL of the page on server
                { // Data Sending With Request To Server
                    Mise:tabMise,
                    Cote:tabCote,
                    Date_match:tabDate,
                    Match: tabMatch,
                    CodeResult: tabCodeResult,
                    Type : typeParis,
                    TypeParis : tabType,
                    Sport: tabSport,
                    Event : tabEvent,
                    CodeBet :tabCodeBet
                },
                function(response,status){ // Required Callback Function
                    document.getElementById('affichage_paris_conteneur').remove();
                    document.getElementById('reponse_paris').innerHTML=''+response+'';
                    document.getElementById('myModal').style.display = "block";
            });
    }
}


function affichage_actualites(Sport){
    $.post("Actu.php", //Required URL of the page on server
        { // Data Sending With Request To Server
            mode:Sport
        },
        function(response,status){
            document.getElementById('affichage_actu').innerHTML=''+response+'';
        }
    );
}

function affichage_partenaire(Sport){
    $.post("Part.php", //Required URL of the page on server
        { // Data Sending With Request To Server
            mode:Sport
        },
        function(response,status){
            document.getElementById('affichage_partenaire').innerHTML=''+response+'';
        }
    );
}
