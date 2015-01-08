<?php //This lists profile -> deck -> list of cards?>
<!DOCTYPE html>
<html>
	<head>
	<div class="loginform">
			<?php 
				echo "Welcome ";
				echo AuthComponent::user('userName');
				echo "!";
				echo $this->Session->flash('auth'); 
				echo $this->Form->create('Logout'); 
			?>
				<div style="width: 100%; display: table;">
					<div style="display: table-row">
						<div style="width: 90px; display: table-cell;">
							<?php 
								echo $this->Html->link("LOGOUT", array('controller' => 'Qprofiles','action'=> 'logout'), array( 'class' => 'signbutton'))
							?>
						</div>
					</div>
				</div>
		</div>
		<?php echo $this->Form->end(); ?>
	<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<style>
body { }

path { 
    stroke: orange;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 2;
    shape-rendering: crispEdges;
}

svg {
  font: 10px sans-serif;
}

.y.axis path {
  display: none;
}

.y.axis line {
  stroke: #fff;
  stroke-opacity: .2;
  shape-rendering: crispEdges;
}

.y.axis .zero line {
  stroke: #000;
  stroke-opacity: 1;
}

.title {
  font: 300 78px Helvetica Neue;
  fill: #666;
}

.birthyear,
.age {
  text-anchor: middle;
}

.birthyear {
  fill: #fff;
}

rect {
  fill-opacity: .6;
  fill: pink;
}

rect:first-child {
  fill: blue;
}

.node {
  cursor: pointer;
}

.node circle {
  fill: blue;
  stroke: blue;
  stroke-width: 1.5px;
}

.node text {
  font: 10px sans-serif;
}

.link {
  fill: none;
  stroke: orange;
  stroke-width: 1.5px;
}


</style>
<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
<body>

<h3>ONQ Admin Analytics Dash</h3>
		<div class="container-fluid col-lg-12">	
			<div class="row">
			<h4>Population</h4>
					<div class="col-lg-12 well" id="Population">
					</div>
			</div>
		</div>
		<br/>
		
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<h4>Monthly Registrations</h4>
					<div class="col-lg-12 well" id="Registrations">
					</div>
			</div>
		</div>
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<h4>Monthly Usage</h4>
					<div class="col-lg-12 well" id="Usage">
					</div>
			</div>
		</div>
		
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<h4>Group Structure</h4>
					<div class="col-lg-12 well" id="Tree">
					</div>
			</div>
		</div>		
		
<script>
var fileName1 = "/./files/line1Data.tsv";
var div1 = "#Registrations";
var color1 = "blue";

var fileName2 = "/./files/line2Data.tsv";
var div2 = "#Usage";
var color2 = "orange";


drawPopulation();
lineGraphDraw(fileName1,div1, color1);
lineGraphDraw(fileName2,div2, color2);
treeDraw();


