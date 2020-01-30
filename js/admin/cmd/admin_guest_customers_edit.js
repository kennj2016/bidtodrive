$(function(){
	
	var frm = $('form.validate');
	formValidator(frm, [
		{name: 'name', label: 'Name', required: true},
		{name: 'email', label: 'Email', required: true, format: 'email'},
	]);
	
});