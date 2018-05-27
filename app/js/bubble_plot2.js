var oReq = new XMLHttpRequest();
var project_data = "";
oReq.onload = function() {
	import_data = JSON.parse(this.responseText);
	project_data = JSON.parse(this.responseText);
};
oReq.open("get", "get_data_bubble_plot.php", false);
oReq.send();

//var js_array = 
//[['projet.php?project=des-vetements-equitables-et-abordables',"5","10"],['projet.php?project=integration-sociale-des-itinerants',"10","110"],['projet.php?project=match-de-soccer-hebdomadaires-au-parc-lafontaine-',"32","65"],['projet.php?project=nettoyer-le-parc-mont-royal-de-ses-dechets',"1","5"],['projet.php?project=un-vol-direct-montreal-porto-rico',"8","40"],['projet.php?project=une-assurance-dentaire-abordable-a-montreal',"24","32"]];
var w = 700,
    h = 400,
    nodes = [],
    node;

var vis = d3.select("#graph").append("svg")
    .attr("width", w)
    .attr("height", h);
d3.select("svg").append("defs")

var force = d3.layout.force()
	.gravity(0.1)
	.charge(-500)
	.nodes(nodes)
	.links([])
	.size([w, h]);

force.on("tick", function(e) {
  vis.selectAll("path")
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
  var q = d3.geom.quadtree(nodes),
      i = 0,
      n = nodes.length;

  while (++i < n) q.visit(collide(nodes[i]));

  vis.selectAll("circle")
      .attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; });
});
var node_max_seuil = 0;
for (i = 0; i < project_data.length; i++) {
	if (project_data[i]["seuil_unit_engagement"] > node_max_seuil){
		node_max_seuil = project_data[i]["seuil_unit_engagement"];
	}
}
var max_node_size = 8000;
var color = d3.scale.category20();
for (i = 0; i < project_data.length; i++) {
	nodes.push({
		type: d3.svg.symbol().type('circle'),
		size: max_node_size * project_data[i]["seuil_unit_engagement"]/node_max_seuil,
		title:project_data[i]["titre_projet"],
		url:"projet.php?project=" + project_data[i]["url_projet_name"],
		ref:i
		});
		//d3.select("defs")
		//.append("RadialGradient")
		//.attr("id","radial" + i)
		//.append("stop").attr("offset", "0%").attr("stop-color", function(d,i){return color(i);});
		//d3.select("#radial" + i).append("stop").attr("offset", "100%").attr("stop-color", "black");
}
function collide(node) {
  var r = node.radius + Math.sqrt(max_node_size),
      nx1 = node.x - r,
      nx2 = node.x + r,
      ny1 = node.y - r,
      ny2 = node.y + r;
  return function(quad, x1, y1, x2, y2) {
    if (quad.point && (quad.point !== node)) {
      var x = node.x - quad.point.x,
          y = node.y - quad.point.y,
          l = Math.sqrt(x * x + y * y),
          r = node.radius + quad.point.radius;
      if (l < r) {
        l = (l - r) / l * .5;
        node.x -= x *= l;
        node.y -= y *= l;
        quad.point.x += x;
        quad.point.y += y;
      }
    }
    return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
  };
}
force.start();

var dots = vis.selectAll("path")
.data(nodes)
.enter().append("path")
.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
.attr("d", d3.svg.symbol()
	.size(function(d) { return d.size; })
	.type(function(d) { return d.type; }))
//.style("fill", function(d,i){return "url(#radial" + d.ref + ")";})
.style("fill", function(d,i){return color(i);})
.style("stroke", "white")
.style("stroke-width", "1.5px")
.call(force.drag);
var tltips = d3.select("body").select("svg").append("g").append("g").attr("class", "tooltip").append("text").html("test");
var tooltip = d3.selectAll(".tooltip");
var SVGtooltip = d3.select("g.tooltip");
vis.selectAll("path").data(nodes).on('click' , function(d){ console.log(d.title); }).on("mouseover", function (d) {
	
	tooltip.select("text").html(d.title);
	return tooltip.style("visibility", "visible");
})
	.on("mousemove", function () {
		var mouseCoords = d3.mouse(
			SVGtooltip[0][0].parentElement);
		SVGtooltip
			.attr("transform", "translate(" + (mouseCoords[0]+5) + "," + (mouseCoords[1]+5) + ")");
	})
	.on("mouseout", function () {
		return tooltip.style("visibility", "hidden");})
	.on('click' , function(d){ window.location = d.url; });
