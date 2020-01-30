$(function(){
	
	if($('<div class="show-on-mobile">').appendTo('body').is(':visible')) return;
	
	var grid = $('.content .grid.sortable');
	
	grid.sortable({
		items: ".box",
		handle: ".title",
		scroll: false,
		tolerance: "pointer",
		update: function(event, ui){
			
			var tools = [];
			$('.title', grid).each(function(){
				tools.push($(this).text());
			});
			
			grid.sortable('disable');
			$.post('/admin/', {tools: tools}, function(response){
				if(response.has_error){
					defaultErrorPopup(response.status, 3);
				}else{
					grid.sortable('enable');
				}
			});
			
		}
	});
	
});