$(function(){
	
	$('body').on('click', '[data-action-view]', function(event){
		var content = $(event.target).attr('data-action-view');
		
		defaultPopup({
			message: content,
			addClass: 'xxlarge default-text',
			title: 'View Info'
		});
		
		return false;
	});
	
});