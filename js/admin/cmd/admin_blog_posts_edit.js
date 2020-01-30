$(function(){

	formValidator('form.validate', [
		{name: 'title', label: 'Title', required: true},
		{name: 'category_id', label: 'Category', required: true},
		{name: 'description', label: 'Description', required: true}
	]);
	
});