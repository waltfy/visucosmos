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

	$.getJSON("http://localhost/visucosmos-git/"+file, function(data) {
		// $.getJSON("http://www.visucosmos.info/"+file+"&callback=?", function(data) {

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

function barChart(filename, div) {

	var renderAt = makeId(div);

	$.getJSON("http://localhost/visucosmos-git/"+file, function(data) {
		// $.getJSON("http://www.visucosmos.info/"+file+"&callback=?", function(data) {

		$.each(data, function(key, val) {
			$.each(val, function(key, val) {
				console.log(val);
				// content = content.concat(val.toString() + " ");	
			});
		});

		formatData(content);

	});

	// var margin = {top: 20, right: 20, bottom: 30, left: 40},
	// 	width = 960 - margin.left - margin.right,
	// 	height = 500 - margin.top - margin.bottom;

	// var formatPercent = d3.format(".0%");

	// var x = d3.scale.ordinal()
	// 		.rangeRoundBands([0, width], .1);

	// var y = d3.scale.linear()
	// 		.range([height, 0]);

	// var xAxis = d3.svg.axis()
	// 		.scale(x)
	// 		.orient("bottom");

	// var yAxis = d3.svg.axis()
	// 		.scale(y)
	// 		.orient("left")
	// 		.tickFormat(formatPercent);

	// var svg = d3.select("body").append("svg")
	// 		.attr("width", width + margin.left + margin.right)
	// 		.attr("height", height + margin.top + margin.bottom)
	// 	.append("g")
	// 		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	// d3.tsv("data.tsv", function(error, data) {

	// 	data.forEach(function(d) {
	// 		d.frequency = +d.frequency;
	// 	});

	// 	x.domain(data.map(function(d) { return d.letter; }));
	// 	y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

	// 	svg.append("g")
	// 			.attr("class", "x axis")
	// 			.attr("transform", "translate(0," + height + ")")
	// 			.call(xAxis);

	// 	svg.append("g")
	// 			.attr("class", "y axis")
	// 			.call(yAxis)
	// 		.append("text")
	// 			.attr("transform", "rotate(-90)")
	// 			.attr("y", 6)
	// 			.attr("dy", ".71em")
	// 			.style("text-anchor", "end")
	// 			.text("Frequency");

	// 	svg.selectAll(".bar")
	// 			.data(data)
	// 		.enter().append("rect")
	// 			.attr("class", "bar")
	// 			.attr("x", function(d) { return x(d.letter); })
	// 			.attr("width", x.rangeBand())
	// 			.attr("y", function(d) { return y(d.frequency); })
	// 			.attr("height", function(d) { return height - y(d.frequency); });

	// });
}