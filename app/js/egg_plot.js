var oReq = new XMLHttpRequest();
var project_data = "";
oReq.onload = function() {
	import_data = JSON.parse(this.responseText);
	project_data = JSON.parse(this.responseText);

var w = 250,
    h = 250;

var vis = d3.select("#oeuf").append("svg")
    .attr("width", w)
    .attr("height", h);
d3.select("svg").append("defs")

var percent_of_engagement = project_data[0]["nb_engage"] / project_data[0]["seuil_unit_engagement"];
if (percent_of_engagement >= 1){
	var radius = Math.sqrt(124 * 124 * 1);
}
else {
	var radius = Math.sqrt(124 * 124 *percent_of_engagement);
}
// var radius = Math.sqrt(124 * 124 * project_data[0]["nb_engage"] / project_data[0]["seuil_unit_engagement"]);

d3.select("svg").append("circle")
	.attr("class", "egg_border")
	.attr("cx", 125)
	.attr("cy", 125)
	.attr("r", 124)
	.style("stroke-dasharray", ("10,3"))
	// .style("stroke", "black")
	.style("fill","none");
d3.select("svg").append("circle")
	.attr("class", "egg")
	.attr("cx", 125)
	.attr("cy", 125)
	.attr("r", radius)
	// .style("fill","yellow")
	.on("mouseover", function (d) {
	return tooltip.style("visibility", "visible");
	})
	.on("mousemove", function () {
	var mouseCoords = d3.mouse(
	SVGtooltip[0][0].parentElement);
	SVGtooltip
	.attr("transform", "translate(" + (mouseCoords[0]+5) + "," + (mouseCoords[1]+5) + ")");
	})
	.on("mouseout", function () {
	return tooltip.style("visibility", "hidden");});

var tltips = d3.select("body").select("svg").append("g").append("g").attr("class", "tooltip").append("text").html(project_data[0]["nb_engage"].toString() + "/" + project_data[0]["seuil_unit_engagement"].toString());
var tooltip = d3.selectAll(".tooltip");
var SVGtooltip = d3.select("g.tooltip");
};
oReq.open("get", "get_project_egg_plot_data.php?project="+project_url, true);
oReq.send();
