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

function wordCloud(filename, div, width, height) {

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

function pieChart(filename, div, width, height) {

	var file = filename;
	var renderAt = makeId(div);

	width = $('#'+div).parent().width();
	height = width;

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

		radius = Math.min(width, height) / 2 - 10;

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

function barChart(filename, div, width, height) {

	var file = filename;
	var renderAt = makeId(div);

	var margin = {top: 20, right: 20, bottom: 30, left: 40},
		width = width - margin.left - margin.right,
		height = height - margin.top - margin.bottom;

	var formatPercent = d3.format(".0%");

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

	d3.json("http://localhost/visucosmos-git/public_html/"+file, function(error, data) {
	// d3.json("http://visucosmos.info/"+file, function(error, data) {	
		var attr;

		data.forEach(function(d) {
			d[attr] = +d[attr];
		});

		x.domain(data.map(function(d) { return d[0]; }));
		y.domain([0, d3.max(data, function(d) { return d[1]; })]);

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
				.text("Frequency");

		svg.selectAll(".bar")
				.data(data[0][attr])
			.enter().append("rect")
				.attr("class", "bar")
				.attr("x", function(d) { return x(d.letter); })
				.attr("width", x.rangeBand())
				.attr("y", function(d) { return y(d.frequency); })
				.attr("height", function(d) { return height - y(d.frequency); });

		d3.select("input").on("change", change);

		var sortTimeout = setTimeout(function() {
			d3.select("input").property("checked", true).each(change);
		}, 2000);

		function change() {
			clearTimeout(sortTimeout);

			// Copy-on-write since tweens are evaluated after a delay.
			var x0 = x.domain(data.sort(this.checked
					? function(a, b) { return b.frequency - a.frequency; }
					: function(a, b) { return d3.ascending(a.letter, b.letter); })
					.map(function(d) { return d.letter; }))
					.copy();

			var transition = svg.transition().duration(750),
					delay = function(d, i) { return i * 50; };

			transition.selectAll(".bar")
					.delay(delay)
					.attr("x", function(d) { return x0(d.letter); });

			transition.select(".x.axis")
					.call(xAxis)
				.selectAll("g")
					.delay(delay);
		}
	});
}

function locationPlot(filename, div, width, height) {

	var file = filename;
	
	var mapOptions = {
		zoom: 4,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: true,
    draggable: true,
	};

	var map = new google.maps.Map(document.getElementById(div), mapOptions);
	var stringWidth = $('#'+div).parent().width() - 3 + "px";
	var stringHeight = stringWidth;

	document.getElementById(div).style.width = stringWidth;
	$('#'+div).css('padding-bottom', stringWidth);
	// document.getElementById(div).style.height = stringHeight;

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

function coordPlot(filename, div, width, height) {

	var file = filename;

	var stringWidth = $('#'+div).parent().width() + "px";

	var mapOptions = {
		zoom: 4,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: true,
    draggable: true
	};

	var map = new google.maps.Map(document.getElementById(div), mapOptions);
	
	// console.log(document.getElementById(div));

	$('#'+div).css('width', stringWidth);
	$('#'+div).css('padding-bottom', stringWidth);

	// $.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
	// 	// $.getJSON("http://visucosmos.info/"+file, function(data) {
	// 	$.each(data, function(key, val) {
	// 		if (key > 4) { return }; // Remember to remove this.
	// 		console.log(val['Latitude'] + ", " + val['Longitude']);
			
	// 		marker = new google.maps.Marker({
	// 			position: google.maps.LatLng(val['Latitude'], val['Longitude']),
	// 			map: map,
	// 			animation: google.maps.Animation.DROP,
	// 		});

	// 	});
	// });
}

function bubbleChart(filename, div, width, height) {

	// console.log("this is being called");
	var renderAt = makeId(div);
	var file = filename;
	var header = "";
	var content = "";

	$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		//$.getJSON("http://visucosmos.info/"+file, function(data) {
		$.each(data, function(key, val) {
			$.each(val, function(key, val) {
				// console.log(val);
				content = content.concat(val.toString() + " ");	
			});
	});

	formatData(content);

	});

	
	function formatData(text)	{
		// console.log("format being called");
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
		// console.log("create graph being called");
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

		createVis(uniquevalues, counts, width, height);

	}
	
	function createVis(uniquevalues, counts, w, h) {
		
		// console.log("create vis being called");
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

			// console.log(myjson);

			var json = JSON.parse(myjson);

			var height = h;
			var width = w 
			var bubble_layout = d3.layout.pack()
					.sort(null) // HERE
					.size([width,height]);
					// .padding(1.5);

			var vis = d3.select(renderAt).append("svg")
					.attr("width" , width)
					.attr("height", height)

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
					.style("fill", function(d) { return 'f44'; });

			node.append("text")
					.attr("text-anchor", "middle")
					.attr("style", "font-size: 0.5em;")
					.text(function(d) { return d.name; });
	}

}

function heatMap(filename, div, width, height) {

	var file = filename;
	var renderAt = makeId(div);

	width-=25;
	var stringWidth = width + "px";
	var stringHeight = height + "px";

	document.getElementById(div).style.width = stringWidth;
	document.getElementById(div).style.height = stringHeight;

    var myLatlng = new google.maps.LatLng(51.517, 0.1062);
    // define map properties
    var myOptions = {
      zoom: 5,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: false,
      scrollwheel: true,
      draggable: true,
      navigationControl: true,
      mapTypeControl: false,
      scaleControl: true,
      disableDoubleClickZoom: true
    };
    // we'll use the heatmapArea 
    var map = new google.maps.Map($(renderAt)[0], myOptions);
    
    // let's create a heatmap-overlay
    // with heatmap config properties
    var heatmap = new HeatmapOverlay(map, {
        "radius":20,
        "visible":true, 
        "opacity":60
    });
 
    // here is our dataset
    // important: a datapoint now contains lat, lng and count property!
    
    var testData = getData(file); 

 
    // now we can set the data
    google.maps.event.addListenerOnce(map, "idle", function(){
        // this is important, because if you set the data set too early, the latlng/pixel projection doesn't work
        heatmap.setDataSet(testData);
    });
 
 	function getData(file)
 	{
 		var topJsonArray = {
			max: 46,
			data: []};

		$.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		// $.getJSON("http://visucosmos.info/"+file, function(data) {
			$.each(data, function(key, val) {
				// $.each(val, function(key, val) {
				if(val['Latitude'] != "-"){
					topJsonArray.data.push({lat : val['Latitude'], lng: val['Longitude'], count: 30});
				}	
				// });
			});
 		});

 		// console.log(topJsonArray);
 		return topJsonArray; 
 	}
}

