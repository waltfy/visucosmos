function wordCloud(filename)
{
	var file = filename;
	var text = " ";
  	$.getJSON(file, function(data) {
  		$.each(data, function(key, val) {
  			text = text.concat(val.toString() + " ");
  			
  		});
  		formatData(text);
	});


	function formatData(text)
	{
		var data = text; 
		var dataarray = data.split(" ");
		var unique = [];
		$.each(dataarray, function(i, el){
   		if($.inArray(el, unique) === -1) 
   			unique.push(el);
		});

		window.setTimeout(createGraph(dataarray, unique), 50);
	}
	function createGraph(dataarray, unique)
	{
		var datavalues = dataarray;
		var uniquevalues = unique;
		var counts = []; 

		for (var z = 0; z < uniquevalues.length; z++)
		{
			counts[z] = 0; 
		}


		for(var i  = 0; i < datavalues.length; i++)
		{
			for (var j = 0; j < uniquevalues.length; j++)
			{
				if (datavalues[i] == uniquevalues[j])
				{
					 counts[j]++;
				}
			}
		}

		uniquevalues.shift();
		counts.shift();

		console.log(datavalues);
		console.log(uniquevalues);
		console.log(counts);

		var fill = d3.scale.category20();

  		d3.layout.cloud().size([700, 500])
      	.words(d3.zip(uniquevalues, counts).map(function(d) {
  			return {text: d[0], size: d[1]};
		}))
      	.rotate(function() { return ~~(Math.random() * 2) * 90; })
      	.font("Impact")
      	.fontSize(function(d) { return d.size * 20; })
      	.on("end", draw)
      	.start();

  		function draw(words) {
		    d3.select("body").append("svg")
		        .attr("width", 700)
		        .attr("height", 500)
		      .append("g")
		        .attr("transform", "translate(350,250)")
		      .selectAll("text")
		        .data(words)
		      .enter().append("text")
		        .style("font-size", function(d) { return d.size + "px"; })
		        .style("font-family", "Impact")
		        .style("fill", function(d, i) { return fill(i); })
		        .attr("text-anchor", "middle")
		        .attr("transform", function(d) {
		          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
		        })
		        .text(function(d) { return d.text; });
		 }
 	}
 }