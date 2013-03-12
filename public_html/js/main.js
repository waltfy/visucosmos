$().ready(function() {  
	
	$('#add_attr').click(function() {  
		return !$('#all_attr option:selected').remove().appendTo('#selected_attr');
	});  

	$('#rm_attr').click(function() {  
		return !$('#selected_attr option:selected').remove().appendTo('#all_attr');
	});

});

function selectAllOptions(selStr) {

	var selObj = document.getElementById(selStr);

	for (var i = 0; i < selObj.options.length; i++) {
		selObj.options[i].selected = true;
	}
	
}

function makeId(divname) {
	return "#"+divname;
}

function wordCloud(filename, div) {

	var renderAt = makeId(div);

	var file = filename;
	var header = "";
	var content = "";

	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		// $.getJSON("http://visucosmos.info/"+file, function(data) {
		$.each(data, function(key, val) {
			$.each(val, function(key, val) {
				// console.log(val);
				content = content.concat(val.toString() + " ");	
			});
	});

	formatData(content);

	});

	
	function formatData(text)	{

		var data = text; 
		var dataarray = data.split(" ");
		var unique = [];
		
		$.each(dataarray, function(i, el){
			if($.inArray(el, unique) === -1) 
				unique.push(el);
		});


		window.setTimeout(createGraph(dataarray, unique), 50);
	}

	function createGraph(dataarray, unique)	{
		
		var datavalues = dataarray;
		var uniquevalues = unique;
		var counts = []; 
		

		for (var z = 0; z < uniquevalues.length; z++)	{
			counts[z] = 0; 
		}


		for(var i  = 0; i < datavalues.length; i++)	{
			for (var j = 0; j < uniquevalues.length; j++)	{
				if (datavalues[i] == uniquevalues[j]) {
					 counts[j]++;
				}
			}
		}

		uniquevalues.shift();
		counts.shift();

		// console.log(datavalues);
		// console.log(uniquevalues);
		// console.log(counts);

		var fill = d3.scale.category20();
		var width = 241;
		var height = 208;

			d3.layout.cloud().size([width, height])
				.words(d3.zip(uniquevalues, counts).map(function(d) {
				return {text: d[0], size: d[1]};
				}))
				.rotate(function() { return ~~(Math.random() * 2) * 90; })
				.font("Open Sans")
				.fontSize(function(d) { return d.size * 20; })
				.on("end", draw)
				.start();

		function draw(words) {
			d3.select(renderAt).append("svg")
					.attr("width", width)
					.attr("height", height)
					.attr("viewBox", "0 0 " + width + " " + height)
					.attr("preserveAspectRatio", "xMidYMid meet")
				.append("g")
					.attr("transform", "translate("+width/2+","+height/2+")")
				.selectAll("text")
					.data(words)
				.enter().append("text")
					.style("font-size", function(d) { return d.size + "px"; })
					.style("font-family", "Open Sans")
					.style("fill", function(d, i) { return fill(i); })
					.attr("text-anchor", "middle")
					.attr("transform", function(d) {
						return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
					})
					.text(function(d) { return d.text; });
		}
	}
}

function pieChart(filename, div) {

	var file = filename;
	var renderAt = makeId(div);

	d3.json("http://localhost/visucosmos-git/public_html/"+file,
		// d3.json("http://visucosmos.info/"+file,
		function (jsondata) {

		console.log(jsondata[0]);
		
		var attr;

		for(var key in jsondata[0]){
			attr = key;
		}

		var data = jsondata.map(function(d) { return d[attr]; });

		console.log(data);

		var width = 241, height = 248, radius = Math.min(width, height) / 2 - 10;

		var color = d3.scale.category20();

		var arc = d3.svg.arc()
				.outerRadius(radius);

		var pie = d3.layout.pie();

		var svg = d3.select(renderAt).append("svg")
				.datum(data)
				.attr("width", width)
				.attr("height", height)
			.append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		var arcs = svg.selectAll("g.arc")
				.data(pie)
			.enter().append("g")
				.attr("class", "arc");

		arcs.append("path")
				.attr("fill", function(d, i) { return color(i); })
			.transition()
				.ease("bounce")
				.duration(2000)
				.attrTween("d", tweenPie)
			.transition()
				.ease("elastic")
				.delay(function(d, i) { return 2000 + i * 50; })
				.duration(750)
				.attrTween("d", tweenDonut);

		function tweenPie(b) {
			b.innerRadius = 0;
			var i = d3.interpolate({startAngle: 0, endAngle: 0}, b);
			return function(t) { return arc(i(t)); };
		}

		function tweenDonut(b) {
			b.innerRadius = radius * .6;
			var i = d3.interpolate({innerRadius: 0}, b);
			return function(t) { return arc(i(t)); };
		}
	});
}

