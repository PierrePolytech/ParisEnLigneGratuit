 
function menu(){
    
      $(document).ready(  
       function()
       {
         $.ajax({
                  type: "GET",
                  url: "XML/odds_fr.xml",
                  dataType: "xml",
                  success: function(xml) 
                           {
                            var competition='<?php if($type) echo $type; ?>';
                            var sport='<?php if($sport) echo $sport; ?>';
                            $(xml).find('sport').each(
                              function()
                              {
                                var name_sport=$(this).attr('name');
                                $('<li> <a href="javascript:;" data-toggle="collapse" data-target="#'+name_sport+'">'+name_sport+' <i class="fa fa-fw fa-caret-down"></i></a> <ul id="'+name_sport+'" class="collapse">').appendTo('#matches');
                                $(this).find('event').each(
                                  function()
                                  {
                                    var name_event=$(this).attr('name');
                                    $('<li><a href="menu.php?sport='+name_sport+'&type='+name_event+'">'+name_event+'</a></li>').appendTo('#'+name_sport+'');
                                    $('<p>'+name_sport+':'+sport+' / '+name_event+':'+competition+'</p>').appendTo('#affichage_matchs');
                                  });
                              });
                            }
              });
        }
      );
}
