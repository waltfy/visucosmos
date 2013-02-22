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

function wordCloud(filename) {
	console.log("wordCloud is being called");

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
			d3.select("#render").append("svg")
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