function drawPopulation()
{
	var margin = {top: 20, right: 40, bottom: 30, left: 40},
		width = 960 - margin.left - margin.right,
		height = 500 - margin.top - margin.bottom,
		barWidth = Math.floor(width / 19) - 1;

	var x = d3.scale.linear()
		.range([barWidth / 2, width - barWidth / 2]);

	var y = d3.scale.linear()
		.range([height, 0]);

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.tickSize(width - 10)
		.tickFormat(function(d) { return Math.round(d / 1) + ""; });

	// An SVG element with a bottom-right origin.
	var svg = d3.select("#Population").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	// A sliding container to hold the bars by birthyear.
	var birthyears = svg.append("g")
		.attr("class", "birthyears");

	// A label for the current year.
	var title = svg.append("text")
		.attr("class", "title")
		.attr("dy", ".71em")
		.text("");

	d3.csv("/./files/populationData.csv", function(data) {

	  // Convert strings to numbers.
	  data.forEach(function(d) {
		d.people = +d.people;
		d.year = +d.year;
		d.age = +d.age;
	  });

	  // Compute the extent of the data set in age and years.
	  var age1 = d3.max(data, function(d) { return d.age; }),
		  year0 = d3.min(data, function(d) { return d.year; }),
		  year1 = d3.max(data, function(d) { return d.year; }),
		  year = year1;

	  // Update the scale domains.
	  x.domain([year1 - age1, year1]);
	  y.domain([0, d3.max(data, function(d) { return d.people; })]);

	  // Produce a map from year and birthyear to [male, female].
	  data = d3.nest()
		  .key(function(d) { return d.year; })
		  .key(function(d) { return d.year - d.age; })
		  .rollup(function(v) { return v.map(function(d) { return d.people; }); })
		  .map(data);

	  // Add an axis to show the population values.
	  svg.append("g")
		  .attr("class", "y axis")
		  .attr("transform", "translate(" + width + ",0)")
		  .call(yAxis)
		.selectAll("g")
		.filter(function(value) { return !value; })
		  .classed("zero", true);

	  // Add labeled rects for each birthyear (so that no enter or exit is required).
	  var birthyear = birthyears.selectAll(".birthyear")
		  .data(d3.range(year0 - age1, year1 + 1, 1))
		.enter().append("g")
		  .attr("class", "birthyear")
		  .attr("transform", function(birthyear) { return "translate(" + x(birthyear) + ",0)"; });

	  birthyear.selectAll("rect")
		  .data(function(birthyear) { return data[year][birthyear] || [0, 0]; })
		.enter().append("rect")
		  .attr("x", -barWidth / 4)
		  .attr("width", barWidth/2)
		  .attr("y", y)
		  .attr("height", function(value) { return height - y(value); });

	  // Add labels to show birthyear.
	  birthyear.append("text")
		  .attr("y", height - 4)
		  .text(function(birthyear) { return birthyear; });

	  // Add labels to show age (separate; not animated).
	  svg.selectAll(".age")
		  .data(d3.range(0, age1 + 1, 1))
		.enter().append("text")
		  .attr("class", "age")
		  .attr("x", function(age) { return x(year - age); })
		  .attr("y", height + 4)
		  .attr("dy", ".71em")
		  .text(function(age) { return age; });
		  
		svg.append("text")
			.attr("text-anchor", "start")
			.attr("x", width)
			.attr("y", height + 25)
			.text("Age");
			
		svg.append("text")
		.attr("text-anchor", "end")
		.attr("y", -35)
		.attr("x", -30)
		.attr("dy", ".75em")
		.attr("transform", "rotate(-90)")
		.text("# of People");

	  // Allow the arrow keys to change the displayed year.
	  window.focus();
	  d3.select(window).on("keydown", function() {
		switch (d3.event.keyCode) {
		  case 37: year = Math.max(year0, year - 10); break;
		  case 39: year = Math.min(year1, year + 10); break;
		}
		update();
	  });

	  function update() {
		if (!(year in data)) return;
		title.text(year);

		birthyears.transition()
			.duration(750)
			.attr("transform", "translate(" + (x(year1) - x(year)) + ",0)");

		birthyear.selectAll("rect")
			.data(function(birthyear) { return data[year][birthyear] || [0, 0]; })
		  .transition()
			.duration(750)
			.attr("y", y)
			.attr("height", function(value) { return height - y(value); });
	  }
	});
}


function lineGraphDraw(fileName, theDiv, color)
{
	var margin = {top: 30, right: 20, bottom: 30, left: 50},
		width = 800 - margin.left - margin.right,
		height = 270 - margin.top - margin.bottom;

	var parseDate = d3.time.format("%d-%b-%y").parse;

	var x = d3.time.scale().range([0, width]);
	var y = d3.scale.linear().range([height, 0]);

	var xAxis = d3.svg.axis().scale(x)
		.orient("bottom").ticks(10);

	var yAxis = d3.svg.axis().scale(y)
		.orient("left").ticks(12);

	var valueline = d3.svg.line()
		.x(function(d) { return x(d.date); })
		.y(function(d) { return y(d.close); });
		
	var svg = d3.select(theDiv)
		.append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		.append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	// Get the data
	d3.tsv(fileName, function(data) {
		data.forEach(function(d) {
			d.date = parseDate(d.date);
			d.close = +d.close;
		});

		// Scale the range of the data
		x.domain(d3.extent(data, function(d) { return d.date; }));
		y.domain([0, d3.max(data, function(d) { return d.close; })]);

		svg.append("path")      // Add the valueline path.
			.attr("d", valueline(data))
			.style("stroke", color);

		svg.append("g")         // Add the X Axis
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis);

		svg.append("g")         // Add the Y Axis
			.attr("class", "y axis")
			.call(yAxis);
	});
}

