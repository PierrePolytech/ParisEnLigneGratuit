//DONUT
d3.select("input[value=\"Paris\"]").property("checked", true);
var mode = "Paris";
$.post("Stat.php", 
{ 
    Mode:mode
},
function(response,status){ 
    var stat = JSON.parse(response);
    datasetMise  = JSON.parse(JSON.stringify(stat.Cote_Moy));
    datasetNombre = JSON.parse(JSON.stringify(stat.Nombre));
    datasetMiseMoy = JSON.parse(JSON.stringify(stat.Mise_Moy));
    datasetAttente= JSON.parse(JSON.stringify(stat.Attente));
    datasetInfos= JSON.parse(JSON.stringify(stat.Infos));
if((datasetAttente[0].value==0)&&(datasetNombre[0].value+datasetNombre[1].value==0)){
		$("#form_radio").css("display","none");
	    }else{
		$("#form_radio").css("display","block");
	    }
    if(datasetAttente[0].value==0){ 
	$("#div_Attente").css("display","none");
}else{
	 $("#corps_attente").append('<table class="table"><tbody><tr><td name="titre">Nombres de Paris en attente</td><td name="infos">'+datasetAttente[0].value+'</td></tr><tr><td name="titre">Mises totales</td><td name="infos">'+datasetAttente[1].value+'<i class="fa fa-fw fa-eur"></i></td><tr><td name="titre">Gains potentiels</td><td name="infos">'+datasetAttente[2].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
}       
    
    if(datasetNombre[0].value+datasetNombre[1].value==0){
  $('.widget').css("display","none");
  $('.widget2').css("display","none");
$("#corps_stats").css("display","none");
}else{
$("#corps_stats").append('<table class="table"><tbody><tr><td name="titre">Mises totales Paris (gagnés ou perdus)</td><td name="infos">'+datasetInfos[0].value+'<i class="fa fa-fw fa-eur"></i></td></tr><tr><td name="titre">Gains (mises incluses)</td><td name="infos">'+datasetInfos[1].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
    change(datasetNombre);
    bar(datasetNombre,1);
    bar(datasetMise,2);
    bar(datasetMiseMoy,3);
}
});

var svg = d3.select("#chart")
.append("svg")
.append("g")

svg.append("g")
    .attr("class", "slices");
svg.append("g")
    .attr("class", "labelName");
svg.append("g")
    .attr("class", "labelValue");
svg.append("g")
    .attr("class", "lines");


var width = 400,
    height = 200,
    radius = Math.min(width, height) / 2;

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) {
        return d.value;
    });

var arc = d3.svg.arc()
    .outerRadius(radius * 0.8)
    .innerRadius(radius * 0.4);

var outerArc = d3.svg.arc()
    .innerRadius(radius * 0.9)
    .outerRadius(radius * 0.9);
var div = d3.select("body").append("div").attr("class", "toolTip");

svg.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
d3.select("input[value=\"Paris\"]").on("change", selectDataset);
d3.select("input[value=\"ParisS\"]").on("change", selectDataset);
d3.select("input[value=\"ParisC\"]").on("change", selectDataset);
//DIAGRAMME BARRE
var margin = {top: 20, right: 0, bottom: 70, left: 0},
width2 = 100 ,
height2 = 300 - margin.top - margin.bottom;


// set the ranges
var x2 = d3.scale.ordinal().rangeRoundBands([0, width2], .05);

var y2 = d3.scale.linear().range([height2, 0]);

// define the axis
var xAxis2 = d3.svg.axis()
    .scale(x2)
    .orient("bottom")


var yAxis2 = d3.svg.axis()
    .scale(y2)
    .orient("left")
    .ticks(10);

var tooltip = d3.select("body")
    .append("div")
    .style("position", "absolute")
    .style("z-index", "10")
    .style("visibility", "hidden")
    .style("background","white")
    .style("border","1px solid black")
    .style("padding","0.5%")
    .style("border-radius","7px")
    .text("a simple tooltip");
// add the SVG element
var svg2 = d3.select("#chart_nb").append("svg")
    .attr("width", width2 + margin.left + margin.right)
    .attr("height", height2 + margin.top + margin.bottom);
var svg3 = d3.select("#chart_mise").append("svg")
    .attr("width", width2 + margin.left + margin.right)
    .attr("height", height2 + margin.top + margin.bottom);

