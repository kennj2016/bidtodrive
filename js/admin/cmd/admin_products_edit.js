$(function(){
	
	var frm = $('form.validate');
	var hasVariations = frm.find('[name=has_variations]');
	var variationsWrap = frm.find('.variations_wrap');

	formValidator(frm, [
		{name: 'category_id', label: 'Category', required: true},
		{name: 'sku', label: 'SKU', required: true},
		{name: 'title', label: 'Title', required: true},
		{name: 'price', label: 'Price', required: true, format: 'usfloat'}
	]);
	
	function toggleVariations(){
		variationsWrap[hasVariations.val() == 1 ? 'show' : 'hide']();
	}
	hasVariations.change(toggleVariations);
	toggleVariations();
	
});