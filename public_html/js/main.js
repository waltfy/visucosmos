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