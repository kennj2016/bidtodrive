$(function(){
	
	formValidator('form.validate', [
		{name: 'old_url', label: 'Old URL', required: true},
		{name: 'new_url', label: 'New URL', required: true}
	]);
	
});