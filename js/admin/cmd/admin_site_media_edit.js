$(function(){

	var frm = $('form.validate');
	formValidator(frm, [
		{name: 'title', label: 'Title', required: true}
	]);
	
	var type = frm.find('[name=type]');
	
	function update(){
		frm.find('.name-type').hide().filter('.value-'+type.val()).show();
	}
	type.change(update);
	update();

});

function prepareSize(container){
	
	var save_aspect_ratio = container.find('[name*="save_aspect_ratio"]');
	var enlarge_small_images = container.find('[name*="enlarge_small_images"]');
	var fit_small_images = container.find('[name*="fit_small_images"]');
	var fit_large_images = container.find('[name*="fit_large_images"]');
	var background_color = container.find('[name*="background_color"]');
	
	function update(){
		
		fit_small_images.closest('.form-field').hide();
		fit_large_images.closest('.form-field').hide();
		background_color.closest('.form-field').hide();
		
		if(!save_aspect_ratio.is(':checked')){
			if(enlarge_small_images.is(':checked')) fit_small_images.closest('.form-field').show();
			if(!enlarge_small_images.is(':checked') || fit_small_images.is(':checked') || fit_large_images.is(':checked')) background_color.closest('.form-field').show();
			fit_large_images.closest('.form-field').show();
		}
	
	}
	
	container.find(':input').change(update);
	update();
	
}