function treeDraw()
{
	var margin = {top: 20, right: 120, bottom: 20, left: 120},
		width = 960 - margin.right - margin.left,
		height = 800 - margin.top - margin.bottom;
		
	var i = 0,
		duration = 750,
		root;

	var tree = d3.layout.tree()
		.size([height, width]);

	var diagonal = d3.svg.diagonal()
		.projection(function(d) { return [d.y, d.x]; });

	var svg = d3.select("#Tree").append("svg")
		.attr("width", width + margin.right + margin.left)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.json("/./files/flare.json", function(flare) {
	  root = flare;
	  root.x0 = height / 2;
	  root.y0 = 0;

	  function collapse(d) {
		if (d.children) {
		  d._children = d.children;
		  d._children.forEach(collapse);
		  d.children = null;
		}
	  }

	  root.children.forEach(collapse);
	  update(root);
	});

	d3.select(self.frameElement).style("height", "800px");

	function update(source) {

	  // Compute the new tree layout.
	  var nodes = tree.nodes(root).reverse(),
		  links = tree.links(nodes);

	  // Normalize for fixed-depth.
	  nodes.forEach(function(d) { d.y = d.depth * 180; });

	  // Update the nodes…
	  var node = svg.selectAll("g.node")
		  .data(nodes, function(d) { return d.id || (d.id = ++i); });

	  // Enter any new nodes at the parent's previous position.
	  var nodeEnter = node.enter().append("g")
		  .attr("class", "node")
		  .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
		  .on("click", click);

	  nodeEnter.append("circle")
		  .attr("r", 1e-6)
		  .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

	  nodeEnter.append("text")
		  .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
		  .attr("dy", ".35em")
		  .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
		  .text(function(d) { return d.name /*+ d.size*/; })
		  .style("fill-opacity", 1e-6);

	  // Transition nodes to their new position.
	  var nodeUpdate = node.transition()
		  .duration(duration)
		  .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

	  nodeUpdate.select("circle")
		  .attr("r", 4.5)
		  .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

	  nodeUpdate.select("text")
		  .style("fill-opacity", 1);

	  // Transition exiting nodes to the parent's new position.
	  var nodeExit = node.exit().transition()
		  .duration(duration)
		  .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
		  .remove();

	  nodeExit.select("circle")
		  .attr("r", 1e-6);

	  nodeExit.select("text")
		  .style("fill-opacity", 1e-6);

	  // Update the links…
	  var link = svg.selectAll("path.link")
		  .data(links, function(d) { return d.target.id; });

	  // Enter any new links at the parent's previous position.
	  link.enter().insert("path", "g")
		  .attr("class", "link")
		  .attr("d", function(d) {
			var o = {x: source.x0, y: source.y0};
			return diagonal({source: o, target: o});
		  });

	  // Transition links to their new position.
	  link.transition()
		  .duration(duration)
		  .attr("d", diagonal);

	  // Transition exiting nodes to the parent's new position.
	  link.exit().transition()
		  .duration(duration)
		  .attr("d", function(d) {
			var o = {x: source.x, y: source.y};
			return diagonal({source: o, target: o});
		  })
		  .remove();

	  // Stash the old positions for transition.
	  nodes.forEach(function(d) {
		d.x0 = d.x;
		d.y0 = d.y;
	  });
	}

	// Toggle children on click.
	function click(d) {
	  if (d.children) {
		d._children = d.children;
		d.children = null;
	  } else {
		d.children = d._children;
		d._children = null;
	  }
	  update(d);
	}

}



</script>