var svg4 = d3.select("#chart_miseM").append("svg")
    .attr("width", width2 + margin.left + margin.right)
    .attr("height", height2 + margin.top + margin.bottom);

document.getElementById("chart_bar1").onclick = function() {NbParis()};
document.getElementById("chart_bar2").onclick = function() {MisesTot()};
document.getElementById("chart_bar3").onclick = function() {MiseMoy()};

function NbParis() {
    change(datasetNombre);
    document.getElementById("title_donut").innerHTML=document.getElementById("title_nb").innerHTML;
}
function MisesTot() {
    change(datasetMise);
    document.getElementById("title_donut").innerHTML=document.getElementById("title_mise").innerHTML;
}
function MiseMoy() {
    change2(datasetMiseMoy);
    document.getElementById("title_donut").innerHTML=document.getElementById("title_miseM").innerHTML;
}
 
function selectDataset()
{
    $('.bar').remove();
    var value = this.value;
    $.post("Stat.php", 
    { 
        Mode:value
    },
    function(response,status){ 
        var stat = JSON.parse(response);
        datasetMise  = JSON.parse(JSON.stringify(stat.Cote_Moy));
        datasetNombre = JSON.parse(JSON.stringify(stat.Nombre));
        datasetMiseMoy = JSON.parse(JSON.stringify(stat.Mise_Moy));
        datasetAttente= JSON.parse(JSON.stringify(stat.Attente));
        datasetInfos= JSON.parse(JSON.stringify(stat.Infos));
        document.getElementById("corps_attente").innerHTML="";
        document.getElementById("corps_stats").innerHTML="";
        
        if(value=="Paris"){
	    if(datasetNombre[0].value+datasetNombre[1].value==0){
		  $('.widget').css("display","none");
		  $('.widget2').css("display","none");
		  $("#corps_stats").css("display","none");
	    }else{
		$('.widget').css("display","inline-block");
		$('.widget2').css("display","inline-block");
		$("#corps_stats").css("display","inline-block");
		change(datasetNombre);
		bar(datasetNombre,1);
		bar(datasetMise,2);
		bar(datasetMiseMoy,3);
		document.getElementById("title_donut").innerHTML="Nombres Paris";
            	document.getElementById("title_nb").innerHTML="Nombres Paris";
            	document.getElementById("title_mise").innerHTML="Côte moyenne Paris";
            	document.getElementById("title_miseM").innerHTML="Mise moyenne Paris";
		$("#corps_stats").append('<table class="table"><tbody><tr><td name="titre">Mises totales Paris (gagnés ou perdus)</td><td name="infos">'+datasetInfos[0].value+'<i class="fa fa-fw fa-eur"></i></td></tr><tr><td name="titre">Gains (mises incluses)</td><td name="infos">'+datasetInfos[1].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
	    }
	    if(datasetAttente[0].value==0){ 
		$("#div_Attente").css("display","none");
	    }else{
		$("#div_Attente").css("display","block");
		document.getElementById("title_attente").innerHTML="Paris en attente";
            	$("#corps_attente").append('<table class="table"><tbody><tr><td name="titre">Nombres de Paris en attente</td><td name="infos">'+datasetAttente[0].value+'</td></tr><tr><td name="titre">Mises totales</td><td name="infos">'+datasetAttente[1].value+'<i class="fa fa-fw fa-eur"></i></td><tr><td name="titre">Gains potentiels</td><td name="infos">'+datasetAttente[2].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
	    }
            
            
            
        }
        else if(value=="ParisS"){
	    if(datasetNombre[0].value+datasetNombre[1].value==0){
		  $('.widget').css("display","none");
		  $('.widget2').css("display","none");
		  $("#corps_stats").css("display","none");
	    }else{
		$('.widget').css("display","inline-block");
		$('.widget2').css("display","inline-block");
		$("#corps_stats").css("display","inline-block");
		change(datasetNombre);
		bar(datasetNombre,1);
		bar(datasetMise,2);
		bar(datasetMiseMoy,3);
		document.getElementById("title_donut").innerHTML="Nombres Paris Simples";
            	document.getElementById("title_nb").innerHTML="Nombres Paris Simples";
            	document.getElementById("title_mise").innerHTML="Côte moyenne Paris Simples";
            	document.getElementById("title_miseM").innerHTML="Mise moyenne Paris Simples";
		$("#corps_stats").append('<table class="table"><tbody><tr><td name="titre">Mises totales Paris simples (gagnés ou perdus)</td><td name="infos">'+datasetInfos[0].value+'<i class="fa fa-fw fa-eur"></i></td></tr><tr><td name="titre">Gains (mises incluses)</td><td name="infos">'+datasetInfos[1].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
	    }
            if(datasetAttente[0].value==0){ 
		$("#div_Attente").css("display","none");
	    }else{
		$("#div_Attente").css("display","block");
            document.getElementById("title_attente").innerHTML="Paris simples en attente";
            $("#corps_attente").append('<table class="table"><tbody><tr><td name="titre">Nombres de Paris simples en attente</td><td name="infos">'+datasetAttente[0].value+'</td></tr><tr><td name="titre">Mises totales</td><td name="infos">'+datasetAttente[1].value+'<i class="fa fa-fw fa-eur"></i></td><tr><td name="titre">Gains potentiels</td><td name="infos">'+datasetAttente[2].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
	    }
	    
            
        }
        else if(value=="ParisC"){
	    if(datasetNombre[0].value+datasetNombre[1].value==0){
		  $('.widget').css("display","none");
		  $('.widget2').css("display","none");
		  $("#corps_stats").css("display","none");
	    }else{
		$('.widget').css("display","inline-block");
		$('.widget2').css("display","inline-block");
		$("#corps_stats").css("display","inline-block");
		change(datasetNombre);
		bar(datasetNombre,1);
		bar(datasetMise,2);
		bar(datasetMiseMoy,3);
            	document.getElementById("title_donut").innerHTML="Nombres Paris Combinés";
            	document.getElementById("title_nb").innerHTML="Nombres Paris Combinés";
            	document.getElementById("title_mise").innerHTML="Côte moyenne Paris Combinés";
            	document.getElementById("title_miseM").innerHTML="Mise moyenne Paris Combinés";
		$("#corps_stats").append('<table class="table"><tbody><tr><td name="titre">Mises totales Paris combinés (gagnés ou perdus)</td><td name="infos">'+datasetInfos[0].value+'<i class="fa fa-fw fa-eur"></i></td></tr><tr><td name="titre">Gains (mises incluses)</td><td name="infos">'+datasetInfos[1].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
	    }
	    if(datasetAttente[0].value==0){ 
		$("#div_Attente").css("display","none");
	    }else{
		$("#div_Attente").css("display","block");
            document.getElementById("title_attente").innerHTML="Paris combinés en attente";
            $("#corps_attente").append('<table class="table"><tbody><tr><td name="titre">Nombres de Paris combinés en attente</td><td name="infos">'+datasetAttente[0].value+'</td></tr><tr><td name="titre">Mises totales</td><td name="infos">'+datasetAttente[1].value+'<i class="fa fa-fw fa-eur"></i></td><tr><td name="titre">Gains potentiels</td><td name="infos">'+datasetAttente[2].value+'<i class="fa fa-fw fa-eur"></i></td></tr></tbody></table>');
 }
            
        }
        
    });
}

function change(data) {
    // ------- PIE SLICES -------
    var slice = svg.select(".slices").selectAll("path.slice")
        .data(pie(data), function(d){ return d.data.label });

    slice.enter()
        .insert("path")
        .style("fill", function(d,i) {
            if(d.data.label=="Gagner"){
                return d3.rgb("#00b300"); 
            }
            else if(d.data.label=="Perdu"){
                return d3.rgb("#b20e10"); 
            }
            else if(d.data.label=="Attente"){
                return d3.rgb("#bbb"); 
            }
        })
        .attr("class", "slice");

    slice
        .transition().duration(1000)
        .attrTween("d", function(d) {
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                return arc(interpolate(t));
            };
        })
    slice
        .on("mousemove", function(d){
            div.style("left", d3.event.pageX+10+"px");
            div.style("top", d3.event.pageY-25+"px");
            div.style("display", "inline-block");
            div.style("background","rgba(0, 0, 0, 0.8)");
            div.style("color","#fff");
            div.html((d.data.label)+" : "+(d.data.value));
        });    
    slice
        .on("mouseout", function(d){
            div.style("display", "none");
        });

    slice.exit()
        .remove();



    // ------- TEXT LABELS -------

    var text = svg.select(".labelName").selectAll("text")
        .data(pie(data), function(d){ return d.data.label });

    text.enter()
        .append("text")
        .attr("dy", ".35em")
        .text(function(d) {
            return (d.data.label+" : "+d.value);
        });

    function midAngle(d){
        return d.startAngle + (d.endAngle - d.startAngle)/2;
    }

    text
        .transition().duration(1000)
        .attrTween("transform", function(d) {
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                var d2 = interpolate(t);
                var pos = outerArc.centroid(d2);
                pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
                return "translate("+ pos +")";
            };
        })
        .styleTween("text-anchor", function(d){
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                var d2 = interpolate(t);
                return midAngle(d2) < Math.PI ? "start":"end";
            };
        })
        .text(function(d) {
            if(d.value>0){
                return (d.data.label+" : "+d.value);
            }            
        });


    text.exit()
        .remove();

    // ------- SLICE TO TEXT POLYLINES -------

    var polyline = svg.select(".lines").selectAll("polyline")
        .data(pie(data), function(d){ if(d.value>0){return d.data.label} });

    polyline.enter()
        .append("polyline");

    polyline.transition().duration(1000)
        .attrTween("points", function(d){
            if(d.value>0){
                this._current = this._current || d;
                var interpolate = d3.interpolate(this._current, d);
                this._current = interpolate(0);
                return function(t) {
                    var d2 = interpolate(t);
                    var pos = outerArc.centroid(d2);
                    pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
                    return [arc.centroid(d2), outerArc.centroid(d2), pos];
                };
            }
            
        });

    polyline.exit()
        .remove();
}

function change2(data) {
    // ------- PIE SLICES -------
    var slice = svg.select(".slices").selectAll("path.slice")
        .data(pie(data), function(d){ return d.data.label });

    slice.enter()
        .insert("path")
        .style("fill", function(d,i) {
            if(d.data.label=="Gagner"){
                return d3.rgb("#00b300"); 
            }
            else if(d.data.label=="Perdu"){
                return d3.rgb("#b20e10"); 
            }
            else if(d.data.label=="Attente"){
                return d3.rgb("#bbb"); 
            }
        })
        .attr("class", "slice");

    slice
        .transition().duration(1000)
        .attrTween("d", function(d) {
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                return arc(interpolate(t));
            };
        })
    slice
        .on("mousemove", function(d){
            div.style("left", d3.event.pageX+10+"px");
            div.style("top", d3.event.pageY-25+"px");
            div.style("display", "inline-block");
            div.style("background","rgba(0, 0, 0, 0.8)");
            div.style("color","#fff");
            div.html((d.data.label)+" : "+(d.data.value)+"€");
        });    
    slice
        .on("mouseout", function(d){
            div.style("display", "none");
        });

    slice.exit()
        .remove();



    // ------- TEXT LABELS -------

    var text = svg.select(".labelName").selectAll("text")
        .data(pie(data), function(d){ return d.data.label });

    text.enter()
        .append("text")
        .attr("dy", ".35em")
        .text(function(d) {
            return (d.data.label+" : "+d.value);
        });

    function midAngle(d){
        return d.startAngle + (d.endAngle - d.startAngle)/2;
    }

    text
        .transition().duration(1000)
        .attrTween("transform", function(d) {
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                var d2 = interpolate(t);
                var pos = outerArc.centroid(d2);
                pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
                return "translate("+ pos +")";
            };
        })
        .styleTween("text-anchor", function(d){
            this._current = this._current || d;
            var interpolate = d3.interpolate(this._current, d);
            this._current = interpolate(0);
            return function(t) {
                var d2 = interpolate(t);
                return midAngle(d2) < Math.PI ? "start":"end";
            };
        })
        .text(function(d) {
            if(d.value>0){
                return (d.data.label+" : "+d.value+"€");
            }            
        });


    text.exit()
        .remove();

    // ------- SLICE TO TEXT POLYLINES -------

    var polyline = svg.select(".lines").selectAll("polyline")
        .data(pie(data), function(d){ if(d.value>0){return d.data.label} });

    polyline.enter()
        .append("polyline");

    polyline.transition().duration(1000)
        .attrTween("points", function(d){
            if(d.value>0){
                this._current = this._current || d;
                var interpolate = d3.interpolate(this._current, d);
                this._current = interpolate(0);
                return function(t) {
                    var d2 = interpolate(t);
                    var pos = outerArc.centroid(d2);
                    pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
                    return [arc.centroid(d2), outerArc.centroid(d2), pos];
                };
            }
            
        });

    polyline.exit()
        .remove();
}

