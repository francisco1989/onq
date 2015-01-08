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

<style type="text/css">
body {
}

text {
  font: 10px sans-serif;
}

.axis path {
  display: none;
}

.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.group-label {
  font-weight: bold;
  text-anchor: end;
}

form {
  position: absolute;
  right: 10px;
  top: 10px;
}

.slice text {
	font-size: 16pt;
	font-family: Arial;
}
		

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: orange;
}

.bar:hover {
  fill: blue ;
}

.x.axis path {
  display: none;
}

.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 12px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}

/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}		


<!--Below is style for line graph-->
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

</style>
<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<h1>ONQ Group Analytics</h1>

		<h2>Group Members</h2>
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<div class="col-lg-8 col-lg-offset-2" id="Tree">
					</div>				
			</div>
		</div>



		<h2>FPS Game Stats</h2>

		<h4>Times Played</h4>
		<div class="container-fluid col-lg-12">				
			<div class="row">
					<div class="col-lg-4 col-lg-offset-3 well" id="GamePie">
					</div>					
			</div>
		</div>
		
		<h4>Year Progress</h4>
		<div class="container-fluid col-lg-12">		
			<div class="row">
					<div class="col-lg-12 well" id="GameProgress">
					</div>
			</div>
		</div>
		<h4>Monthly Progress</h4>
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<div class="col-lg-12 well" id="GameLine">
					</div>
			</div>
		</div>
		<h4>Last Game Scores</h4>
		<div class="container-fluid col-lg-12">			
			<div class="row">
					<div class="col-lg-12 well" id="GameResults">
					</div>
			</div>
		</div>
		<br/>
		
		
		<h3>Test Stats</h3>

		<h4>Times Taken</h4>
		<div class="container-fluid col-lg-12">				
			<div class="row">
					<div class="col-lg-4 col-lg-offset-3 well" id="TestPie">
					</div>					
			</div>
		</div>
		
		<h4>Year Progress</h4>
		<div class="container-fluid col-lg-12">		
			<div class="row">
					<div class="col-lg-12 well" id="TestProgress">
					</div>
			</div>
		</div>
		<h4>Monthly Progress</h4>
		<div class="container-fluid col-lg-12">	
			<div class="row">
					<div class="col-lg-12 well" id="TestLine">
					</div>
			</div>
		</div>
		<h4>Last Test Scores</h4>
		<div class="container-fluid col-lg-12">			
			<div class="row">
					<div class="col-lg-12 well" id="TestResults">
					</div>
			</div>
		</div>

		
    <script type="text/javascript">
    var gameDataSet = [
      {"legendLabel":"Albert", "magnitude":15}, 
      {"legendLabel":"Beth", "magnitude":45}, 
      {"legendLabel":"Chris", "magnitude":10}, 
      {"legendLabel":"Damien", "magnitude":26}, 
      {"legendLabel":"Ed", "magnitude":23}, 
      {"legendLabel":"Frank", "magnitude":10}, 
      {"legendLabel":"Gus", "magnitude":20},
      {"legendLabel":"Hank", "magnitude":20},
      {"legendLabel":"Ig", "magnitude":30},
      {"legendLabel":"Julie", "magnitude":25}];
	  
	  var gamePieDiv = "#GamePie"
	  drawPie(gameDataSet, gamePieDiv);
	  
	  var gameProgressDiv = "#GameProgress";
	  drawProgress(gameProgressDiv);
	  
	  var gameResultsDiv = "#GameResults";
	  drawResults(gameResultsDiv);
	  
    var testDataSet = [
      {"legendLabel":"Albert", "magnitude":15}, 
      {"legendLabel":"Beth", "magnitude":45}, 
      {"legendLabel":"Chris", "magnitude":10}, 
      {"legendLabel":"Damien", "magnitude":26}, 
      {"legendLabel":"Ed", "magnitude":23}, 
      {"legendLabel":"Frank", "magnitude":10}, 
      {"legendLabel":"Gus", "magnitude":20},
      {"legendLabel":"Hank", "magnitude":20},
      {"legendLabel":"Ig", "magnitude":30},
      {"legendLabel":"Julie", "magnitude":25}];

	  var testPieDiv = "#TestPie"
	  drawPie(testDataSet, testPieDiv);
	  
	  var testProgressDiv = "#TestProgress";
	  drawProgress(testProgressDiv);
	  
	  var testResultsDiv = "#TestResults";
	  drawResults(testResultsDiv);
	  treeDraw();
	  
	var gameLineFile = "/./files/line1Data.tsv";
	var gameLineDiv = "#GameLine";
	var gameLineColor = "blue";	  
	lineGraphDraw(gameLineFile,gameLineDiv, gameLineColor);
	
	var testLineFile = "/./files/line1Data.tsv";
	var testLineDiv = "#TestLine";
	var testLineColor = "blue";	
	lineGraphDraw(testLineFile,testLineDiv, testLineColor);
	