function barChart(filename, div) {
	var file = filename;
	var renderAt = makeId(div);

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
        width = 240 - margin.left - margin.right,
        height = 208 - margin.top - margin.bottom;

    var formatPercent = d3.format(".0");

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1, 1);

    var y = d3.scale.linear()
        .range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(formatPercent);

    var svg = d3.select(renderAt).append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

   	d3.json("http://localhost/visucosmos-git/public_html/"+file, function(data) { 
	      x.domain(data.map(function(d) { return d.attr3; }));
	      y.domain([0, d3.max(data, function(d) { return d.attr4; })]);

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
	          .text("Integer");

	      svg.selectAll(".bar")
	          .data(data)
	        .enter().append("rect")
	          .attr("class", "bar")
	          .attr("x", function(d) { return x(d.attr3); })
	          .attr("width", x.rangeBand())
	          .attr("y", function(d) { return y(d.attr4); })
	          .attr("height", function(d) { return height - y(d.attr4); });
	});
}
function locationPlot(filename, div) {

	var file = filename;
	
	var mapOptions = {
		zoom: 4,
		// center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById(div), mapOptions);

	document.getElementById(div).style.width = '241px';
	document.getElementById(div).style.height = '208px';

	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		// $.getJSON("http://visucosmos.info/"+file, function(data) {
		$.each(data, function(key, val) {
			$.each(val, function(key, val) {
				showAddress(val);
			});
		});
	});

	function showAddress(address) {

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode( { 'address': address }, function(results, status) {
				
			if (status == google.maps.GeocoderStatus.OK) {

				console.log('found', address)

				map.setCenter(results[0].geometry.location, 13);
				console.log(results[0]);
				var marker = new google.maps.Marker({
					position: results[0].geometry.location,
					map: map,
					animation: google.maps.Animation.DROP,
				});
			}

			else {
				console.log("Unable to find address: " + address);
			}
		});
	}
}

