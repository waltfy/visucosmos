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

	// $.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		$.getJSON("http://visucosmos.info/"+file, function(data) {
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

	// d3.json("http://localhost/visucosmos-git/public_html/"+file,
		d3.json("http://visucosmos.info/"+file,
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
		width = 241 - margin.left - margin.right,
		height = 208 - margin.top - margin.bottom;

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

		var attr;

		for(var key in data[0]){
			attr = key;
		}

		data.forEach(function(d) {
			d[attr] = +d[attr];
		});

		x.domain(data.map(function(d) { return "d[key]"; }));
		y.domain([0, d3.max(data, function(d) { return d[attr]; })]);

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

	// $.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		$.getJSON("http://visucosmos.info/"+file, function(data) {
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


	// $.getJSON("http://localhost/visucosmos-git/public_html/"+file, function(data) {
		$.getJSON("http://visucosmos.info/"+file, function(data) {
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