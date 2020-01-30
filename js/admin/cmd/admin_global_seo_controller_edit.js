$(function(){
	
	formValidator('form.validate', [
		{name: 'text', label: 'Text', required: true},
		{name: 'url', label: 'URL', required: true}
	]);
	
});