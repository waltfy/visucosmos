$().ready(function() {  
	
	$('#add_attr').click(function() {  

		return !$('#all_attr option:selected').remove().appendTo('#selected_attr');

	});  

	$('#rm_attr').click(function() {  

		return !$('#selected_attr option:selected').remove().appendTo('#all_attr');
	});

});  