$(window).on("load", function() {
		var aspect = 960 / 500;
		$charts = $('svg');
    var targetWidth = $charts.parent().width();
    $charts.attr("width", targetWidth);
    $charts.attr("padding-bottom", targetWidth);
});

$(window).on("resize", function() {
		var aspect = 960 / 500;
		$charts = $('svg');
    var targetWidth = $charts.parent().width();
    $charts.attr("width", targetWidth);
    $charts.attr("padding-bottom", targetWidth);
});

function show_svg_code() {
	// Get the d3js SVG element
	var tmp  = document.getElementById("graph_place");
	var svg = tmp.getElementsByTagName("svg")[0];

	// Extract the data as SVG text string
	var svg_xml = (new XMLSerializer).serializeToString(svg);

	//Optional: prettify the XML with proper indentations
	svg_xml = vkbeautify.xml(svg_xml);

	// Set the content of the <pre> element with the XML
	$(".svg_code pre").text(svg_xml);

	//Optional: Use Google-Code-Prettifier to add colors.
	prettyPrint();
	return svg_xml;
}

function generate_svg() {
	var html = d3.select("svg")
        .attr("title", "test2")
        .attr("version", 1.1)
        .attr("xmlns", "http://www.w3.org/2000/svg")
        .node().parentNode.innerHTML;
	d3.select("body").append("small")
        .attr("id", "download")
        .append("img")
        .attr("src", "data:image/svg+xml;base64,"+ btoa(html));
}