function drawPie(dataSet, div)
{	
    var canvasWidth = 300, //width
      canvasHeight = 300,   //height
      outerRadius = 100,   //radius
      color = d3.scale.category10(); //builtin range of colors


    
    var vis = d3.select(div)
      .append("svg:svg") //create the SVG element inside the <body>
        .data([dataSet]) //associate our data with the document
        .attr("width", canvasWidth) //set the width of the canvas
        .attr("height", canvasHeight) //set the height of the canvas
        .append("svg:g") //make a group to hold our pie chart
          .attr("transform", "translate(" + 1.5*outerRadius + "," + 1.5*outerRadius + ")") // relocate center of pie to 'outerRadius,outerRadius'

    // This will create <path> elements for us using arc data...
    var arc = d3.svg.arc()
      .outerRadius(outerRadius);

    var pie = d3.layout.pie() //this will create arc data for us given a list of values
      .value(function(d) { return d.magnitude; }) // Binding each value to the pie
      .sort( function(d) { return null; } );

    // Select all <g> elements with class slice (there aren't any yet)
    var arcs = vis.selectAll("g.slice")
      // Associate the generated pie data (an array of arcs, each having startAngle,
      // endAngle and value properties) 
      .data(pie)
      // This will create <g> elements for every "extra" data element that should be associated
      // with a selection. The result is creating a <g> for every object in the data array
      .enter()
      // Create a group to hold each slice (we will have a <path> and a <text>
      // element associated with each slice)
      .append("svg:g")
      .attr("class", "slice");    //allow us to style things in the slices (like text)

    arcs.append("svg:path")
      //set the color for each slice to be chosen from the color function defined above
      .attr("fill", function(d, i) { return color(i); } )
      //this creates the actual SVG path using the associated data (pie) with the arc drawing function
      .attr("d", arc);

    // Add a legendLabel to each arc slice...
    arcs.append("svg:text")
      .attr("transform", function(d) { //set the label's origin to the center of the arc
        //we have to make sure to set these before calling arc.centroid
        d.outerRadius = outerRadius + 50; // Set Outer Coordinate
        d.innerRadius = outerRadius + 45; // Set Inner Coordinate
        return "translate(" + arc.centroid(d) + ")";
      })
      .attr("text-anchor", "middle") //center the text on it's origin
      .style("fill", "Purple")
      .style("font", "bold 12px Arial")
      .text(function(d, i) { return dataSet[i].legendLabel; }); //get the label from our original data array

    // Add a magnitude value to the larger arcs, translated to the arc centroid and rotated.
    arcs.filter(function(d) { return d.endAngle - d.startAngle > .2; }).append("svg:text")
      .attr("dy", ".35em")
      .attr("text-anchor", "middle")
      //.attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")"; })
      .attr("transform", function(d) { //set the label's origin to the center of the arc
        //we have to make sure to set these before calling arc.centroid
        d.outerRadius = outerRadius; // Set Outer Coordinate
        d.innerRadius = outerRadius/2; // Set Inner Coordinate
        return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")";
      })
      .style("fill", "White")
      .style("font", "bold 12px Arial")
      .text(function(d) { return d.data.magnitude; });

    // Computes the angle of an arc, converting from radians to degrees.
    function angle(d) {
      var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
      return a > 90 ? a - 180 : a;
    }
}

function drawProgress(gameProgressDiv)
{
	var parseDate = d3.time.format("%Y-%m").parse,
		formatYear = d3.format("02d"),
		formatDate = function(d) { return "Period " + ((d.getMonth() / 3 | 0) + 1) + " 20" + formatYear(d.getFullYear() % 100); };

	var margin = {top: 10, right: 20, bottom: 20, left: 60},
		width = 960 - margin.left - margin.right,
		height = 300 - margin.top - margin.bottom;

	var y0 = d3.scale.ordinal()
		.rangeRoundBands([height, 0], .2);

	var y1 = d3.scale.linear();

	var x = d3.scale.ordinal()
		.rangeRoundBands([0, width], .1, 0);

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")
		.tickFormat(formatDate);

	var nest = d3.nest()
		.key(function(d) { return d.group; });

	var stack = d3.layout.stack()
		.values(function(d) { return d.values; })
		.x(function(d) { return d.date; })
		.y(function(d) { return d.value; })
		.out(function(d, y0) { d.valueOffset = y0; });

	var color = d3.scale.category10();

	var svg = d3.select(gameProgressDiv).append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.tsv("/./files/stackedData1.tsv", function(data) {

	  data.forEach(function(d) {
		d.date = parseDate(d.date);
		d.value = +d.value;
	  });

	  var dataByGroup = nest.entries(data);

	  stack(dataByGroup);
	  x.domain(dataByGroup[0].values.map(function(d) { return d.date; }));
	  y0.domain(dataByGroup.map(function(d) { return d.key; }));
	  y1.domain([0, d3.max(data, function(d) { return d.value; })]).range([y0.rangeBand(), 0]);

	  var group = svg.selectAll(".group")
		  .data(dataByGroup)
		.enter().append("g")
		  .attr("class", "group")
		  .attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });

	  group.append("text")
		  .attr("class", "group-label")
		  .attr("x", -6)
		  .attr("y", function(d) { return y1(d.values[0].value / 2); })
		  .attr("dy", ".35em")
		  .text(function(d) { return "" + d.key; });

	  group.selectAll("rect")
		  .data(function(d) { return d.values; })
		.enter().append("rect")
		  .style("fill", function(d) { return color(d.group); })
		  .attr("x", function(d) { return x(d.date); })
		  .attr("y", function(d) { return y1(d.value); })
		  .attr("width", x.rangeBand())
		  .attr("height", function(d) { return y0.rangeBand() - y1(d.value); });

	  group.filter(function(d, i) { return !i; }).append("g")
		  .attr("class", "x axis")
		  .attr("transform", "translate(0," + y0.rangeBand() + ")")
		  .call(xAxis);

	  d3.selectAll("input").on("change", change);

	  var timeout = setTimeout(function() {
		d3.select("input[value=\"stacked\"]").property("checked", true).each(change);
	  }, 90000);

	  function change() {
		clearTimeout(timeout);
		if (this.value === "multiples") transitionMultiples();
		else transitionStacked();
	  }

	  function transitionMultiples() {
		var t = svg.transition().duration(750),
			g = t.selectAll(".group").attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });
		g.selectAll("rect").attr("y", function(d) { return y1(d.value); });
		g.select(".group-label").attr("y", function(d) { return y1(d.values[0].value / 2); })
	  }

	  function transitionStacked() {
		var t = svg.transition().duration(750),
			g = t.selectAll(".group").attr("transform", "translate(0," + y0(y0.domain()[0]) + ")");
		g.selectAll("rect").attr("y", function(d) { return y1(d.value + d.valueOffset); });
		g.select(".group-label").attr("y", function(d) { return y1(d.values[0].value / 2 + d.values[0].valueOffset); })
	  }
	});
}