function coordPlot(filename, div) {

	var file = filename;
	
	var mapOptions = {
		zoom: 4,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById(div), mapOptions);

	document.getElementById(div).style.width = '241px';
	document.getElementById(div).style.height = '208px';


	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		// $.getJSON("http://visucosmos.info/"+file, function(data) {
			var lat, lon;

		$.each(data, function(key, val) {
			// $.each(val, function(key, val) {
				console.log('in');
				console.log(key, data[0]);

				$.each(val, function(key, d){
					console.log(key);
					console.log(val['attr6'] + ", " + val['attr7']);	
				});
				

				marker = new google.maps.Marker({
					position: google.maps.LatLng(val, val),
					map: map,
					animation: google.maps.Animation.DROP,
				});

			// });
		});
	});



}
function bubbleChart(filename, div) {
	console.log("this is being called");
	var renderAt = makeId(div);
	var file = filename;
	var header = "";
	var content = "";

	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		//$.getJSON("http://visucosmos.info/"+file, function(data) {
		$.each(data, function(key, val) {
			$.each(val, function(key, val) {
				console.log(val);
				content = content.concat(val.toString() + " ");	
			});
	});

	formatData(content);

	});

	
	function formatData(text)	{
		console.log("format being called");
		var data = text; 
		var dataarray = data.split(" ");
		var unique = [];
		
		$.each(dataarray, function(i, el){
			if($.inArray(el, unique) === -1) 
				unique.push(el);
		});


		window.setTimeout(createGraph(dataarray, unique), 50);
	}

	function createGraph(dataarray, unique)	{
		console.log("create graph being called");
		var datavalues = dataarray;
		var uniquevalues = unique;
		var counts = []; 
		

		for (var z = 0; z < uniquevalues.length; z++)	{
			counts[z] = 0; 
		}


		for(var i  = 0; i < datavalues.length; i++)	{
			for (var j = 0; j < uniquevalues.length; j++)	{
				if (datavalues[i] == uniquevalues[j]) {
					 counts[j]++;
				}
			}
		}

		uniquevalues.shift();
		counts.shift();

		createVis(uniquevalues, counts);

	}
	
	function createVis(uniquevalues, counts){
			console.log("create vis being called");
			var unique = uniquevalues;
			var count = counts; 
			var myjson = '[';

			for (var i = 0; i < unique.length; i++)
			{
				var uniquepart = '{"name":"' + unique[i] + '"';
				myjson += uniquepart; 
				var sizepart = ', "value":';
				myjson += sizepart;
				var countpart = count[i] + '';
				myjson += countpart;
				if (i == unique.length-1) {
					var notending = "}";
					myjson += notending;}
				else{
					var ending = "},";
					myjson += ending;}
			} 

			myjson += "]";

			console.log(myjson);

			var json = JSON.parse(myjson);

			var r = 248
			var bubble_layout = d3.layout.pack()
			    .sort(null) // HERE
			    .size([r,r])
			    .padding(1.5);

			var vis = d3.select(renderAt).append("svg")
			    .attr("width" , r)
			    .attr("height", r)

			var selection = vis.selectAll("g.node")
			              .data(bubble_layout.nodes({children: json}).filter(function(d) { return !d.children; }) ); 

			//Enter
			//HERE
			var node = selection.enter().append("g")
			              .attr("class", "node")
			              .attr("transform", function(d) { return "translate(" + d.x + ", " + d.y + ")"; }).filter(function(d){
			      return d.value > 0;
			    })  // HERE
			    
			node.append("circle")
			    .attr("r", function(d) { return d.r; })
			    .style("fill", function(d) { return 'aaaaaa'; });

			node.append("text")
			    .attr("text-anchor", "middle")
			    .attr("dy", ".3em")
			    .text(function(d) { return d.name; });
	}

}
function heatMap(filename, div) {

	var file = filename;
	var renderAt = makeId(div);
	var div = div; 

	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		// $.getJSON("http://visucosmos.info/"+file, function(data) {
		var myData = new Array(); 
		var lat = new Array(); 
		var lon = new Array();
		var weight = new Array();

		$.each(data, function(key, val) {
			// $.each(val, function(key, val) {
				$.each(val, function(key, d){
					if(val['attr7'] != "-" && val['attr6'] != "-")
					{
						lat.push(val['attr6']);
						lon.push(val['attr7']);
						weight.push(1);
					}	
				});
			// });
		});
		createVis(lat, lon, weight, div);
	});

	function createVis(lat, lon, weight, div) 
	{
		var myHeatmap = new GEOHeatmap();
		var myData = null;
		$(function() {
			// create data
			myData = new Array();
			for (p = 0; p < 50; p++) {
			 var rLatD = lat[p];
			 var rLonD = lon[p];
			 var rValD = weight[p];

			 myData.push(38.47 + (rLatD / 15000));
			 myData.push(-121.84 + (rLonD / 15000));
			 myData.push(rValD);
			}

			// configure HeatMapAPI
			myHeatmap.Init(241, 208); // set at pixels for your map
			myHeatmap.SetBoost(0.8);
			myHeatmap.SetDecay(0); // see documentation
			myHeatmap.SetData(myData);
			myHeatmap.SetProxyURL('http://www.yourwebsite.com/proxy.php');

			// set up Google map, pass in the heatmap function
			var myLatlng = new google.maps.LatLng(51.5171, 0.1062);
			var myOptions = {
			 zoom: 11,
			 center: myLatlng,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(document.getElementById(div), myOptions);
			google.maps.event.addListener(map, 'idle', function(event) {
			 myHeatmap.AddOverlay(this, myHeatmap);
			});
		});

	}
}
