$(function(){
	
	formValidator('form.validate', [
		{name: 'title', label: 'Title', required: true},
		{name: 'image', label: 'Image', required: true},
		{name: 'url', label: 'URL', format: 'url'}
	]);
	
});