function drawResults(div)
{
	var margin = {top: 40, right: 20, bottom: 30, left: 40},
		width = 1000 - margin.left - margin.right,
		height = 500 - margin.top - margin.bottom;

	var formatPercent = d3.format(".0%");

	var x = d3.scale.ordinal()
		.rangeRoundBands([0, width], .1);

	var y = d3.scale.linear()
		.range([height, 0]);

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom");

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.tickFormat(formatPercent);

	var tip = d3.tip()
	  .attr('class', 'd3-tip')
	  .offset([-10, 0])
	  .html(function(d) {
		return "<strong>Score:</strong> <span style='color:red'>" + d.frequency + "</span>";
	  })

	var svg = d3.select(div).append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	svg.call(tip);

	d3.tsv("/./files/resultsData1.tsv", function(data) {
	  x.domain(data.map(function(d) { return d.letter; }));
	  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

	  svg.append("g")
		  .attr("class", "x axis")
		  .attr("transform", "translate(0," + height + ")")
		  .call(xAxis);

	  svg.append("g")
		  .attr("class", "y axis")
		  .call(yAxis)
		.append("text")
		  .attr("transform", "rotate(-90)")
		  .attr("y", 6)
		  .attr("dy", ".71em")
		  .style("text-anchor", "end")
		  .text("Percent");

	  svg.selectAll(".bar")
		  .data(data)
		.enter().append("rect")
		  .attr("class", "bar")
		  .attr("x", function(d) { return x(d.letter); })
		  .attr("width", x.rangeBand())
		  .attr("y", function(d) { return y(d.frequency); })
		  .attr("height", function(d) { return height - y(d.frequency); })
		  .on('mouseover', tip.show)
		  .on('mouseout', tip.hide)

	});

	function type(d) {
	  d.frequency = +d.frequency;
	  return d;
	}
}


function treeDraw()
{
	var margin = {top: 20, right: 10, bottom: 20, left: 10},
		width = 960 - margin.right - margin.left,
		height = 500 - margin.top - margin.bottom;
		
	var i = 0,
		duration = 750,
		root;

	var tree = d3.layout.tree()
		.size([height, width]);

	var diagonal = d3.svg.diagonal()
		.projection(function(d) { return [d.x, d.y]; });

	var svg = d3.select("#Tree").append("svg")
		.attr("width", width)
		.attr("height", height-100)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.json("/./files/sampleGroup.json", function(flare) {
	  root = flare;
	  root.x0 = 0;
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

	d3.select(self.frameElement).style("height", "200px");

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
		  .attr("transform", function(d) { return "translate(" + source.x0 + "," + source.y0 + ")"; })
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
		  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

	  nodeUpdate.select("circle")
		  .attr("r", 4.5)
		  .style("fill", function(d) { return d._children ? "orange" : "blue"; });

	  nodeUpdate.select("text")
		  .style("fill-opacity", 1);

	  // Transition exiting nodes to the parent's new position.
	  var nodeExit = node.exit().transition()
		  .duration(duration)
		  .attr("transform", function(d) { return "translate(" + source.x + "," + source.y + ")"; })
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
		  .style("fill", "none")
		  .style("stroke", "orange")
		  .style("stroke-width", 2)
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
			.style("stroke", color)
			.style("fill", "none");
			

		svg.append("g")         // Add the X Axis
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis);

		svg.append("g")         // Add the Y Axis
			.attr("class", "y axis")
			.call(yAxis);
	});
}


</script>
</body>
</html>