function bar(data,n){
    
    if(n==1){
        // scale the range of the data
        x2.domain(data.map(function(d) { return d.label; }));
        y2.domain([0, d3.max(data, function(d) { return d.value; })]);

        svg2.selectAll("bar")
              .data(data)
            .enter().append("rect")
              .attr("class", "bar")
              .attr("x", function(d) { return x2(d.label); })
              .attr("width", x2.rangeBand())
              .attr("y", function(d) { return y2(d.value); })
              .attr("height", function(d) { return height2 - y2(d.value); })
              .attr("rx","5")
              .style("fill", function(d) { 
                    if(d.label=="Gagner"){
                        return d3.rgb("#00b300"); 
                    }
                    else if(d.label=="Perdu"){
                        return d3.rgb("#b20e10"); 
                    }
                    else if(d.label=="Attente"){
                        return d3.rgb("#bbb"); 
                    }
                })
               .on("mouseover",function(d){return tooltip.style("visibility", "visible").style("background","rgba(0, 0, 0, 0.8)").style("color","#fff").text((d.label)+" : "+((d.value).toFixed(0)));})
               .on("mousemove", function(){return tooltip.style("top",(d3.event.pageY-10)+"px").style("left",(d3.event.pageX+10)+"px");})
                .on("mouseout", function(){return tooltip.style("visibility", "hidden")});
              
    }
    else if(n==2){
        // scale the range of the data
        x2.domain(data.map(function(d) { return d.label; }));
        y2.domain([0, d3.max(data, function(d) { return d.value; })]);

        svg3.selectAll("bar")
              .data(data)
            .enter().append("rect")
              .attr("class", "bar")
              .attr("x", function(d) { return x2(d.label); })
              .attr("width", x2.rangeBand())
              .attr("y", function(d) { return y2(d.value); })
              .attr("height", function(d) { return height2 - y2(d.value); })
              .attr("rx","5")
              .style("fill", function(d) { 
                    if(d.label=="Gagner"){
                        return d3.rgb("#00b300"); 
                    }
                    else if(d.label=="Perdu"){
                        return d3.rgb("#b20e10"); 
                    }
                    else if(d.label=="Attente"){
                        return d3.rgb("#bbb"); 
                    }
                })
              .on("mouseover",function(d){return tooltip.style("visibility", "visible").style("background","rgba(0, 0, 0, 0.8)").style("color","#fff").text((d.label)+" : "+((d.value).toFixed(2)));})
               .on("mousemove", function(){return tooltip.style("top",(d3.event.pageY-10)+"px").style("left",(d3.event.pageX+10)+"px");})
                .on("mouseout", function(){return tooltip.style("visibility", "hidden")});
    }
    else if(n==3){
        // scale the range of the data
        x2.domain(data.map(function(d) { return d.label; }));
        y2.domain([0, d3.max(data, function(d) { return d.value; })]);

        svg4.selectAll("bar")
              .data(data)
            .enter().append("rect")
              .attr("class", "bar")
              .attr("x", function(d) { return x2(d.label); })
              .attr("width", x2.rangeBand())
              .attr("y", function(d) { return y2(d.value); })
              .attr("height", function(d) { return height2 - y2(d.value); })
              .attr("rx","5")
              .style("fill", function(d) { 
                    if(d.label=="Gagner"){
                        return d3.rgb("#00b300"); 
                    }
                    else if(d.label=="Perdu"){
                        return d3.rgb("#b20e10"); 
                    }
                    else if(d.label=="Attente"){
                        return d3.rgb("#bbb"); 
                    }
              })
              .on("mouseover",function(d){return tooltip.style("visibility", "visible").style("background","rgba(0, 0, 0, 0.8)").style("color","#fff").text((d.label)+" : "+((d.value).toFixed(2))+"€");})
               .on("mousemove", function(){return tooltip.style("top",(d3.event.pageY-10)+"px").style("left",(d3.event.pageX+10)+"px");})
                .on("mouseout", function(){return tooltip.style("visibility", "hidden")});
    }
    
}
